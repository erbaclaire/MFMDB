<html>
  <?php
      $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
      $username = 'karenandgeorgia';
      $password = 'stevensmustache';
      $database = 'mfmdb';

     //connect to database
     $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());
     $query = "SELECT *
	             FROM Evidence 
               WHERE CaseColloquialName = '".str_replace("'", "''", $_POST["CaseColloquialName"])."' AND CrimeNo = '".$_POST["CrimeNo"]."' 
               ORDER BY EvidenceItemNo";	
     $result = mysqli_query($dbcon, $query) or die("Failed! ".mysqli_error($dbcon));
  ?>
  <option value="pse">Please Select a Piece of Evidence*</option>
  <?php
     if ($result->num_rows > 0) {
     while($row = mysqli_fetch_array($result)) {
  ?>
  <option value = "<?php echo $row['EvidenceItemNo']; ?>"><?php echo $row["EvidenceItemNo"]." - ".$row["Item"]; ?></option>
  <?php
     }
     }
     else {
  ?>
  <option value="null">There are no pieces of evidence associated with the selected crime and case.</option>;
  <?php
     }
  ?>
</html>





	
