<?PHP
  //connection information
  $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
  $username = 'karenandgeorgia';
  $password = 'stevensmustache';
  $database = 'mfmdb';

  //connect to database
  $dbcon = mysqli_connect($host, $username, $password, $database)
           or die('Could not connect: ' . mysqli_connect_error());
			   
  function cleanData(&$str) {
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  //tables to download
  $tables = array("Episode", "Cases", "Crime", "Victim", "Suspect", "Charged", "Evidence", "Plea", "TrialVerdict", "Weapon", "Sentence", "EpisodeDiscussesCase", "CrimeCarriedOutWithWeapon", "EvidenceImplicatesSuspect", "SuspectHasRelationshipToVictim");

  foreach ($tables as $table) {

  //file name for download
  $filename = $table.".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $result = mysqli_query($dbcon, "SELECT * FROM ".$table) or die("FAILED! ".mysqli_error($dbcon));
  while(false !== ($row = mysqli_fetch_assoc($result))) {
  if(!$flag) {
	// display field/column names as first row
	echo implode("\t", array_keys($row)) . "\n";
  $flag = true;
	}
	array_walk($row, __NAMESPACE__ . '\cleanData');
	echo implode("\t", array_values($row)) . "\n";
  }
  exit;
  }
?>
