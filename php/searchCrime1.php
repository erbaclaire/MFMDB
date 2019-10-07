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
    text-align: left;
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
      	 $Date1 = $_REQUEST['Date1'];
      	 $Date2 = $_REQUEST['Date2'];

      	 //validation that non-null fields are filled in
      	 if (!isset($Date1) || trim($Date1)==''){
      	 die("0 Results<br>You must enter a start to the date range.");
      	 }
      	 if (!isset($Date2) || trim($Date2)==''){
      	 die("0 Results<br>You must enter an end to the date range.");
      	 }
      	 
      	 //validation that crime is already in the database
      	 function validateDate($date, $format = 'Y-m-d') {
      	 $d = DateTime::createFromFormat($format, $date);
      	 return $d && $d->format($format) === $date;
         }
         if (!validateDate($Date1) || $Date1 > date('Y-m-d') || !validateDate($Date2) || $Date2 > date('Y-m-d') || $Date1 > $Date2) {
         die("0 Results<br>The Date must be of the format YYYY-MM-DD and cannot be past today's date.<br>The end date cannot be before the start date in the date range.<br>Please re-enter the data in the correct format.");
         }

         //query to show results
         $query = "SELECT cr.*, COALESCE(GROUP_CONCAT(CONCAT(vi.FirstName, ' ', vi.LastName) SEPARATOR ', '),'[No Victim Given]') AS Vic 
                   FROM Crime cr
                   LEFT OUTER JOIN Victim vi ON vi.CaseColloquialName = cr.CaseColloquialName AND vi.CrimeNo = cr.CrimeNo
                   WHERE StartDate >= '$Date1' AND EndDate <= '$Date2' 
                   GROUP BY cr.CaseColloquialName, cr.CrimeNo, cr.StartDate, cr.EndDate, cr.LocDesc, cr.Street, cr.City, cr.State_Territory, cr.Country, cr.Zip, cr.Solved
                   ORDER BY StartDate, CaseColloquialName, CrimeNo";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));
      
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show results
       if ($result->num_rows > 0) {
       echo "<table>";
       echo "<th>Case Colloquial Name</th><th>Crime Number</th><th>Crime Name</th><th>Crime Start</th><th>Crime End</th><th>Crime Location Description</th><th>Street</th><th>City</th><th>State</th><th>Zip</th><th>Country</th><th>Solved</th>";
       while($row = $result->fetch_assoc()) {
        if ($row['Solved'] == 0) {
          $solved_flag = "No";
        }
        else {
          $solved_flag = "Yes";
        }
        echo "<tr><td>".$row["CaseColloquialName"]."</td><td>".$row["CrimeNo"]."</td><td>".$row["CrimeName"]." of ".$row["Vic"]."</td><td width=5%>".$row["StartDate"]."</td><td width=5%>".$row["EndDate"]."</td><td>".$row["LocDesc"]."</td><td>".$row["Street"]."</td><td>".$row["City"]."</td><td>".$row["State_Territory"]."</td><td>".$row["Zip"]."</td><td>".$row["Country"]."</td><td>".$solved_flag."</td></tr>";
       }
       echo "</table>";
       }
       else {
       echo "<p style='font-family:didot;'><font color='cadetblue' size='20'>0 Results<br>Please refine your search.</font></p>";
       }
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
