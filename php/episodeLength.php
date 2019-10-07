<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Average Length of My Favorite Murder Episodes by Year and Recording Location</font></h2></center><hr></div>
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
      
         //Connection information
         $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
         $username = 'karenandgeorgia';
         $password = 'stevensmustache';
         $database = 'mfmdb';
          	 
      	 //connect to database
      	 $dbcon = mysqli_connect($host, $username, $password, $database)
      	 or die('Could not connect: ' . mysqli_connect_error());
      	 
      	 //query episode length by year and recording location
         $query = "SELECT YEAR(DateAired) AS Year, RecLocation, CAST(AVG(EpisodeLength) AS DECIMAL(5,2)) AS EpLen
                   FROM Episode
                   GROUP BY Year, RecLocation
		               ORDER BY Year, EpLen DESC, RecLocation";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
	       
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       echo "<table>";
       echo "<th>Year</th><th>Recording Location</th><th>Average Episode Length</th></tr>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['Year']."</td><td>".$row['RecLocation']."</th><td>".$row['EpLen']."</td></tr>";
       }
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
