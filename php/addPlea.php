<html>
<head style="font-family:didot">
  <div><font size="45" color="cadetblue"><br/><br/><br/><center>Your Attempt to Add a Plea Discussed on My Favorite Murder:</center></font></div>
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
       $LC = str_replace("'", "''", $_REQUEST['LegalCount']);
	     $LC_formatted = str_replace("''", "'", $LC);
       $Plea = str_replace("'", "''", $_REQUEST['Plea']);
	     $Plea_formatted = str_replace("''", "'", $Plea);
	     $PD =  $_REQUEST['Date'];
	     $ST =  $_REQUEST['sentence'];
       $SL =  str_replace("'", "''", $_REQUEST['SentLength']);
	     $SL_formatted = str_replace("''", "'", $SL);
	     $PE =  $_REQUEST['pe'];

	     //don't allow legal count to have double quotes
	     if (strpos($LC,"\"") !== false) {
       die("Please remove double quotes from the Legal Count. You can replace the double quotes with single quotes.");
       }

	     //validation that non-null fields are filled in
	     if ($CCN == 'psac' || trim($CCN)=='') {
	     die("FAILED!<br>You must select a case.");
	     }
	     if ($CN == 'psac' || trim($CN)=='') {
	     die("FAILED!<br>You must select a crime.");
	     }
	     if ($CN == 'null') {
	     die("FAILED!<br>There are no crimes for this case. You must add the crime before you can add any pleas.");
	     }
	     if ($SN == 'psas' || trim($SN)=='') {
	     die("FAILED!<br>You must select a suspect.");
	     }
	     if ($SN == 'null') {
	     die("FAILED!<br>There are no suspects for this case and crime. You must add the suspect before you can add any pleas.");
	     }
	     $is_charged = "SELECT * FROM Charged WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
	     $query_ischarged = mysqli_query($dbcon, $is_charged) or die("FAILED! ".mysqli_error($dbcon));
	     if ($query_ischarged->num_rows == 0) {
       die("Failed!<br>The suspect was not charged for this case and crime. If the individual was charged, please remove the suspect using the Remove Suspect function on the Suspects page via the Main Menu and then re-add the suspect to the case and crime with the date he or she was charged. You may then come back to this page and add a plea for the suspect.");
       }
	     if (!isset($LC) || trim($LC)==''){
       die("FAILED!<br>You must enter the legal count the charged individual is pleading to.");
       }
       if (!isset($Plea) || trim($Plea)==''){
       die("FAILED!<br>You must enter the charged individual's plea (e.g., Guilty, No Contest, Alford Plea, etc.).");
       }
       if (!isset($PD) || trim($PD)==''){
       die("FAILED!<br>You must enter the date the charged individual pled to the legal count.");
       }
       if ($ST=='select' || trim($ST)==''){
       die("FAILED!<br>You must select the type of sentence the charged individual got for this plea. If the sentence is rolled up in to another sentence then select 'Rolled in to Another  Sentence' from the dropdown menu.");
       }
       if (!isset($SL) || trim($SL)==''){
       die("FAILED!<br>You must enter the length of the sentence the charged individual got from this plea. If the sentence in rolled up in to another sentence then enter 'N/A'.");
       }
       if ($PE=='select' || trim($PE)==''){
       die("FAILED!<br>You must select whether or not the charged individual is parole eligible given the sentence that was handed down for the plea. If a sentence is rolled up in to another sentence then select 'N/A'");
       }

       //validation that the plea date comes after the trial date, if there is one -- this would be something like an individual went to trial and plead in the middle of it or there was a mistrial and then plead before there could be a new trial or a conviction was overturned and a new trial was going to take place but the suspect plead first
       $after_trial_start = "SELECT MAX(TrialStartDate) FROM TrialVerdict WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
       $query_aftertrialstart = mysqli_query($dbcon, $after_trial_start) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_aftertrialstart);
	     if ($query_ischarged->num_rows > 0 && $row[0] > $PD) {
       die("Failed!<br>A trial took place for this case, crime, and suspect and the plea date entered was before the trial date. It does not make sense that a suspect would plea and then go to trial for the same crime. The trial start date was $row[0] and you entered a plea date of $PD, for reference. Please check your input. Note, also, that it only makes sense for a plea to come after a trial if the suspects pleads in the middle of the trial, there is a mistrial and the suspect pleads before the next trial, or a conviction is overturned and the suspect pleads before a new trial. Please ensure this is correct.");
       }
      
       //validation that fields are correct types (int, string, date etc.) and formatted correctly
	     function validateDate($date, $format = 'Y-m-d') {
	     $d = DateTime::createFromFormat($format, $date);
	     return $d && $d->format($format) === $date;
       }
       if (!validateDate($PD) || $PD > date('Y-m-d')) {
       die("FAILED!<br>The Plea Date must be of the format YYYY-MM-DD and cannot be past today's date.<br>Please re-enter the data in the correct format.");
       }
       $date_check = "SELECT ChargeDate FROM Charged WHERE CaseColloquialName = '$CCN' AND CrimeNo = $CN AND SuspectNo = $SN";
       $query_date_check = mysqli_query($dbcon, $date_check) or die("FAILED! ".mysqli_error($dbcon));
       $row = mysqli_fetch_row($query_date_check);
       if ($PD < $row[0]) {
       die("FAILED!<br>The Plea Date cannot be before the date the individual was charged for the crime.");
       }
		   
      //insert the sentence in to the Sentence table if it is a new sentence
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
	
	    //insert new plea 
	    $insert2 = "INSERT INTO Plea(CaseColloquialName, CrimeNo, SuspectNo, LegalCount, Guilty_NoContest, PleaDate, SentenceID)
 		              VALUES('$CCN', $CN, $SN, '$LC', '$Plea', '$PD', $row)";
      $result2 = mysqli_query($dbcon, $insert2) or die("FAILED! ".mysqli_error($dbcon));
      mysqli_free_result($result);
    ?>
      
    </font>
  </div>

  <div align="center" style="font-size:40;">
    <font color="green">

      <?php   
        echo("Succeeded!<br>The Plea to ".$LC_formatted." from Suspect ".$SN." of ".$CCN_formatted." - Crime ".$CN." was added with the following information.");
	      echo("<br>");
	      echo("<br>");
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show that the suspect was added
       echo "<table>";
       echo "<tr><td>Case Name:</td><td>".$CCN_formatted."</td></tr>";
       echo "<tr><td>Crime Number:</td><td>".$CN."</td></tr>";
       echo "<tr><td>Suspect Number:</td><td>".$SN."</td></tr>";
       echo "<tr><td>Legal Count:</td><td>".$LC_formatted."</td></tr>";
       echo "<tr><td>Plea:</td><td>".$Plea_formatted."</td></tr>";
       echo "<tr><td>Plea Date</td><td>".$PD."</td></tr>";
       echo "<tr><td>Sentence Type:</td><td>".$ST."</td></tr>";
       echo "<tr><td>Sentence Length:</td><td>".$SL_formatted."</td></tr>";
       echo "<tr><td>Parole Eligible:</td><td>".$PE."</td></tr>";
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
