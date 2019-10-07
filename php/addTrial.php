<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add a Trial Discussed on My Favorite Murder:</center></font></div>
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
	     $CCN = str_replace("'", "''", $_REQUEST['ccn']);
	     $CCN_formatted = str_replace("''", "'", $CCN);
	     $CN =  $_REQUEST['crimes'];
	     $SN =  $_REQUEST['suspects'];
       $TN = str_replace("'", "''", $_REQUEST['TrialName']);
	     $TN_formatted = str_replace("''", "'", $TN);
       $C = str_replace("'", "''", $_REQUEST['Court']);
	     $D1 =  $_REQUEST['Date1'];
	     $D2 =  $_REQUEST['Date2'];
       $Ver =  str_replace("'", "''", $_REQUEST['Ver']);
	     $ST =  $_REQUEST['sentence'];
	     $SL =  str_replace("'", "''", $_REQUEST['SentLength']);
	     $SL_formatted = str_replace("''", "'", $SL);
	     $PE =  $_REQUEST['pe'];

       //don't allow trial name to have double quotes
	     if (strpos($TN, "\"") !== false) {
	     die("Please remove double quotes from the Case Name. You can replace the double quotes with single quotes.");
       }

	     //validation that non-null fields are filled in
	     if ($CCN == 'psas' || trim($CCN)=='') {
	     die("FAILED!<br>You must select a case.");
	     }
	     if ($CN == 'psac' || trim($CN)=='') {
	     die("FAILED!<br>You must select a crime.");
	     }
	     if ($CN == 'null') {
	     die("FAILED!<br>There are no crimes for this case. You must add the crime before you can add any trials.");
	     }
	     if ($SN == 'psac' || trim($SN)=='') {
	     die("FAILED!<br>You must select a suspect.");
	     }
	     if ($SN == 'null') {
	     die("FAILED!<br>There are no suspects for this case and crime. You must add the suspect before you can add any trials.");
	     }
	     $is_charged = "SELECT * FROM Charged WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
	     $query_ischarged = mysqli_query($dbcon, $is_charged) or die("FAILED! ".mysqli_error($dbcon));
	     if ($query_ischarged->num_rows == 0) {
       die("Failed!<br>The suspect was not charged for this case and crime. If the individual was charged, please remove the suspect using the Remove Suspect function in the Suspects tab via the Main Menu and then re-add the suspect to the case and crime with the date he or she was charged. You may then come back to this page and add a trial for the suspect.");
       }
	     if (!isset($TN) || trim($TN)==''){
       die("FAILED!<br>You must enter the name of the trial.");
       }
       if (!isset($C) || trim($C)==''){
       die("FAILED!<br>You must enter the name of the court.");
       }
       if (!isset($D1) || trim($D1)==''){
       die("FAILED!<br>You must enter the date the trial started.");
       }
       if (!isset($D2) || trim($D2)==''){
       die("FAILED!<br>You must enter the date the trial ended.");
       }
       if (!isset($Ver) || trim($Ver)==''){
       die("FAILED!<br>You must enter the trial verdict.");
       }
         
       //validation that the trial date comes before any plea date, if there is one -- this would be something like an individual went to trial and plead in the middle of it or there was a mistrial and then plead before there could be a new trial or a conviction was overturned and a new trial was going to take place but the suspect plead first
       $after_trial_start = "SELECT MAX(PleaDate) FROM Plea WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
       $query_aftertrialstart = mysqli_query($dbcon, $after_trial_start) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_aftertrialstart);
	     if ($query_aftertrialstart->num_rows > 0 && $row[0] < $D1 && trim($row[0]) != '') { 
       die("Failed!<br>The suspect pled to this case and crime before the entered trial start date. It does not make sense that a suspect would plead and then go to trial for the same crime. The plea date was ".$row[0]." and you entered a trial start date of ".$D1.", for reference. Please check your input. Note, also, that it only makes sense for a plea to come after a trial if the suspect pleads in the middle of the trial, there is a mistrial and the suspect pleads before the next trial, or a conviction is overturned and the suspect pleads before a new trial. Please ensure this is correct.");
       }
      
       //validation that fields are correct types (int, string, etc.)
	     function validateDate($date, $format = 'Y-m-d') {
	     $d = DateTime::createFromFormat($format, $date);
	     return $d && $d->format($format) === $date;
       }
       if (!validateDate($D1) || $D1 > date('Y-m-d')) {
       die("FAILED!<br>The Trial Start Date must be of the format YYYY-MM-DD and cannot be past today's date.<br>Please re-enter the data in the correct format.");
       }
       if (!validateDate($D2) || $D2 > date('Y-m-d')) {
       die("FAILED!<br>The Trial End Date must be of the format YYYY-MM-DD and cannot be past today's date.<br>Please re-enter the data in the correct format.");
       }
       if ($D1 > $D2) {
       die("FAILED!<br>The Trial End Date cannot be before the Trial Start Date.<br>Please re-enter the data in the correct format.");
       }
       $date_check = "SELECT ChargeDate FROM Charged WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
       $query_date_check = mysqli_query($dbcon, $date_check) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_date_check);
       if ($D1 < $row[0]) {
       die("FAILED!<br>The Trial Start Date cannot be before the date the individual was charged for the crime.");
       }
       if ($D2 < $row[0]) {
       die("FAILED!<br>The Trial End Date cannot be before the date the individual was charged for the crime.");
       }
		   
       //insert the sentence in to the Sentence table if it is a new sentence
       if (trim($SL)!='' && ($ST=='select' || trim($ST)=='')) {
	     die("Failed!<br> If you enter a sentence length you must indicate what type of sentence it is for.");
	     }
	     if ((trim($PE)!='select' && trim($PE)!='') && ($ST=='select' || trim($ST)=='')) {
	     die("Failed!<br> If you enter whether a sentence includes parole eligibility you must indicate what type of sentence it is for.");
	     }
	     if (trim($ST)!='' && $ST!='select') {		   
  	   $helper = 0;
	     if ($PE == "Yes") { $PE2 = 1; }
	     if ($PE == "No") { $PE2 = 0; }
	     if ($PE == "N/A") { $PE2 = "NULL"; $helper= 1; } 
       if ($helper == 1) { 
	     $sent_check = "SELECT * FROM Sentence WHERE SentenceType = '$ST' AND SentenceLength = '$SL' AND ParoleEligible IS NULL"; 
       }
	     else { 
	     $sent_check = "SELECT * FROM Sentence WHERE SentenceType = '$ST' AND SentenceLength = '$SL' AND ParoleEligible = $PE2";
	     }
       $query_sentcheck = mysqli_query($dbcon, $sent_check) or die("FAILED! ".mysqli_error($dbcon));
	     if ($query_sentcheck->num_rows == 0) { 
	     $insert = "INSERT INTO Sentence(SentenceType, SentenceLength, ParoleEligible)
                  VALUES('$ST', '$SL', $PE2)";
	     $result = mysqli_query($dbcon, $insert) or die("FAILED! ".mysqli_error($dbcon));
	     }
	     $query_sentcheck2 = mysqli_query($dbcon, $sent_check) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_sentcheck2)[0];
       }
	     else {
	     $row = 21;
	     $ST = '';
	     $PE = '';
	     }
		   
 	     //insert new trial 
	     $insert2 = "INSERT INTO TrialVerdict(CaseColloquialName, CrimeNo, SuspectNo, TrialName, CourtName, TrialStartDate, TrialEndDate, Verdict, SentenceID)
 		               VALUES('$CCN', $CN, $SN, '$TN', '$C', '$D1', '$D2', '$Ver', $row)";
       $result2 = mysqli_query($dbcon, $insert2) or die("FAILED! ".mysqli_error($dbcon));
	
	     //query to later display results
       $query2 = "SELECT * FROM TrialVerdict WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
       $result3 = mysqli_query($dbcon, $query2) or die("FAILED! ".mysqli_error(dbcon));
    ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php
        echo("Succeeded!<br>".$TN_formatted." for Suspect ".$SN." of ".$CCN_formatted." - Crime ".$CN." was added with the following information.");
	      echo("<br>");
	      echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show that the trial was added
       $row = mysqli_fetch_row($result3);
       echo "<table>";
       echo "<tr><td>Case Name:</td><td>".$row[1]."</td></tr>";
       echo "<tr><td>Crime Number:</td><td>".$row[2]."</td></tr>";
       echo "<tr><td>Suspect Number:</td><td>".$row[3]."</td></tr>";
       echo "<tr><td>Trial Name:</td><td>".$row[4]."</td></tr>";
       echo "<tr><td>Court Name:</td><td>".$row[5]."</td></tr>";
       echo "<tr><td>Trial Start Date:</td><td>".$row[6]."</td></tr>";
       echo "<tr><td>Trial End Date</td><td>".$row[7]."</td></tr>";
       echo "<tr><td>Verdict:</td><td>".$row[8]."</td></tr>";
       echo "<tr><td>Sentence Type:</td><td>".$ST."</td></tr>";
       echo "<tr><td>Sentence Length:</td><td>".$SL_formatted."</td></tr>";
       echo "<tr><td>Parole Eligible:</td><td>".$PE."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
