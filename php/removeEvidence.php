<html>
<head style="font-family:didot">
  <div style="font-size:45"><font color="cadetblue"><br/><br/><br/><center>Your Attempt to Remove Evidence Discussed on My Favorite Murder:</center></font></div>
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
    font-size: 20;
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
      	 $EN = $_REQUEST['evidence'];

      	 //validation that non-null fields are filled in
      	 if ($CCN == "psac" || trim($CCN)==''){
      	 die("FAILED!<br>You must select a case.");
      	 }
	       if ($CN == "psac" || trim($CN)==''){
	       die("FAILED!<br>You must select a crime.");
	       }
	       if ($CN == "null"){
      	 die("FAILED!<br>There are no crimes associated with the chosen case and therefore no evidence to remove as there cannot be evidence without a crime.");
      	 }
	       if ($EN == "pse" || trim($EN)==''){
      	 die("FAILED!<br>You must select a piece of evidence.");
      	 }
	       if ($EN == "null"){
      	 die("FAILED!<br>There are no pieces of evidence associated with the chosen case and crime and therefore no evidence to remove.");
      	 }
	 
      	 //query to show results - if the evidence does not implicate any suspect it will not be added to CaseLookup so select from a joined Evidence and Crime table, instead
      	 $query = "SELECT cr.CaseColloquialName, cr.CrimeNo, cr.CrimeName, e.EvidenceItemNo, e.EType, e.Item, e.Description, e.Picture, e.Video
                   FROM Evidence e
                   JOIN Crime cr ON e.CaseColloquialName = cr.CaseColloquialName AND e.CrimeNo = cr.CrimeNo
                   WHERE e.CaseColloquialName = '$CCN' AND e.CrimeNo = $CN AND e.EvidenceItemNo = $EN ORDER BY e.CrimeNo";
      	 $result = mysqli_query($dbcon, $query); 
	       if (mysqli_num_rows($result)==0) {
         die("FAILED!<br>Evidence ".$EN." of ".$CCN_formatted." - Crime ".$CN." does not exist.");
         }
      ?>

    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
      	 echo("Succeeded!<br>Evidence Item ".$EN." of ".$CCN_formatted." - Crime ".$CN." was deleted and the following information was removed. Also removed were any links between a piece of evidence and a suspect as that piece of evidence no longer exists.");
      	 echo("<br>");
      	 echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
    <?php
       //show that the evidence was removed
       echo "<table>"; 
       echo "<tr><th>Case</th><th colspan='2'>Crime</th><th colspan='6'>Evidence</th></tr>";
       echo "<tr><th>Case Colloquial Name</th><th>Crime Number</th><th>Crime Name</th><th>Evidence Item Number</th><th>Type</th><th>Item</th><th>Description</th><th>Picture</th><th>Video</th></tr>";
       while($row = mysqli_fetch_row($result)) {
       echo "<tr align = 'center'>";
       foreach ($row as $r) {
       $r = wordwrap($r,10,"<br>\n");
       echo "<td>".$r."</td>";
       }
       echo "</tr>";  
       }
       echo "</table>";
       
       //remove evidence
       $delete = "DELETE FROM Evidence WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND EvidenceItemNo = $EN";
       $result2 = mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_free_result($result2);
       $moveup = "CALL MoveEvidenceNoUp('$CCN', $CN, $EN)";
       $result4 = mysqli_query($dbcon, $moveup) or die("FAILED! ".mysqli_error($dbcon));
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
