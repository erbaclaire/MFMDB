<html>
  <?php
      $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
      $username = 'karenandgeorgia';
      $password = 'stevensmustache';
      $database = 'mfmdb';

     //connect to database
     $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());
     $query = "SELECT *, CONCAT(FirstName, ' ', LastName) AS VictimConcat
	             FROM Victim 
               WHERE CaseColloquialName = '".str_replace("'", "''", $_POST["CaseColloquialName"])."' AND CrimeNo = '".$_POST["CrimeNo"]."' 
               ORDER BY VictimNo";	
     $result = mysqli_query($dbcon, $query) or die("Failed! ".mysqli_error($dbcon));
  ?>
  <option value="psav">Please Select a Victim*</option>
  <?php
     if ($result->num_rows > 0) {
     while($row = mysqli_fetch_array($result)) {
  ?>
  <option value = "<?php echo $row['VictimNo']; ?>"><?php echo $row["VictimNo"]." - ".$row["VictimConcat"]; ?></option>
  <?php
     }
     }
     else {
  ?>
  <option value="null">There are no victims associated with the selected crime and case.</option>;
  <?php
     }
  ?>
</html>





	
