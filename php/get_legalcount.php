<html>
  <?php
      $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
      $username = 'karenandgeorgia';
      $password = 'stevensmustache';
      $database = 'mfmdb';

     //connect to database
     $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());
     $query = "SELECT DISTINCT LegalCount
	             FROM Plea
               WHERE CaseColloquialName = '".str_replace("'", "''", $_POST["CaseColloquialName"])."' AND CrimeNo = '".$_POST["CrimeNo"]."' AND SuspectNo = '".$_POST["SuspectNo"]."' 
               ORDER BY LegalCount";	
     $result = mysqli_query($dbcon, $query) or die("Failed! ".mysqli_error($dbcon));
  ?>
  <option value="psalc">Please Select a Legal Count*</option>
  <?php
     if ($result->num_rows > 0) {
     while($row = mysqli_fetch_array($result)) {  
  ?>
  <option value = "<?php echo $row['LegalCount']; ?>"><?php echo $row["LegalCount"]; ?></option>
  <?php
     }
     }
     else {
  ?>
  <option value="null">There are no legal counts associated with this case, crime, and charged individual.</option>;
  <?php
     }
  ?>
</html>





	
