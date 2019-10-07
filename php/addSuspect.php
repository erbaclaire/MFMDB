<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add a Suspect Discussed on My Favorite Murder:</center></font></div>
  <style>
    table {
    font-family: didot;
    font-size: 25;
    border-collapse: collapse;
    width: 40%;
    }

    td, th {
    border: 1px solid dimgray;
    text-align: left;
    padding: 8px;
    }

    tr:nth-child(even) {
    background-color: #dddddd;
    }
  </style>
</head>

<body style="font-family:didot;">
  <br/>
  <br/>
  <br/>

  <div align="center" style="font-size:40;">
    <font color="red">
    
      <?php
      
	     //connection information
       $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
       $username = 'karenandgeorgia';
       $password = 'stevensmustache';
       $database = 'mfmdb';
	 
	     //connect to database
	     $dbcon = mysqli_connect($host, $username, $password, $database)
	     or die('Could not connect: ' . mysqli_connect_error());
	 
	     //get input
	     $CCN = str_replace("'", "''", $_REQUEST['ccn']);
	     $CCN_formatted = str_replace("''", "'", $CCN);
	     $CN =  $_REQUEST['crimes'];
       $FN = str_replace("'", "''", $_REQUEST['FName']);
       $MN = str_replace("'", "''", $_REQUEST['MName']);
	     $LN =  str_replace("'", "''", $_REQUEST['LName']);
       $Age =  $_REQUEST['Age'];
       $Gender =  $_REQUEST['gender'];
       $Race =  $_REQUEST['race'];
	     $Motive =  str_replace("'", "''", $_REQUEST['Motive']);
	     $Alibi =  str_replace("'", "''", $_REQUEST['Alibi']);
	     $CD =  $_REQUEST['ChargeDate'];
	     $HR = $_REQUEST['HasRel'];
	     $R = str_replace("'", "''", $_REQUEST['Rel']);

	     //validation that non-null fields are filled in
	     if ($CCN == 'psac' || trim($CCN)=='') {
	     die("FAILED!<br>You must select a case.");
	     }
	     if ($CN == 'psac' || trim($CN)=='') {
	     die("FAILED!<br>You must select a crime.");
	     }
	     if ($CN == 'null') {
	     die("FAILED!<br>There are no crimes for this case. You must add the crime before you can add suspects to the crime.");
	     }
	     if (!isset($LN) || trim($LN)==''){
       die("FAILED!<br>You must enter the suspect's last name. If the suspect is a corporation, please enter the corporation's name as the last name.");
       }
       if (!isset($Motive) || trim($Motive)==''){
       die("FAILED!<br>You must enter the suspect's motive.");
       }
	     $are_victims = "SELECT * FROM Victim WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN";
	     $query_arevictims = mysqli_query($dbcon, $are_victims) or die("FAILED! ".mysqli_error($dbcon));
	     if ($query_arevictims->num_rows > 0) {
	     if (!isset($HR) || trim($HR)==''){
	     die("FAILED!<br>You must enter the victim numbers that the suspect has a relationship to in list form, even if the relationship is that the suspect is a stranger to the victim.");
	     }
	     if (!isset($R) || trim($R)==''){
	     die("FAILED!<br>You must enter the relationships between the victims and suspects in list form.");
	     }
       }
      
       //validation that fields are correct types (int, string, date etc.)
       if (trim($Age)!='' && !is_numeric($Age)) {
       die("FAILED!<br>The suspect's age must be entered as a number. Please re-enter the data in the correct format.");
       }
	     function validateDate($date, $format = 'Y-m-d') {
	     $d = DateTime::createFromFormat($format, $date);
	     return $d && $d->format($format) === $date;
       }
       if (trim($CD)!='' && (!validateDate($CD) || $CD > date('Y-m-d'))) {
       die("FAILED!<br>The Charge Date must be of the format YYYY-MM-DD and cannot be past today's date. Please re-enter the data in the correct format.");
       }
       $date_check = "SELECT StartDate FROM Crime WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN";
       $query_date_check = mysqli_query($dbcon, $date_check) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_date_check);
       if (trim($CD)!='' && ($CD < $row[0])) {
	     die("FAILED!<br>The Charge Date cannot be before the Crime Start Date.");
       }

       //validation that the victim/relationship list is balanced 
       $victim_list = explode(",", $HR);
       $rel_list = explode(",", $R);
	     if (sizeof($victim_list) != sizeof($rel_list)) {
	     die("FAILED!<br>The number of victims listed does not match the number of realtionships listed.<br>Please check your input and make sure the lists match up.");
	     }
				     
	     //make Age null if blank
	     if (trim($Age)=='') {
	     $Age = "NULL";
	     }
				     
	     //insert new suspect
	     $next_sn = "SELECT MAX(SuspectNo) FROM Suspect WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN";
       $query_next_sn = mysqli_query($dbcon, $next_sn) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_next_sn);
       if ($query_next_sn->num_rows > 0) {
       $next_sn = $row[0] + 1;
       }   
       else {
       $next_sn = 1;
       }
	     $insert = "INSERT INTO Suspect(CaseColloquialName, CrimeNo, SuspectNo, FirstName, MiddleName, LastName, Age, Gender, Race, Motive, Alibi)
 		              VALUES('$CCN', $CN, $next_sn, NULLIF('$FN',''), NULLIF('$MN',''), NULLIF('$LN',''), $Age, NULLIF('$Gender','select'), NULLIF('$Race','select'), '$Motive', NULLIF('$Alibi',''))";
       $result = mysqli_query($dbcon, $insert) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_free_result($result);

	     //validation that the victims that suspect has a relationship to are already in the Victim table, otherwise there will be a FK error
       $counter = 0;
	     if ($query_arevictims->num_rows > 0) {
	     foreach ($victim_list as $victim) {
	     $check = "SELECT * FROM Victim WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND VictimNo = $victim";
	     $check_result =  mysqli_query($dbcon, $check) or die("FAILED! ".mysqli_error($dbcon));
	     if ($check_result->num_rows > 0) {
	     $insert2 = "INSERT INTO SuspectHasRelationshipToVictim(CaseColloquialNameS, CrimeNoS, SuspectNo, CaseColloquialNameV, CrimeNoV, VictimNo, Relationship)
                    VALUES('$CCN', $CN, $next_sn, '$CCN', $CN, $victim,'".trim($rel_list[$counter])."')";
	     $result2 =  mysqli_query($dbcon, $insert2) or die("FAILED! ".mysqli_error($dbcon));
	     $counter = $counter + 1;
	     }
 	     else {
	     $delete = "DELETE FROM Suspect WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $next_sn";
	     $result3 =  mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
	     die("FAILED!<br>Victim ".$victim." of ".$CCN_formatted." - Crime ".$CN." is not in the database.<br>Please add the victim to the victim table first. You can do this by navigating to the Victims page via the Main Menu.");
	    }
	    }
	    }

	    //add the suspect to the charged table if there is a charge date
	    if (trim($CD) != '') {
	    $insert3 = "INSERT INTO Charged(CaseColloquialName, CrimeNo, SuspectNo, ChargeDate)
	                VALUES('$CCN', $CN, $next_sn, '$CD')";
	    $result4 = mysqli_query($dbcon, $insert3) or die("FAILED! ".mysqli_error($dbcon));
	    }
	
	    //query to later display results
      $query = "SELECT * FROM Suspect WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $next_sn";
      $result5 = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error(dbcon));
      
    ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
        echo("Succeeded!<br>Suspect ".$next_sn." of ".$CCN_formatted." - Crime ".$CN." was added with the following information.");
	      echo("<br>");
	      echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show that the suspect was added.
       $row = mysqli_fetch_row($result5);
       echo "<table>";
       echo "<tr><td>Case Name:</td><td>".$row[0]."</td></tr>";
       echo "<tr><td>Crime Number:</td><td>".$row[1]."</td></tr>";
       echo "<tr><td>Suspect Number:</td><td>".$row[2]."</td></tr>";
       echo "<tr><td>First Name:</td><td>".$row[3]."</td></tr>";
       echo "<tr><td>Middle Name:</td><td>".$row[4]."</td></tr>";
       echo "<tr><td>LastName:</td><td>".$row[5]."</td></tr>";
       echo "<tr><td>Gender:</td><td>".$row[6]."</td></tr>";
       echo "<tr><td>Race:</td><td>".$row[7]."</td></tr>";
       echo "<tr><td>Age:</td><td>".$row[8]."</td></tr>";
       echo "<tr><td>Motive:</td><td>".$row[9]."</td></tr>";
       echo "<tr><td>Alibi:</td><td>".$row[10]."</td></tr>";
       echo "<tr><td>Has Relationships To Victims:</td><td>".$HR."</td></tr>";
       echo "<tr><td>The Realtionships To The Above Victims:</td><td>".$R."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
