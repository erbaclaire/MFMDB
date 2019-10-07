<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue"> Guilty Individuals Discussed on My Favorite Murder by Race, Gender, and Age</font></h2></center><hr></div>
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
      	 
      	 //query of guilty by age, race, and gender
         $query = "SELECT Race, Gender,
		     CASE
		       WHEN Age < 18 THEN 'Under 18'
		       ELSE '18 +'
		     END AS AgeGroup, COUNT(*) AS Guilty
         FROM TrialVerdict tv
		     JOIN Suspect s ON s.CaseColloquialName = tv.CaseColloquialName AND s.CrimeNo = tv.CrimeNo AND s.SuspectNo = tv.SuspectNo
		     WHERE Verdict = 'Guilty'
         GROUP BY Race, Gender, AgeGroup
		     ORDER BY Guilty DESC, Race, Gender, AgeGroup";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
	       
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       echo "<table>";
       echo "<th>Race</th><th>Gender</th><th>Age Group</th><th>Guilty Individuals</th></tr>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['Race']."</td><td>".$row['Gender']."</td><td>".$row['AgeGroup']."</td><td>".$row['Guilty']."</td></tr>";
       }
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
