<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Number of Pieces of Evidence Against Suspects That Were Discussed on My Favorite Murder for Crimes That Are Not Solved by Evidence Type</font></h2></center><hr></div>
  <style>
    div.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    font-size: 30px;
    font-family: didot;
    z-index = 1;
    background-color: white;
    }
    
    table {
    font-family: didot;
    font-size: 25;
    border-collapse: collapse;
    width: 70%;
    }

    td {
    border: 1px solid dimgray;
    text-align: center;
    padding: 8px;
    }

    tr:nth-child(even) {
    background-color: #dddddd;
    }

    th {
    color: cadetblue;
    text-align: center;
    padding: 8px;
    border: 1px solid dimgray;
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
      	 
      	 //query of evidence by evidence type for each suspect of unsolved crimes 
         $query = "SELECT cr.CaseColloquialName, FirstName, LastName, EType, COUNT(*) AS Evidence
                   FROM Evidence e
		     JOIN EvidenceImplicatesSuspect eis ON e.CaseColloquialName = eis.CaseColloquialNameE AND e.CrimeNo = eis.CrimeNoE AND e.EvidenceItemNo = eis.EvidenceItemNo
		     JOIN Suspect s ON s.CaseColloquialName = eis.CaseColloquialNameS AND s.CrimeNo = eis.CrimeNoS AND s.SuspectNo = eis.SuspectNo
		     JOIN Crime cr ON cr.CaseColloquialName = s.CaseColloquialName AND cr.CrimeNo = s.CrimeNo
		     WHERE Solved = 0
         GROUP BY cr.CaseColloquialName, FirstName, LastName, Etype
		     ORDER BY cr.CaseColloquialName, FirstName, LastName, Evidence DESC";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
	       
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       echo "<table>";
       echo "<th>Case Name</th><th>Suspect First Name</th><th>Suspect Last Name</th><th>Evidence Type</th><th>Number of Pieces of Evidence</th></tr>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['CaseColloquialName']."</td><td>".$row['FirstName']."</td><td>".$row['LastName']."</td><td>".$row['EType']."</td><td>".$row['Evidence']."</td></tr>";
       }
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
