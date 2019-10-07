<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add a Crime Discussed on My Favorite Murder:</center></font></div>
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

	     //Connection information
       $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
       $username = 'karenandgeorgia';
       $password = 'stevensmustache';
       $database = 'mfmdb';
	 
	     //connect to database
	     $dbcon = mysqli_connect($host, $username, $password, $database)
	    or die('Could not connect: ' . mysqli_connect_error());

	     //get input
	     $CCN = str_replace("'", "''", $_REQUEST['Case']);
	     $CCN_formatted = str_replace("''", "'", $CCN);
	     $CrimeName =  str_replace("'", "''", $_REQUEST['CrimeName']);
       $Start = $_REQUEST['CrimeStart'];
       $End = $_REQUEST['CrimeEnd'];
	     $LocDesc =  str_replace("'", "''", $_REQUEST['LocDesc']);
       $Street =  str_replace("'", "''", $_REQUEST['Street']);
       $City =  str_replace("'", "''", $_REQUEST['City']);
       $State =  str_replace("'", "''", $_REQUEST['State']);
       $Zip =  str_replace("'", "''", $_REQUEST['Zip']);
       $Country =  str_replace("'", "''", $_REQUEST['Country']);
       $Weapons =  str_replace("'", "''", $_REQUEST['Weapons']);
	     $Weapons_formatted =  str_replace("''", "'", $Weapons);
       $Solv =  $_REQUEST['Solved'];

	     //validation that non-null fields are filled in
	     if ($CCN == 'psac' || trim($CCN)=='') {
	     die("FAILED!<br>You must select a case.");
	     }
       if (!isset($CrimeName) || trim($CrimeName)==''){
       die("FAILED!<br>You must enter a Crime Name.");
       }
	     if (!isset($Start) || trim($Start)==''){
	     die("FAILED!<br>You must indicate the date the crime started");
	     }
	     if (!isset($End) || trim($End)==''){
	     die("FAILED!<br>You must indicate the date the crime ended. This is often the same as the date the crime started.");
	     }
       if (!isset($City) || trim($City)==''){
       die("FAILED!<br>You must enter a City.");
       }
       if (!isset($State) || trim($State)==''){
       die("FAILED!<br>You must enter a State.");
       }
       if (!isset($Country) || trim($Country)==''){
       die("FAILED!<br>You must enter a Country.");
       }
       if ($Solv == 'select' || trim($Solv)=='') {
       die("FAILED!<br>You must indicate whether the crime was solved or not.");
       }     
	 
       //validation that fields are correct types (int, string, etc.)
       if (trim(strlen($State)) != 2) {
       die("FAILED!<br>The State must be of the format, AL, CA, ON, etc. Please re-enter the data in the correct format.");
       }
       if (trim(strlen($Country)) != 2) {
       die("FAILED!<br>The Country must be of the format, US, CA, MX, etc. Please re-enter the data in the correct format.");
       }
       function validateDate($date, $format = 'Y-m-d') {
       $d = DateTime::createFromFormat($format, $date);
       return $d && $d->format($format) === $date;
       }
       if (!validateDate($Start) || $Start > date('Y-m-d')) {
       die("FAILED!<br>The Crime Start Date must be of the format YYYY-MM-DD and cannot be past today's date. Please re-enter the data in the correct format.");
       }
       if (!validateDate($End) || $End > date('Y-m-d') || $End < $Start) {
       die("FAILED!<br>The Crime End Date must be of the format YYYY-MM-DD and cannot be past today's date or before the Crime Start Date. Please re-enter the data in the correct format.");
       }

	     //insert new crime
       $next_cn = "SELECT MAX(CrimeNo) FROM Crime WHERE CaseColloquialName = '$CCN'";
       $query_next_cn = mysqli_query($dbcon, $next_cn) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_next_cn);
       if ($query_next_cn->num_rows > 0) {
       $next_cn = $row[0] + 1;
       }
       else {
       $next_cn = 1;
       }
       if ($Solv == 'Yes') {
       $Solv2 = 1;
       }
       else {
       $Solv2 = 0;
       }
       $insert = "INSERT INTO Crime(CaseColloquialName, CrimeNo, CrimeName, StartDate, EndDate, LocDesc, Street, City, State_Territory, Zip, Country, Solved)
	                VALUES('$CCN', $next_cn, '$CrimeName', '$Start', '$End', NULLIF('$LocDesc',''), NULLIF('$Street',''), '$City', '$State', NULLIF('$Zip',''), '$Country', $Solv2)";
       $result = mysqli_query($dbcon, $insert) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_free_result($result);

       //add the weapon(s) used if not already in the database and then add weapon/crime combination in to the CrimeCarriedOutWithWeapon
       if (trim($Weapons) != '') {
       $weapons_list = explode(",", $Weapons);
       foreach ($weapons_list as $weapon) {
	     $weapon = trim($weapon);
       $check = "SELECT * FROM Weapon WHERE WeaponName = '$weapon'";
       $check_result =  mysqli_query($dbcon, $check) or die("FAILED! ".mysqli_error($dbcon));
       if ($check_result->num_rows == 0) {
       $insert2 = "INSERT INTO Weapon(WeaponName)
                   VALUES('$weapon')";
       $result2 =  mysqli_query($dbcon, $insert2) or die("FAILED! ".mysqli_error($dbcon));
       }
       $weapon_id = "SELECT WeaponID FROM Weapon WHERE WeaponName = '$weapon'";
       $result3 =  mysqli_query($dbcon, $weapon_id) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($result3);
       $insert3 = "INSERT INTO CrimeCarriedOutWithWeapon(CaseColloquialName, CrimeNo, WeaponID)
                   VALUES('$CCN', $next_cn,".$row[0].")";
       $result4 =  mysqli_query($dbcon, $insert3) or die("FAILED! ".mysqli_error($dbcon));
       }
       }
	
       // query to later display results
       $query = "SELECT * FROM Crime WHERE CaseColloquialName = '$CCN' AND CrimeNo = $next_cn";
       $result5 = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
      
      ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
	    
        echo("Succeeded!<br>Crime ".$next_cn." of ".$CCN_formmatted." was added with the following information.");
	      echo("<br>");
	      echo("<br>");
      
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php

       //show that the case was added.
       $row = mysqli_fetch_row($result5);
       echo "<table>";
       echo "<tr><td>Case Name:</td><td>".$row[0]."</td></tr>";
       echo "<tr><td>Crime Number:</td><td>".$row[1]."</td></tr>";
       echo "<tr><td>Crime Name:</td><td>".$row[2]."</td></tr>";
       echo "<tr><td>Crime Start Date:</td><td>".$row[3]."</td></tr>";
       echo "<tr><td>Crime End Date:</td><td>".$row[4]."</td></tr>";
       echo "<tr><td>Location Description:</td><td>".$row[5]."</td></tr>";
       echo "<tr><td>Address:</td><td>".$row[6]."<br>".$row[7].", ".$row[8]." ".$row[9]." ".$row[10]."</td></tr>";
       echo "<tr><td>Solved:</td><td>".$Solv."</td></tr>";
       echo "<tr><td>Weapons Used in the Commission of the Crime:</td><td>".$Weapons_formatted."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    
    ?>
      
  </div>
  
</body>

</html>



	 
