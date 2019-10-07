<html>
<head style="font-family:didot">
  <div style="font-size:45"><font color="cadetblue"><br/><br/><br/><center>Your Attempt to Remove a Plea Discussed on My Favorite Murder:</center></font></div>
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
    font-size: 15;
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
      	 $SN = $_REQUEST['suspects2'];
      	 $LC = str_replace("'", "''", $_REQUEST['lcs']);
      	 $LC_formatted = str_replace("''", "'", $LC);

      	 //validation that non-null fields are filled in
      	 if ($CCN == "psac" || trim($CCN)==''){
      	 die("FAILED!<br>You must select a case.");
      	 }
	       if ($CN == "psac" || trim($CN)==''){
	       die("FAILED!<br>You must select a crime.");
	       }
	       if ($CN == "null"){
      	 die("FAILED!<br>There are no crimes associated with the choosen case and therefore no pleas to remove as there cannot be pleas without a crime.");
      	 }
	       if ($SN == "psas" || trim($SN)==''){
	       die("FAILED!<br>You must select a suspect.");
	       }
	       if ($SN == "null"){
      	 die("FAILED!<br>There are no suspects associated with the choosen case and crime and therefore no pleas to remove as there cannot be a plea without a suspect making the plea.");
      	 }
	       if ($LC == "psalc" || trim($LC)==''){
      	 die("FAILED!<br>You must select a legal count that the charged individual plead to.");
      	 }
	       if ($LC == "null"){
      	 die("FAILED!<br>There are no pleas associated with the chosen case, crime, and charged individual and therefore no pleas to remove.");
      	 }
	 
      	 //validation that case, crime, suspect, and legal count are already in the database -- should be since pulling from the drop down menu
	       //we use the SuspectLookup because if a suspect does not have a relationship to a victim (because there are no victims) then he or she won't be added to the CaseLookup
      	 $query = "SELECT DISTINCT CaseColloquialName, CrimeNo, CrimeName, SuspectNo, FirstName, LastName, LegalCount, Guilty_NoContest, PleaDate, PleaSentenceType, PleaSentenceLength, PleaParoleEligible
                   FROM SuspectLookup 
                   WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN AND LegalCount = '$LC'";
      	 $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon)); 
	       if (mysqli_num_rows($result)==0) {
         die("FAILED!<br>Suspect ".$SN." of ".$CCN_formatted." - Crime ".$CN." did not plea to ".$LC_formatted);
         }
      ?>

    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
      	 echo("Succeeded!<br>The Plea to ".$LC_formatted." from Suspect ".$SN." of ".$CCN_formatted." - Crime ".$CN." was deleted and the following information was removed.");
      	 echo("<br>");
      	 echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
    <?php
       //show plea removed
       echo "<table>"; 
       echo "<tr><th>Case</th><th colspan='2'>Crime</th><th colspan='3'>Pleading Suspect</th><th colspan='3'>Plea</th><th colspan='3'>Sentence</th></tr>";
       echo "<tr><th>Case Colloquial Name</th><th>Crime Number</th><th>Crime Name</th><th>Suspect Number</th><th>First Name</th><th>Last Name</th><th>Legal Count Pled To</dth><th>Plea</th><th width=5%>Plea Date</th><th>Sentence Type</th><th>Sentence Length</th><th>Parole Eligible</th></tr>";
       while($row = mysqli_fetch_row($result)) {
       echo "<tr align = 'center'>";
       foreach ($row as $r) {
       $r = wordwrap($r,10,"<br>\n");
       echo "<td>".$r."</td>";
       }
       echo "</tr>";  
       }
       echo "</table>";
       
       //remove crime
       $delete = "DELETE FROM Plea WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN AND LegalCount = '$LC'";
       $result3 = mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_free_result($result3);
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
