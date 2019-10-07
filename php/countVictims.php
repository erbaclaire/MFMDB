<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Victims Discussed on My Favorite Murder by Race, Gender, and Age Group</font></h2></center><hr></div>
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
      	 
      	 //query of victims by age, race, and gender
         $query = "SELECT Race, Gender,
		     CASE
		       WHEN Age < 18 THEN 'Under 18'
		       ELSE '18 +'
		     END AS AgeGroup, COUNT(*) AS Victims 
         FROM Victim
         GROUP BY Race, Gender, AgeGroup
		     ORDER BY Victims DESC, Race, Gender, AgeGroup";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
	       
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       echo "<table>";
       echo "<th>Race</th><th>Gender</th><th>Age Group</th><th>Number of Victims</th></tr>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['Race']."</td><td>".$row['Gender']."</td><td>".$row['AgeGroup']."</td><td>".$row['Victims']."</td></tr>";
       }
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
