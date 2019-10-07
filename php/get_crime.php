<html>
  <?php
      $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
      $username = 'karenandgeorgia';
      $password = 'stevensmustache';
      $database = 'mfmdb';

     //connect to database
     $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());
     $query = "SELECT cr.CaseColloquialName, cr.CrimeNo, CrimeName, GROUP_CONCAT(CONCAT(FirstName, ' ', LastName) SEPARATOR ', ') AS VictimConcat
               FROM Crime cr
	             LEFT OUTER JOIN Victim v ON cr.CaseColloquialName = v.CaseColloquialName AND cr.CrimeNo = v.CrimeNo
               WHERE cr.CaseColloquialName = '".str_replace("'", "''", $_POST["CaseColloquialName"])."'
               GROUP BY cr.CaseColloquialName, cr.CrimeNo, CrimeName 
               ORDER BY cr.CrimeNo";	
     $result = mysqli_query($dbcon, $query) or die("Failed! ".mysqli_error($dbcon));
  ?>
  <option value="psac">Please Select a Crime*</option>
  <?php
     if ($result->num_rows > 0) {
     while($row = mysqli_fetch_array($result)) {
     if (trim($row["VictimConcat"])!='') {
  ?>
  <option value = "<?php echo $row['CrimeNo']; ?>"><?php echo $row["CrimeNo"]." - ".$row["CrimeName"]." - Victim(s): ".$row["VictimConcat"]; ?></option>
  <?php
     }
     else {
     ?>
  <option value = "<?php echo $row['CrimeNo']; ?>"><?php echo $row["CrimeNo"]." - ".$row["CrimeName"]; ?></option>
  <?php
     }
     }
     }
     else {
  ?>
  <option value="null">There are no crimes associated with the selected case.</option>;
  <?php
     }
  ?>
</html>





	
