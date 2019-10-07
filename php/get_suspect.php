<html>
  <?php
      $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
      $username = 'karenandgeorgia';
      $password = 'stevensmustache';
      $database = 'mfmdb';

     //connect to database
     $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());
     $query = "SELECT *, CONCAT(COALESCE(FirstName,'[No First Name Given]'), ' ', LastName) AS SuspectConcat
	             FROM Suspect 
               WHERE CaseColloquialName = '".str_replace("'", "''", $_POST["CaseColloquialName"])."' AND CrimeNo = '".$_POST["CrimeNo"]."' 
               ORDER BY SuspectNo";	
     $result = mysqli_query($dbcon, $query) or die("Failed! ".mysqli_error($dbcon));
  ?>
  <option value="psas">Please Select a Suspect*</option>
  <?php
     if ($result->num_rows > 0) {
     while($row = mysqli_fetch_array($result)) {
     if (trim($row["SuspectConcat"]) != '') {
  ?>
  <option value = "<?php echo $row['SuspectNo']; ?>"><?php echo $row["SuspectNo"]." - ".$row["SuspectConcat"]; ?></option>
  <?php
     }
     else {
  ?>
  <option value = "<?php echo $row['SuspectNo']; ?>"><?php echo $row["SuspectNo"]." - No Name Given"; ?></option>
  <?php
     }
     }
     }
     else {
  ?>
  <option value="null">There are no suspects associated with the selected crime and case.</option>;
  <?php
     }
  ?>
</html>





	
