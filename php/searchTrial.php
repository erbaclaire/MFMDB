<html>    
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Results</font></h2></center><hr></div>
  <style>
    div.sticky {
    top: 0;
    font-size: 40px;
    font-family: didot;
    z-index = 1;
    background-color: white;
    }
    
    table {
    font-family: didot;
    font-size: 15;
    border-collapse: collapse;
    width: 100%;
    }
    
    td {
    border: 1px solid dimgray;
    text-align: center;
    padding: 8px;
    }

    tr:nth-child(even) {
    background-color: #dddddd;
    }
    
    th {
    position: -webkit-sticky;
    position: sticky;
    color: cadetblue;
    text-align: center;
    padding: 8px;
    border: 1px solid dimgray;
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
      	 $S = str_replace("'", "''", $_REQUEST['suspects3']);

      	 //validation that non-null fields are filled in
      	 if ($S=='psas' || trim($S)==''){
      	 die("0 Results<br>You must select a charged individual.");
      	 }
      	 
      	 //query to later show results
	       $ln_fn = explode(", ", $S);
         $query = "SELECT * FROM TrialLookup WHERE LastName = '$ln_fn[0]' AND FirstName = '$ln_fn[1]' AND TrialName != '' ORDER BY CrimeNo";     	 
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
         
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       echo "<table>";
       echo "<tr><th>Case</th><th colspan='2'>Crime</th><th colspan='10'>Charged Individual</th><th colspan='5'>Trial Details</th><th colspan='3'>Sentence</th></tr>";
       echo "<tr><th>Case Name</th><th>Crime Number</th><th>Crime Name</th><th>Suspect Number</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Gender</th><th>Race</th><th>Age</th><th width='10'>Motive</th><th>Alibi</th><th>Date Charged</th><th>Trial Name</th><th>Court Name</th><th>Trial Start Date</th><th>Trial End Date</th><th>Verdict</th><th>Sentence Type</th><th>Sentence Length</th><th>Parole Eligible</th></tr>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['CaseColloquialName']."</td><td>".$row['CrimeNo']."</td><td>".$row['CrimeName']." of ".$row['VictimConcat']."</td><td>".$row['SuspectNo']."</td><td>".$row['FirstName']."</td><td>".$row['MiddleName']."</td><td>".$row['LastName']."</td><td>".$row['Gender']."</td><td>".$row['Race']."</td><td>".$row['Age']."</td><td>".$row['Motive']."</td><td>".$row['Alibi']."</td><td width=7%>".$row['ChargeDate']."</td><td>".$row['TrialName']."</td><td>".$row['CourtName']."</td><td width=7%>".$row['TrialStartDate']."</td><td width=7%>".$row['TrialEndDate']."</td><td>".$row['Verdict']."</td><td>".$row['TrialSentenceType']."</td><td>".$row['TrialSentenceLength']."</td><td>".$row['TrialParoleEligible']."</td></tr>";
       }
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
