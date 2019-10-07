<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Counts of Relationships between Charged Individuals and Their Victims Where the Charged was Found Guilty</font></h2></center><hr></div>
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
    width: 60%;
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
      	 
      	 //query of charged-victim relationship counts
         $query = "SELECT Relationship, COUNT(*) AS RelTypes
                   FROM SuspectHasRelationshipToVictim shrtv
		     JOIN Charged ch ON ch.CaseColloquialName = shrtv.CaseColloquialNameS AND ch.CrimeNo = shrtv.CrimeNoS AND ch.SuspectNo = shrtv.SuspectNo 
         JOIN ((SELECT DISTINCT CaseColloquialName, CrimeNo, SuspectNo 
                FROM TrialVerdict
			   WHERE Verdict = 'Guilty')
			   UNION
			   (SELECT DISTINCT CaseColloquialName, CrimeNo, SuspectNo 
         FROM Plea)) a ON a.CaseColloquialName = ch.CaseColloquialName AND a.CrimeNo = ch.CrimeNo AND a.SuspectNo = ch.CrimeNo
		     GROUP BY Relationship
		     ORDER BY RelTypes DESC";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));   
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       echo "<table>";
       echo "<th>Relationship</th><th>Number of Instances Where a Guilty Individual has the Realtionship to Their Victim</th></tr>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['Relationship']."</td><td>".$row['RelTypes']."</td></tr>";
       }
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
