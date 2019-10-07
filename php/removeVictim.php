<html>
<head style="font-family:didot">
  <div style="font-size:45"><font color="cadetblue"><br/><br/><br/><center>Your Attempt to Remove a Victim Discussed on My Favorite Murder:</center></font></div>
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
      	 $VN = $_REQUEST['victims'];

      	 //validation that non-null fields are filled in
      	 if ($CCN == "psac" || trim($CCN)==''){
      	 die("FAILED!<br>You must select a case.");
      	 }
      	 if ($CN == "psac" || trim($CN)==''){
      	 die("FAILED!<br>You must select a crime.");
      	 }
      	 if ($CN == "null"){
      	 die("FAILED!<br>There are no crimes associated with the chosen case and therefore no victims to remove as there cannot be victims without a crime.");
      	 }
	       if ($VN == "psav" || trim($VN)==''){
      	 die("FAILED!<br>You must select a victim.");
      	 }
	       if ($VN == "null"){
      	 die("FAILED!<br>There are no victims associated with the chosen case and crime and therefore no victims to remove.");
      	 }
	 
      	 //validation that case, crime, and victim are already in the database -- should be since pulling from the drop down menu
      	 $query = "SELECT DISTINCT CaseColloquialName, CrimeNo, CrimeName, VictimNo, VFirstName, VMiddleName, VLastName, VGender, VRace, VAge, Harm  
                   FROM CaseLookup WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND VictimNo = $VN ORDER BY CrimeNo, VictimNo";
      	 $result = mysqli_query($dbcon, $query); 
         if (mysqli_num_rows($result)==0) {
      	 die("FAILED!<br>Victim ".$VN." of ".$CCN_formatted." - Crime ".$CN." does not exist.");
      	 }

      ?>

    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
      	 echo("Succeeded!<br>Victim ".$VN." of ".$CCN_formatted." - Crime ".$CN." was deleted and the following information was removed.");
      	 echo("<br>");
      	 echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
    <?php
      //show that the victim was removed
      echo "<table>"; 
      echo "<tr><th>Case</th><th colspan='2'>Crime</th><th colspan='8'>Victim</th><tr>";
      echo "<tr><th>Case Colloquial Name</th><th>Crime Number</th><th>Crime Name</th><th>Victim Number</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Gender</th><th>Race</th><th>Age</th><th>Harm to Victim</th></tr>";
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

      //remove victim
      $delete = "DELETE FROM Victim WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND VictimNo = $VN";
      $result2 = mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
      mysqli_free_result($result2);
      $moveup = "CALL MoveVictimNoUp('$CCN', $CN, $VN)";
      $result3 = mysqli_query($dbcon, $moveup) or die("FAILED! ".mysqli_error($dbcon));
      mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
