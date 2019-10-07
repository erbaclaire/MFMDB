<html>
<head style="font-family:didot">
  <div style="font-size:45;"><font color="cadetblue"><br/><br/><br/><center>Your Attempt to Remove a Case Discussed on My Favorite Murder:</center></font></div>
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
    font-size: 9;
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
      	 $CCN = str_replace("'", "''", $_REQUEST['ccn']); 
	       $CCN_formatted = str_replace("''", "'", $CCN);
	 
      	 //validation that non-null fields are filled in
      	 if ($CCN == "psac" || trim($CCN)==''){
      	 die("FAILED!<br>You must select a case.");
      	 }

      	 //validation that the case is in the database -- should be since it is pulled from the DB in the dropdown menu
      	 $query = "SELECT * FROM CaseLookup WHERE CaseColloquialName = '$CCN' ORDER BY CrimeNo, VictimNo, SuspectNo, EvidenceItemNo";
      	 $result = mysqli_query($dbcon, $query); 
         if (mysqli_num_rows($result)==0) {
      	 die("FAILED! ".$CCN_formatted." does not exist.");
      	 }

      ?>

    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
      	 echo("Succeeded!<br>".$CCN_formatted." was deleted and the following information was removed.");
      	 echo("<br>");
      	 echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
    <?php
      //show data that was removed from the DB
      echo "<table>"; 
      echo "<tr><th>Case</th><th colspan='12'>Crime</th><th colspan='8'>Victim</th><th colspan='11'>Suspect</th><th colspan='6'>Evidence Against the Suspect</th><th colspan='7'>Plea</th><th colspan='9'>Trial</th><tr>";
      echo "<tr><th>Case Colloquial Name</th><th>Crime Number</th><th>Crime Name</th><th>Start Date</th><th>End Date</th><th>Location Description</th><th>Street</th><th>City</th><th>State</th><th>Zip</th><th>Country</th><th>Solved?</th><th>Weapon(s) Used</th><th>Victim Number</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Gender</th><th>Race</th><th>Age</th><th>Harm to Victim</th><th>Suspect Number</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Gender</th><th>Race</th><th>Age</th><th>Motive</th><th>Alibi</th><th>Date Charged</th><th>Victim-Suspect Relationship</th><th>Evidence Item Number</th><th>Type</th><th>Item</th><th>Description</th><th>Picture</th><th>Video</th><th>Legal Count</dth><th>Plea</th><th>Plea Date</th><th>Sentence Type</th><th>Sentence Length</th><th>Parole Eligible</th><th>Trial Name</th><th>Court Name</th><th>Start Date</th><th>End Date</th><th>Verdict</th><th>Sentence Type</th><th>Sentence Length</th><th>Parole Eligible</th></tr>";
      while($row = mysqli_fetch_row($result)) {
        echo "<tr align = 'center'>";
        foreach ($row as $r) {
          $r = wordwrap($r,10,"<br>\n");
          echo "<td>".$r."</td>";
        }
        echo "</tr>";  
      }
      echo "</table>";

      $result->close();
      $dbcon->next_result();
      //remove case
      $delete = "DELETE FROM Cases WHERE CaseColloquialName = '$CCN'";
      $result2 = mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
      mysqli_free_result($result);
      mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
