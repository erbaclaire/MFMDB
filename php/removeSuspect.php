<html>
<head style="font-family:didot">
  <div style="font-size:45"><font color="cadetblue"><br/><br/><br/><center>Your Attempt to Remove a Suspect Discussed on My Favorite Murder:</center></font></div>
  <style>
    div.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    font-size: 45px;
    font-family: didot;
    z-index = 1;
    background-color: white;
    }
    
    table {
    font-family: didot;
    font-size: 12;
    border-collapse: collapse;
    width: 100%;
    }

    td {
    border: 1px solid dimgray;
    text-align: center;
    padding: 8px;
    }

    th {
    color: cadetblue;
    text-align: center;
    padding: 8px;
    border: 1px solid dimgray;
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
      	 $CCN = str_replace("'", "''", $_REQUEST['ccn2']);
      	 $CCN_formatted = str_replace("''", "'", $CCN);
      	 $CN = $_REQUEST['crimes2'];
      	 $SN = $_REQUEST['suspects'];

      	 //validation that non-null fields are filled in
      	 if ($CCN == "psac" || trim($CCN)==''){
      	 die("FAILED!<br>You must select a case.");
      	 }
      	 if ($CN == "psac" || trim($CN)==''){
      	 die("FAILED!<br>You must select a crime.");
      	 }
	       if ($CN == "null"){
      	 die("FAILED!<br>There are no crimes associated with the chosen case and therefore no suspects to remove as there cannot be suspects without a crime.");
      	 }
	       if ($SN == "psas" || trim($SN)==''){
      	 die("FAILED!<br>You must select a suspect.");
      	 }
	       if ($SN == "null"){
      	 die("FAILED!<br>There are no suspects associated with the chosen case and crime and therefore no suspects to remove.");
      	 }
	 
      	 //validation that case, crime, and suspect are already in the database -- should be since pulling from the drop down menu
      	 $query = "SELECT *
		               FROM SuspectLookup
                   WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN ORDER BY CrimeNo";
      	 $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon)); 
	       if (mysqli_num_rows($result)==0) {
	       die("FAILED!<br>Suspect ".$SN." of ".$CCN_formatted." - Crime ".$CN." does not exist.");
         }
      ?>

    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
      	 echo("Succeeded!<br>Suspect ".$SN." of ".$CCN_formatted." - Crime ".$CN." was deleted and the following information was removed. Also removed were any links between a piece of evidence and the deleted suspect and any relationships between the suspect and victims, as the suspect no longer exists.");
      	 echo("<br>");
      	 echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
    <?php
       //show the suspect was removed
       echo "<table>"; 
       echo "<tr><th>Case</th><th colspan='2'>Crime</th><th colspan='10'>Suspect</th><th colspan='6'>Plea</th><th colspan='9'>Trial</th><tr>";
       echo "<tr><th>Case Colloquial Name</th><th>Crime Number</th><th>Crime Name</th><th>Suspect Number</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Gender</th><th>Race</th><th>Age</th><th>Motive</th><th>Alibi</th><th>Date Charged</th><th>Legal Count Pled To</dth><th>Plea</th><th>Plea Date</th><th>Sentence Type</th><th>Sentence Length</th><th>Parole Eligible</th><th>Trial Name</th><th>Court Name</th><th>Start Date</th><th>End Date</th><th>Verdict</th><th>Sentence Type</th><th>Sentence Length</th><th>Parole Eligible</th></tr>";
       while($row = mysqli_fetch_row($result)) {
       echo "<tr align = 'center'>";
       foreach ($row as $r) {
       $r = wordwrap($r,10,"<br>\n");
       echo "<td>".$r."</td>";
       }
       echo "</tr>";  
       }
       echo "</table>";
       
       //remove suspect
       $delete = "DELETE FROM Suspect WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
       $result3 = mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_free_result($result3);
       $moveup = "CALL MoveSuspectNoUp('$CCN', $CN, $SN)";
       $result4 = mysqli_query($dbcon, $moveup) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
