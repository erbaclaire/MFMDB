<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add Evidence Discussed on My Favorite Murder:</center></font></div>
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
	       $Type =  $_REQUEST['Etype'];
         $Item = str_replace("'", "''", $_REQUEST['Item']);
         $Desc = str_replace("'", "''", $_REQUEST['Desc']);
	       $Pic =  str_replace("'", "''", $_REQUEST['Pic']);
         $Video =  str_replace("'", "''", $_REQUEST['Video']);
         $Implicates =  $_REQUEST['Implicates'];

	       //validation that non-null fields are filled in
	       if ($CCN == 'psac' || trim($CCN)=='') {
	       die("FAILED!<br>You must select a case.");
	       }
	       if ($CN == 'psac' || trim($CN)=='') {
	       die("FAILED!<br>You must select a crime.");
	       }
	       if ($CN == 'null') {
	       die("FAILED!<br>There are no crimes for this case. You must add the crime before you can add evidence to the crime.");
	       }
         if ($Type == 'select' || trim($Type)==''){
         die("FAILED!<br>You must select the type of evidence.");
         }
	       if (!isset($Item) || trim($Item)==''){
	       die("FAILED!<br>You must enter the evidence item name.");
	       }
	       if (!isset($Desc) || trim($Desc)==''){
	       die("FAILED!<br>You must enter a description of the evidence item.");
	       }

	       //make values NULL if empty and allowed to be empty
	       $null_var_array = array($Pic, $Video);
	       foreach ($null_var_array as $var) {
	       if (trim($var == '')) {
	       $var = "NULL";
	       }
	       }
	 
	       //insert new evidence
	       $next_en = "SELECT MAX(EvidenceItemNo) FROM Evidence WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN";
         $query_next_en = mysqli_query($dbcon, $next_en) or die("FAILED! ".mysqli_error($dbcon));
         $row = mysqli_fetch_row($query_next_en);
         if ($query_next_en->num_rows > 0) {
         $next_en = $row[0] + 1;
         }   
         else {
         $next_en = 1;
         }
	       $insert = "INSERT INTO Evidence(CaseColloquialName, CrimeNo, EvidenceItemNo, EType, Item, Description, Picture, Video)
	 	                VALUES('$CCN', $CN, $next_en, '$Type', '$Item', '$Desc', NULLIF('$Pic',''), NULLIF('$Video',''))";
         $result = mysqli_query($dbcon, $insert) or die("FAILED! ".mysqli_error($dbcon));
         mysqli_free_result($result);

	       //validation that the suspects that are implicated by the evidence are already in the Victim table, otherwise there will be a FK error
         if (trim($Implicates) != '') {
         $suspect_list = explode(",", $Implicates);
	       foreach ($suspect_list as $suspect) {
	       $check = "SELECT * FROM Suspect WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $suspect";
	       $check_result = mysqli_query($dbcon, $check) or die("FAILED! ".mysqli_error($dbcon));
         if ($check_result->num_rows > 0) {
	       $insert2 = "INSERT INTO EvidenceImplicatesSuspect(CaseColloquialNameE, CrimeNoE, EvidenceItemNo, CaseColloquialNameS, CrimeNoS, SuspectNo)
                     VALUES('$CCN', $CN, $next_en, '$CCN', $CN, $suspect)";
	       $result2 =  mysqli_query($dbcon, $insert2) or die("FAILED!".mysqli_error($dbcon));
	       }
	       else {
         $delete = "DELETE FROM Evidence WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND EvidenceItemNo = $next_en";
	       $result3 =  mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
	       die("FAILED!<br>Suspect ".$suspect." of ".$CCN_formatted." - Crime ".$CN." is not in the database.<br>Please add the suspect to the suspect table first. You can do this by navigating to the Evidence page via the Main Menu.");
	       }
	       }
         }

         // query to later display results
         $query = "SELECT * FROM Evidence WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND EvidenceItemNo = $next_en";
         $result4 = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
      ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php  
        echo("Succeeded!<br>Evidence Item ".$next_en." of ".$CCN_formatted." - Crime ".$CN." was added with the following information.");
	      echo("<br>");
	      echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show that the suspect was added.
       $row = mysqli_fetch_row($result4);
       echo "<table>";
       echo "<tr><td>Case Name:</td><td>".$row[0]."</td></tr>";
       echo "<tr><td>Crime Number:</td><td>".$row[1]."</td></tr>";
       echo "<tr><td>Evidence Item Number:</td><td>".$row[2]."</td></tr>";
       echo "<tr><td>Evidence Type:</td><td>".$row[3]."</td></tr>";
       echo "<tr><td>Evidence Item:</td><td>".$row[4]."</td></tr>";
       echo "<tr><td>Evidence Description:</td><td>".$row[5]."</td></tr>";
       echo "<tr><td>Evidence Picture:</td><td>".$row[6]."</td></tr>";
       echo "<tr><td>Evidence Video:</td><td>".$row[7]."</td></tr>";
       echo "<tr><td>The Added Evidence Implicates Suspects:</td><td>".$Implicates."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
