<html>
  <?php
      $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
      $username = 'karenandgeorgia';
      $password = 'stevensmustache';
      $database = 'mfmdb';

     //connect to database
     $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());
     $query = "SELECT DISTINCT TrialName, TrialStartDate, TrialEndDate
	             FROM TrialVerdict
               WHERE CaseColloquialName = '".str_replace("'", "''", $_POST["CaseColloquialName"])."' AND CrimeNo = '".$_POST["CrimeNo"]."' AND SuspectNo = '".$_POST["SuspectNo"]."' 
               ORDER BY TrialStartDate";	
     $result = mysqli_query($dbcon, $query) or die("Failed! ".mysqli_error($dbcon));
  ?>
  <option value="psat">Please Select a Trial*</option>
  <?php
     if ($result->num_rows > 0) {
     while($row = mysqli_fetch_array($result)) {  
  ?>
  <option value = "<?php echo $row['TrialStartDate']; ?>"><?php echo $row["TrialName"]." (Trial Dates: ".$row["TrialStartDate"]." through ".$row["TrialEndDate"].")"; ?></option>
  <?php
     }
     }
     else {
  ?>
  <option value="null">There are no trials associated with this case, crime, and charged individual.</option>;
  <?php
     }
  ?>
</html>





	
