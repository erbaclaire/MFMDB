<html>
<head style="font-family:didot">

  <div class="sticky"><center><h2><font color="cadetblue">Number of Times a Weapon Has Been Used in Crimes Discussed on My Favorite Murder</font></h2></center><hr></div>
  <style>
    div.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    font-size: 30px;
    font-family: didot;
    z-index = 1;
    background-color: white;
    }
    
    table {
    font-family: didot;
    font-size: 25;
    border-collapse: collapse;
    width: 60%;
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
      	 
      	 //query count of weapons
         $query = "SELECT WeaponName, COUNT(*) as WeapCount
                   FROM CrimeCarriedOutWithWeapon ccoww
		     JOIN Weapon w ON w.WeaponID = ccoww.WeaponID 
         GROUP BY WeaponName
		     ORDER BY WeapCount DESC, WeaponName";
         $result = mysqli_query($dbcon, $query) or die("FAILED! ".mysqli_error($dbcon));   
      ?>

    </font>
  </div>

  <div align="center">
      
    <?php
       //show result
       echo "<table>";
       echo "<th>Weapon Name</th><th>Number of Times Weapon Was Used in MFM Discussed Crimes</th></tr>";
       while($row = $result->fetch_assoc()) {
       echo "<tr><td>".$row['WeaponName']."</td><td>".$row['WeapCount']."</td></tr>";
       }
       echo "</table>";
       mysqli_close($dbcon);
    ?>
      
  </div>
  
</body>

</html>



	 
