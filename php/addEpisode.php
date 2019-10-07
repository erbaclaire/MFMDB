<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add an Episode of My Favorite Murder:</center></font></div>
  <style>
    table {
    font-family: didot;
    font-size: 25;
    border-collapse: collapse;
    width: 40%;
    }

    td, th {
    border: 1px solid dimgray;
    text-align: left;
    padding: 8px;
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
      	 $EpisodeNo = $_REQUEST['EpisodeNumber'];
      	 $Title = str_replace("'", "''", $_REQUEST['EpisodeTitle']);
      	 $Date =  $_REQUEST['EpisodeDate'];
      	 $RecLocation = str_replace("'", "''", $_REQUEST['EpisodeLocation']);
      	 $Link = str_replace("'", "''", $_REQUEST['EpisodeLink']);
      	 $EpisodeLength = $_REQUEST['EpisodeLength'];

      	 //validation that non-null fields are filled in
      	 if (!isset($EpisodeNo) || trim($EpisodeNo)==''){
      	 die("FAILED!<br>You must enter an Episode Number.");
      	 }
      	 if (!isset($Title) || trim($Title)==''){
      	 die("FAILED!<br>You must enter a title for the episode.");
      	 }
      	 if (!isset($Date) || trim($Date)==''){
      	 die("FAILED!<br>You must enter the date the episode aired.");;
      	 }
      	 if (!isset($RecLocation) || trim($RecLocation)==''){
      	 die("FAILED!<br>You must enter where the episode was recorded.");
      	 }
      	 if (!isset($Link) || trim($Link)==''){
      	 die("FAILED!<br>You must enter a link were a user can listen to the episode.");
      	 }
      	 if (!isset($EpisodeLength) || trim($EpisodeLength)==''){
      	 die("FAILED!<br>You must enter the length of the episode in minutes.");
      	 }

      	 //validation that fields are correct types (int, string, date, etc.) and in the correct format
      	 if (!is_numeric($EpisodeNo)) {
      	 die("FAILED!<br>The Episode Number must be an integer. Please re-enter the data in the correct format.");
      	 }
      	 if (!is_numeric($EpisodeLength)) {
      	 die("FAILED!<br>The Episode Length must be a number. Please re-enter the data in the correct format.");
      	 }
      	 function validateDate($date, $format = 'Y-m-d') {
      	 $d = DateTime::createFromFormat($format, $date);
      	 return $d && $d->format($format) === $date;
               }
         if (!validateDate($Date) || $Date > date('Y-m-d')) {
         die("FAILED!<br>The Date Aired must be of the format YYYY-MM-DD and cannot be past today's date.<br>Please re-enter the data in the correct format.");
         }
	 
         //insert new episode
         $insert = "INSERT INTO Episode(EpisodeNumber, Title, DateAired, RecLocation, Link, EpisodeLength)
                    VALUES($EpisodeNo, '$Title', '$Date', '$RecLocation', '$Link', $EpisodeLength)";
         $result = mysqli_query($dbcon, $insert) or die("FAILED!<br>Episode ".$EpisodeNo." is already in the database. If the information for<br>Episode ".$EpisodeNo." is inaccurate please remove the episode and then<br>re-add it with the correct information.");
         mysqli_free_result($result);

         //query to show what was added to Episodes
         $query = "SELECT * FROM Episode WHERE EpisodeNumber = $EpisodeNo";
         $result2 = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));         
      ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
      	 echo("Succeeded!<br>Episode ".$EpisodeNo." was added with the following information.");
      	 echo("<br>");
      	 echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show that the episode was added
       $row = mysqli_fetch_row($result2);
       echo "<table>";
       echo "<tr><td>Episode Number:</td><td>".$row[0]."</td></tr>";
       echo "<tr><td>Episode Title:</td><td>".$row[1]."</td></tr>";
       echo "<tr><td>Date Aired:</td><td>".$row[2]."</td></tr>";
       echo "<tr><td>Location Recorded:</td><td>".$row[3]."</td></tr>";
       echo "<tr><td>Episode Link:</td><td>".$row[4]."</td></tr>";
       echo "<tr><td>Episode Length:</td><td>".$row[5]." Minutes</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
