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
      	 $CCN = str_replace("'", "''", $_REQUEST['ccn3']);
      	 $CCN_formatted = str_replace("''", "'", $CCN);
      	 $CN = $_REQUEST['crimes3'];
      	 $EN = $_REQUEST['evidence2'];

      	 //validation that non-null fields are filled in
      	 if ($CCN=='psac' || trim($CCN)==''){
      	 die("0 Results<br>You must select a case.");
      	 }
	       if ($CN=='psac' || trim($CN)==''){
      	 die("0 Results<br>You must select a crime.");
      	 }
	       if ($CN=='null'){
      	 die("0 Results<br>There are no crimes associated with the chosen case.");
      	 }
	       if ($EN=='pse' || trim($EN)==''){
      	 die("0 Results<br>You must select a piece of evidence.");
      	 }
	       if ($EN=='null'){
      	 die("0 Results<br>There are no pieces of evidence with supporting documentation associated with the chosen case and crime.");
      	 }
      	 
      	 //validation that the suspect gave a plea -- should have since it is a dropdown menu
         $query = "SELECT * FROM Evidence WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND EvidenceItemNo = $EN";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));

      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       $row = mysqli_fetch_row($result);
       echo "<div style='font-family:didot;'><h2><u>".$CCN." - Evidence Item Number ".$EN."</u><br/>".$row[4]."</h2>";
       echo "<br/><font color='dimgray' size='5'><u>Evidence Type:</u>  ".$row[3]."</font>";
       echo "<br/><right><font color='dimgray' size='5'><u>Description:</u>  ".$row[5]."</font></right>";
       if (trim($row[6]) != '') {
       echo "<br/><br/><br/><center><img src='".$row[6]."'></center>";
       }
       if (trim($row[7]) != '') {
       echo '<br/><br/><br/><center><iframe width=900 height=650 src="'.$row[7].'" plugin:true</iframe></center></div>';
       } 
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
