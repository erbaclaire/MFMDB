<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Results</font></h2></center><hr></div>
  <style>
    div.sticky {
    position: -webkit-sticky;
    position: sticky;
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
      	 $FN = str_replace("'", "''", $_REQUEST['FName']);
      	 $LN = str_replace("'", "''", $_REQUEST['LName']);

      	 //validation that non-null fields are filled in
      	 if (!isset($LN) || trim($LN)==''){
      	 die("0 Results<br>You must enter at least the last name of the suspect.");
      	 }
      	 
      	 //query to later show results
         if (!isset($FN) || trim($FN)=='') {
         $query = "SELECT sccl.*, a.Vic
                  FROM SuspectCrimeCountLookup sccl
                  LEFT OUTER JOIN (SELECT cr.CaseColloquialName, cr.CrimeNo, COALESCE(GROUP_CONCAT(CONCAT(vi.FirstName, ' ', vi.LastName) SEPARATOR ', '), '[No Victim Given]') AS Vic
                                   FROM Crime cr
                                   LEFT OUTER JOIN Victim vi ON vi.CaseColloquialName = cr.CaseColloquialName AND vi.CrimeNo = cr.CrimeNo
                                   GROUP BY cr.CaseColloquialName, cr.CrimeNo
                                   ) a ON a.CaseColloquialName = sccl.CaseColloquialName AND a.CrimeNo = sccl.CrimeNo 
                   WHERE LastName = '$LN'"; 		     
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
	       }
	       else {
         $query = "SELECT sccl.*, a.Vic
                  FROM SuspectCrimeCountLookup sccl
                  LEFT OUTER JOIN (SELECT cr.CaseColloquialName, cr.CrimeNo, COALESCE(GROUP_CONCAT(CONCAT(vi.FirstName, ' ', vi.LastName) SEPARATOR ', '), '[No Victim Given]') AS Vic
                                   FROM Crime cr
                                   LEFT OUTER JOIN Victim vi ON vi.CaseColloquialName = cr.CaseColloquialName AND vi.CrimeNo = cr.CrimeNo
                                   GROUP BY cr.CaseColloquialName, cr.CrimeNo
                                   ) a ON a.CaseColloquialName = sccl.CaseColloquialName AND a.CrimeNo = sccl.CrimeNo
                  WHERE (FirstName LIKE '%FN%'OR FirstName = '$FN') AND LastName = '$LN'";

         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));           
         }
      
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       if ($result->num_rows==0) {
           echo "<p style='font-family:didot;'><font color='cadetblue' size='20'>0 Results<br>Please refine your search.</font></p>";
       }
       else{
       echo "<table>";
       echo "<th>Case Name</th><th>Crime Number</th><th>Crime Name</th><th>Suspect Number</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Gender</th><th>Race</th><th>Age</th><th width='50'>Date Charged</th><th width='10'>Motive</th><th>Alibi</th>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['CaseColloquialName']."</td><td>".$row['CrimeName']."</td><td>".$row['SuspectNo']."</td><td>".$row['FirstName']."</td><td>".$row['MiddleName']."</td><td>".$row['LastName']."</td><td>".$row['Gender']."</td><td>".$row['Race']."</td><td>".$row['Age']."</td><td>".$row['ChargeDate']."</td><td width=10%>".$row['Motive']."</td><td width=10%>".$row['Alibi']."</td></tr>";
      }}
      echo "</table>";
      mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
