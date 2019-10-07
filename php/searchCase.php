<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Results</font></h2></center><hr></div>
  <style>
    body {
    font-family: didot;
    }
    
    div.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    font-size: 40px;
    font-family: didot;
    z-index = 1;
    background-color: white;
    }

    table {
    font-family: didot;
    font-size: 25;
    border-collapse: collapse;
    width: 100%;
    }

    td {
    border: 0px solid dimgray;
    text-align: left;
    padding: 10px;
    }

    th {
    color: cadetblue;
    text-align: left;
    padding: 10px;
    border: 0px;
    }
  </style>
</head>

<body style="font-family:didot;">

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
      	 $CCN = str_replace("'", "''", $_REQUEST['ccn2']);
	       $CCN_formatted = str_replace("''", "'", $_REQUEST['ccn2']);

      	 //validation that non-null fields are filled in
      	 if ($CCN == 'psac' || trim($CCN)==''){
      	 die("0 Results<br>You must select a case.");
      	 }

      	 //queries to find case information
	       $query = "SELECT * FROM Cases WHERE CaseColloquialName = '$CCN'";
      	 $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
	       $row = mysqli_fetch_row($result);
	       $query2 = "SELECT DISTINCT CrimeNo, CrimeName, StartDate FROM Crime WHERE CaseColloquialName = '$CCN'";
      	 $result2 = mysqli_query($dbcon, $query2) or die("FAILED! ".mysqli_error($dbcon));
	       $query3 = "SELECT DISTINCT CrimeNo, VictimNo, FirstName, LastName FROM Victim WHERE CaseColloquialName = '$CCN'";
	       $query4 = "SELECT DISTINCT CrimeNo, SuspectNo, FirstName, LastName FROM Suspect WHERE CaseColloquialName = '$CCN'";
	       $query5 = "SELECT DISTINCT CrimeNo, EvidenceItemNo, EType, Item, Description FROM Evidence WHERE CaseColloquialName = '$CCN'";
	       $query6 = "SELECT DISTINCT CrimeNo, CrimeName, VictimNo, VFirstName, VLastName, SuspectNo, SFirstName, SLastName, Relationship, EvidenceItemNo, Item, Description FROM CaseLookup WHERE CaseColloquialName = '$CCN'";
      	 $result6 = mysqli_query($dbcon, $query6) or die("FAILED! ".mysqli_error($dbcon));

	     ?>

    </font>
  </div>

  <div align="center">
      
    <?php
      //show results
      echo "<div style='font-size:40;'><h3><font color='black'>".$CCN_formatted."</font></h3></div>";
      echo '<div style="font-size:30;"><img src="'.$row[1].'"/><br><font color="dimgray"><a href="'.$row[2].'">Link for More Information</a></font><br/><br/></div>';

      echo "<br/><br/><div align='center' style='font-size:40;'><font color='cadetblue'>Victims, Suspects, and Evidence for Each Crime</font><hr><table>";
      //crimes
      while($row2 = $result2->fetch_assoc()) {
      echo "<div align='left' style='font-size:25;'><font color='cadetblue'><u>Crime ".$row2["CrimeNo"]." - ".$row2["CrimeName"]."</u>:</font>";

      //victims
      echo "<br/>Victim(s):<br/>";
      $result3 = mysqli_query($dbcon, $query3) or die("FAILED! ".mysqli_error($dbcon));
      while($row3 = $result3->fetch_assoc()) {
      if ($row2["CrimeNo"] == $row3["CrimeNo"]) {
      echo $row3["VictimNo"]." - ".$row3["FirstName"]." ".$row3["LastName"]."<br/>";
      }
      }

      //suspects
      echo "<br/>Suspects(s):<br/>";
      $result4 = mysqli_query($dbcon, $query4) or die("FAILED! ".mysqli_error($dbcon));
      while($row4 = $result4->fetch_assoc()) {
      if ($row2["CrimeNo"] == $row4["CrimeNo"]) {
      echo $row4["SuspectNo"]." - ".$row4["FirstName"]." ".$row4["LastName"]."<br/>";
      }
      }

      //evidence
      echo "<br/>Evidence:<br/>";
      $result5 = mysqli_query($dbcon, $query5) or die("FAILED! ".mysqli_error($dbcon));
      while($row5 = $result5->fetch_assoc()) {
      if ($row2["CrimeNo"] == $row5["CrimeNo"]) {
      echo $row5["EvidenceItemNo"]." - ".$row5["Item"].": ".$row5["Description"]."<br/>";
      }
      }
      echo "<br/>";
      }

      //relationships
      echo "<br/><br/><div align='center' style='font-size:40;'><font color='cadetblue'>Relationships Between Victims and Suspects and Evidence Implicating the Suspect in the Crime</font><hr><table>";
	    echo "<tr><th><u>Crime</u></th><th><u>Victim of the Crime</u></th><th><u>Suspect for the Crime Against the Victim</u></th><th><u>Evidence Implicating the Suspect for this Crime</u></th></tr>";
	    $prev_cn = '';
	    $prev_vn = '';
	    $prev_sn = '';
	  
	  
      while($row6 = $result6->fetch_assoc()) {
	    if ($row6["CrimeNo"] == $prev_cn && $row6["VictimNo"] == $prev_vn) {
	    echo "<tr><td valign='top'></td><td valign='top'>";
	    }
	    else {
	    echo "<tr><td valign='top'>".$row6["CrimeNo"]."-".$row6["CrimeName"]."</td><td valign='top'>";
      }
	  
	    if (trim($row6["VictimNo"])=='') {
	    echo "N/A</td><td valign='top'>";
      }
	    elseif ($row6["VictimNo"] == $prev_vn && $row6["CrimeNo"] == $prev_cn) {
	    echo "</td><td valign='top'>";
      }
	    else {
	    echo $row6["VictimNo"]."-".$row6["VFirstName"]." ".$row6["VLastName"]."</td><td valign='top'>";
      }

	    if (trim($row6["SuspectNo"]) == '') {
	    echo "N/A</td><td valign='top'>";
	    }
	    elseif ($row6["SuspectNo"] == $prev_sn && $row6["CrimeNo"] == $prev_cn && $row6["VictimNo"] == $prev_vn) {
	    echo "</td><td valign='top'>";
	    }
	    else {
	    echo $row6["SuspectNo"]."-".$row6["SFirstName"]." ".$row6["SLastName"]." (".$row6["Relationship"].")</td><td width=30%>";
	    }

	    if (trim($row6["EvidenceItemNo"])=='') {
	    echo "N/A</td></tr>";
	    }
	    else {
	    echo $row6["EvidenceItemNo"]."-".$row6["Item"].":<br>".$row6["Description"]."</td></tr>";
	    }
	  
	    $prev_cn = $row6["CrimeNo"];
	    $prev_vn = $row6["VictimNo"];
	    $prev_sn = $row6["SuspectNo"];
      }
      echo "</table></div>";
      mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
