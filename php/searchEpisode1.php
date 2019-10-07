<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Results</font></h2></center><hr></div>
  <style>
    div.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    font-size: 40px;
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
    text-align: left;
    padding: 8px;
    }

    tr:nth-child(even) {
    background-color: #dddddd;
    }

    th {
    color: cadetblue;
    text-align: left;
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
      	 
      	 //get input
      	 $EpisodeNo = $_REQUEST['EpisodeNumber'];

      	 //validation that non-null fields are filled in
      	 if (!isset($EpisodeNo) || trim($EpisodeNo)==''){
      	 die("0 Results<br>You must enter an Episode Number.");
      	 }

      	 //validation that input is correct type (e.g., int, string, date, etc.)
      	 if (!is_numeric($EpisodeNo)) {
      	 die("0 Results<br>The Episode Number must be an integer.<br>Please re-enter the data in the correct format.");
      	 }

      	 //query to find episode information
      	 $query = "SELECT * FROM Episode WHERE EpisodeNumber = $EpisodeNo";
      	 $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php       
       //show results
       if ($result->num_rows > 0) {
       echo "<table>";
       echo "<tr><th>Episode Number</th><th>Episode Title</th><th>Air Date</th><th>Recording Location</th><th>Episode Link</th><th>Episode Length (Minutes)</th></tr>";
       while($row = $result->fetch_assoc()) {
           echo "<tr><td>".$row["EpisodeNumber"]."</td><td>".$row["Title"]."</td><td>".$row["DateAired"]."</td><td>".$row["RecLocation"]."</td><td><a href=".$row['Link'].">".$row["Link"]."</a></td><td>".$row["EpisodeLength"]."</td></tr>";
       }
       echo "</table>";
       }
       else {
       echo "<p style='font-family:didot;'><font color='cadetblue' size='20'>0 Results<br>Please refine your search.</font></p>";
       }
       mysqli_close($dbcon);    
    ?>
      
  </div>
  
</body>

</html>



	 
