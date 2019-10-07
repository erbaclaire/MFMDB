<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add a Victim Discussed on My Favorite Murder:</center></font></div>
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
       $Harm =  str_replace("'", "''", $_REQUEST['Harm']);
       $Gender =  $_REQUEST['gender'];
       $Race =  $_REQUEST['race'];

	     //validation that non-null fields are filled in
	     if ($CCN == 'psac' || trim($CCN)=='') {
	     die("FAILED!<br>You must select a case.");
	     }
	     if ($CN == 'psac' || trim($CN)=='') {
	     die("FAILED!<br>You must select a crime.");
	     }
	     if ($CN == 'null') {
	     die("FAILED!<br>There are no crimes for this case. You must add the crime before you can add victims to the crime.");
	     }
       if (!isset($FN) || trim($FN)==''){
       die("FAILED!<br>You must enter the victim's first name.");
       }
	     if (!isset($LN) || trim($LN)==''){
	     die("FAILED!<br>You must enter the victim's last name.");
	     }
	     if (!isset($Age) || trim($Age)==''){
	     die("FAILED!<br>You must enter the victim's age. Approximate ages for Jane and John Does are fine.");
	     }
	     if ($Race=='select' || trim($Race)==''){
	     die("FAILED!<br>You must enter the victim's race.");
	     }
	     if ($Gender=='select' || trim($Race)==''){
	     die("FAILED!<br>You must enter the victim's gender.");
	     }
	     if (!isset($Harm) || trim($Harm)==''){
	     die("FAILED!<br>You must enter what harm befell the victim.");
	     }

       //validation that fields are correct types (int, string, date, etc.)
       if (!is_numeric($Age)) {
       die("FAILED!<br>Victim age must be entered as a number. Please re-enter the data in the correct format.");
       }

	     //insert new victim
	     $next_vn = "SELECT MAX(VictimNo) FROM Victim WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN";
       $query_next_vn = mysqli_query($dbcon, $next_vn) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_next_vn);
       if ($query_next_vn->num_rows > 0) {
       $next_vn = $row[0] + 1;
       }   
       else {
       $next_vn = 1;
       }
       $insert = "INSERT INTO Victim(CaseColloquialName, CrimeNo, VictimNo, FirstName, MiddleName, LastName, Age, Gender, Race, Harm)
		              VALUES('$CCN', $CN, $next_vn, '$FN', NULLIF('$MN',''), '$LN', $Age, '$Gender', '$Race', '$Harm')";
       $result = mysqli_query($dbcon, $insert) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_free_result($result);

      // query to later display results
      $query = "SELECT * FROM Victim WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND VictimNo = $next_vn";
      $result2 = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
    ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
        echo("Succeeded!<br>Victim ".$next_vn." of ".$CCN_formatted." - Crime ".$CN." was added with the following information.");
	      echo("<br>");
	      echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show that the victim was added.
       $row = mysqli_fetch_row($result2);
       echo "<table>";
       echo "<tr><td>Case Name:</td><td>".$row[0]."</td></tr>";
       echo "<tr><td>Crime Number:</td><td>".$row[1]."</td></tr>";
       echo "<tr><td>Victim Number:</td><td>".$row[2]."</td></tr>";
       echo "<tr><td>First Name:</td><td>".$row[3]."</td></tr>";
       echo "<tr><td>Middle Name:</td><td>".$row[4]."</td></tr>";
       echo "<tr><td>Last Name:</td><td>".$row[5]."</td></tr>";
       echo "<tr><td>Gender:</td><td>".$row[6]."</td></tr>";
       echo "<tr><td>Race:</td><td>".$row[7]."</td></tr>";
       echo "<tr><td>Age:</td><td>".$row[8]."</td></tr>";
       echo "<tr><td>Harm:</td><td>".$row[9]."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
