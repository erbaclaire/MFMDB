<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Remove an Episode of My Favorite Murder:</center></font></div>
  <style>
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

    tr:nth-child(even) {
    background-color: #dddddd;
    }

    th {
    position: -webkit-sticky;
    position: sticky;
    color: cadetblue;
    text-align: center;
    padding: 8px;
    border: 1px solid dimgray;
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
      	 $EpisodeNo = $_REQUEST['EpisodeNumber'];

      	 //validation that non-null fields are filled in
      	 if (!isset($EpisodeNo) || trim($EpisodeNo)==''){
      	 die("FAILED!<br>You must enter an Episode Number.");
      	 }

      	 //validation that input is correct type (e.g., int, string, date, etc.)
      	 if (!is_numeric($EpisodeNo)) {
      	 die("FAILED!<br>The Episode Number must be an integer.<br>Please re-enter the data in the correct format.");
      	 }

      	 //validation that episode is already in the database
      	 $query = "SELECT * FROM Episode WHERE EpisodeNumber = $EpisodeNo";
      	 $result = mysqli_query($dbcon, $query);
      	 if (mysqli_num_rows($result)==0) {
      	 die("FAILED! MFM Episode Number ".$EpisodeNo." does not exist.");
      	 }
      	 $row = mysqli_fetch_row($result);
      	 mysqli_free_result($result);
      	 
      	 //remove episode
      	 $delete = "DELETE FROM Episode WHERE EpisodeNumber = $EpisodeNo";
      	 $result2 = mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
      	 mysqli_free_result($result2);
      ?>

    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
    	 echo("Succeeded!<br>Episode ".$EpisodeNo." was deleted and the following information was removed.");
    	 echo("<br>");
    	 echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show that the episode was removed
       echo "<table>";
       echo "<tr><th>Episode Number</th><th>Episode Title</th><th>Date Aired</th><th>Location Recorded</th><th>Episode Link</th><th>Episode Length</th></tr>";
       echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
