<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add a Case Discussed on My Favorite Murder:</center></font></div>
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
	   $Case = str_replace("'", "''", $_REQUEST['CaseColloquialName']);
	   $Case_formatted = str_replace("''", "'", $Case);
	   $Pic =  str_replace("'", "''", $_REQUEST['Pic']);
	   $Link =  str_replace("'", "''", $_REQUEST['Link']);
     $Episodes =  $_REQUEST['Episodes'];

     //don't accept double quotes on case
	   if (strpos($Case,"\"") !== false) {
     die("Please remove double quotes from the Case Name. You can replace the double quotes with single quotes.");
     }

	   //validation that non-null fields are filled in
	   if (!isset($Case) || trim($Case)==''){
	   die("FAILED!<br>You must enter a Case Name.");
	   }
	   if (!isset($Pic) || trim($Pic)==''){
	   die("FAILED!<br>You must enter a link to a picture.");
	   }
	   if (!isset($Link) || trim($Link)==''){
	   die("FAILED!<br>You must enter a link where a user can find more information on the case.");
	   }
     if (!isset($Episodes) || trim($Episodes)==''){
     die("FAILED!<br>You must enter the MFM episode(s) the case was discussed on.");
     }

	  //insert new case
    $insert = "INSERT INTO Cases(CaseColloquialName, Picture, InfoLink)
		           VALUES('$Case', '$Pic', '$Link')";
    $result = mysqli_query($dbcon, $insert) or die("FAILED!<br>".$Case_formatted." is already in the database. If the information for ".$Case_formatted." is inaccurate please remove the case and then re-add it with the correct information.");
    mysqli_free_result($result);

	  //validation that the episode(s) that discuss the case are already in the Episode table
    $episode_list = explode(",", $Episodes);
    foreach ($episode_list as $episode) {
    $check = "SELECT * FROM Episode WHERE EpisodeNumber = $episode";
    $check_result =  mysqli_query($dbcon, $check) or die("FAILED! ".mysql_error($dbcon));
    if ($check_result->num_rows > 0) {
    $insert2 = "INSERT INTO EpisodeDiscussesCase(EpisodeNumber, CaseColloquialName)
               VALUES($episode, '$Case')";
    $result3 =  mysqli_query($dbcon, $insert2) or die("PFAILED! ".mysqli_error($dbcon));
    }
    else {
    $delete = "DELETE FROM Cases WHERE CaseColloquialName = '$Case'";
    $delete_result =  mysqli_query($dbcon, $delete) or die("FAILED! ".mysqli_error($dbcon));
    die("Episode ".$episode." is not in the database. Please add Episode ".$episode." to Episodes first. You can do this by navigating to the Episodes page via the Main Menu.");
    }
    }

    //query to later display results
    $query = "SELECT * FROM Cases WHERE CaseColloquialName = '$Case'";
    $result2 = mysqli_query($dbcon, $query) or die("FAILED!".mysqli_error($dbcon));
      
  ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
	    
        echo("Succeeded!<br>".$Case_formatted." was added with the following information.");
	      echo("<br>");
	      echo("<br>");
      
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php

       //show that the case was added.
       $row = mysqli_fetch_row($result2);
       echo "<table>";
       echo "<tr><td>Case Name:</td><td>".$row[0]."</td></tr>";
       echo "<tr><td>Case Picture Link:</td><td>".$row[1]."</td></tr>";
       echo "<tr><td>Case Information Link:</td><td>".$row[2]."</td></tr>";
       echo "<tr><td>Case Discussed on Following Episodes:</td><td>".$Episodes."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    
    ?>
      
  </div>
  
</body>

</html>



	 
