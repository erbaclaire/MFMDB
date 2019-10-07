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
      
      	 //Connection information
         $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
         $username = 'karenandgeorgia';
         $password = 'stevensmustache';
         $database = 'mfmdb';
      	 
      	 //connect to database
      	 $dbcon = mysqli_connect($host, $username, $password, $database)
      	 or die('Could not connect: ' . mysqli_connect_error());
      	 
      	 //get input
      	 $cs = str_replace("'", "''", $_REQUEST['CS']);

      	 //validation that non-null fields are filled in
      	 if (!isset($cs) || trim($cs)==''){
      	 die("0 Results<br>You must enter a city and state.");
      	 }
      	 
      	 //validation that the city and state are separated by a comma and that the state is the two letter abbreviation
         if (strpos($cs, ",") == false) {
         die("0 Results<br>Please separate the city and state by a comma.");
         }
         $city_state = explode(",", $cs);
         $city =  trim($city_state[0]);
         $state =  trim($city_state[1]);
         if (strlen($state) != 2) {
         die("0 Results<br>Please use the two letter state abbreviation (e.g., AL, ON, PR).");
         }

	 //query to show results
         $query = "SELECT cr.*, COALESCE(GROUP_CONCAT(CONCAT(vi.FirstName, ' ', vi.LastName) SEPARATOR ', '), '[No Victim Given]') AS Vic 
                   FROM Crime cr
                   LEFT OUTER JOIN Victim vi ON vi.CaseColloquialName = cr.CaseColloquialName AND vi.CrimeNo = cr.CrimeNo 
		               WHERE City = '$city' AND State_Territory = '$state' 
		               GROUP BY cr.CaseColloquialName, cr.CrimeNo, cr.CrimeName, cr.StartDate, cr.EndDate, cr.LocDesc, cr.Street, cr.City, cr.State_Territory, cr.Country, cr.Zip, cr.Solved
                   ORDER BY StartDate, cr.CaseColloquialName, cr.CrimeNo";		
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



	 
