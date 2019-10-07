<!-- Function to load cases in to the drop down menu -->
<html>
<?php
   function load_cases() {
      //connection information
      $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
      $username = 'karenandgeorgia';
      $password = 'stevensmustache';
      $database = 'mfmdb';

       //connect to database
        $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());

       //query and insert in to drop down menu
        $query = "SELECT CaseColloquialName FROM Cases ORDER BY CaseColloquialName";
        $result = mysqli_query($dbcon, $query);
        while($row = mysqli_fetch_array($result)) {
        echo '<option value="'.$row[0].'">'.$row[0].'</option>';
        }
       mysqli_close($dbcon);
   }
?>
</html>

<html>

  <!-- Header and Main Menu navigator -->
  <head style="font-family:didot;">
    <div class="sticky"><font color="white"><span style="font-size:25px;cursor:pointer" onclick="openNav()">&#9776; Main Menu</span></font></div>
    
    <!-- Classes for the main menu navigator -->
    <style>

      body {
      font-family: "didot";
      }

      .sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #111;
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
      }

      .sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 25px;
      color: #818181;
      display: block;
      transition: 0.3s;
      }

      .sidenav a:hover {
      color: #f1f1f1;
      }

      .sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
      }

      #main {
      transition: margin-left .5s;
      padding: 16px;
      }

      @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
      }

      div.sticky {
      position: -webkit-sticky;
      position: sticky;
      background-color: black;
      top: 0;
      padding: 50px;
      font-size: 20px;
      z-index: 1;
      }

      .button {
      background-color: #4CAF50; /* Green */
      border: none;
      color: white;
      padding: 13px 26px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 20px;
      font-family: didot;
      margin: 4px 2px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      }

      .button1 {
      background-color: white;
      color: dimgray;
      border: 2px solid cadetblue;
      }

      .button1:hover {
      background-color: cadetblue;
      color: white;
      }

      fieldset {
      font-size: 20px;
      padding: 0;
      }
      
      select {
      font-size: 20px;
      font-family: didot;
      textarea {font-size: 20px;}
      }

      input[type="text"], textarea {
      background-color: FBFCFC;
      height: 35px;
      width: 500px;
      font-size: 20;
      font-family: didot;
      }
      
    </style>
  </head>

  <body style="background-color:white;">

    <!-- Add links to navigation menu -->
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="index.php">Home</a>
      <a href="Episodes.php">MFM Episodes</a>
      <a href="Cases.php">Cases</a>
      <a href="Crimes.php">Crimes</a>
      <a href="Victims.php">Victims</a>
      <a href="Suspects.php">Suspects</a>
      <a href="Evidence.php">Evidence</a>
      <a href="Pleas.php">Pleas</a>
      <a href="Trials.php">Trials</a>
      <a href="datawarehouse.php">Data Warehouse</a>
    </div>

    <hr>
    <div align="center" style="font-size:45;">
      <font color="cadetblue">Help Keep My Favorite Murder Discussed Crimes Up To Date</font>
      <p style="font-size:25;">Add new crimes associated with cases discussed on My Favorite Murder or delete any crimes that are inaccurate. Please re-enter the deleted crime with corrected information for any crimes you delete. If you add a crime make sure to add all of the victims, suspects, evidence, pleas, and trials relating to the crime using the links in the Main Menu.</p>
    </div>
    
    <!-- Form for adding a crime; uses addCrime.php -->
    <div id="add" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Add a Crime</u></h2>
        <form action="addCrime.php" method="POST">
	        Select the relevant case from the dropdown menu*<br/>
          <select name="Case" id="Case">
	          <option value="">Please Select a Case*</option>
            <?php echo load_cases(); ?>
	        </select>
          <br/>
          <br/>
          <fieldset style="border:none">
            <label for="CrimeName">Crime Name*</label>
            <br/>
            <input type="text" placeholder="e.g., Murder, Rape" name="CrimeName"/>
            <br/>
            <br/>
            <label for="CrimeStart">Crime Started On*</label>
            <br/>
            <input type="text" placeholder="e.g., 1990-04-12" name="CrimeStart"/>
            <br/>
            <br/>
            <label for="CrimeEnd">Crime Ended On*</label>
            <br/>
            <input type="text" placeholder="e.g., 1990-04-12" name="CrimeEnd"/>
            <br/>
            <br/>
            <u>Location Crime Took Place</u>
      	    <br/>
            <label for="LocDesc">Location Description</label>
      	    <br/>
      	    <input type="text" placeholder="e.g., Ramsey residence" name="LocDesc"/>
            <br/>
            <label for="Street">Street</label>
      	    <br/>
      	    <input type="text" placeholder="e.g., 4th Street, Apt. 3" name="Street"/>
            <br/>
            <label for="City">City*</label>
      	    <br/>
      	    <input type="text" placeholder="e.g., St. Louis" name="City"/>
            <br/>
            <label for="State">State or Territory*</label>
      	    <br/>
      	    <input type="text" placeholder="e.g., AL, WI, ON, PR" name="State"/>
            <br/>
            <label for="Country">Country*</label>
      	    <br/>
      	    <input type="text" placeholder="e.g., US, CA, MX" name="Country"/>
            <br/>
            <label for="Zip">Zip Code</label>
      	    <br/>
      	    <input type="text" placeholder="e.g., 60615, M1R 0E9" name="Zip"/>
            <br/>
            <br/>
            <label for="Weapons">What Weapon(s) Were Used in the Commission of this Crime?<br>Please enter as a list e.g., Gun, Knife</label>
            <br/>
            <input type="text" placeholder="e.g., .22 Caliber gun" name="Weapons"/>
      	  </fieldset>
      	  <br/>
      	  Was The Crime Solved?*<br/>
          <select name="Solved">
            <option value='select'>Select*</option>
            <option value="Yes">Yes</option>
            <option value="Yes">No</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Add Crime</button>
          <br/>
          <br/>
        </form>
      </font>
    </div>

    <!-- Form for removing a crime; uses removeCrime.php -->
    <div id="remove" align="center" style="font-size:20;">
      <font color="dimgray">
        <form action="removeCrime.php" method="POST">
          <h2><u>Remove a Crime</u></h2>
      	  <h3>WARNING: Removing a crime will remove all victims,<br/>suspects, trial or pleas, and any and all data relating<br/>to the crime from the database.</h3>
      	  Select the relevant case from the dropdown menu*<br/>
      	  <select id="ccn" name="ccn" onchange="getCrime(this.value);">
      	    <option value="psac">Please Select a Case*</option>
            <?php echo load_cases(); ?>
      	  </select>
          <br/>
          <br/>	  
	        Select a crime to remove from the dropdown menu*<br/>
          <select id="crimes" name="crimes">
            <option value="psac">Please Select a Crime*</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Remove Crime</button>
          <br/>
          <br/>
        </form>
      </font>
    </div>

    <!-- Forms for searching all the crimes between a date range, in a given city, state, or a given crime type; uses searchCrime1.php, searchCrime2.php, and searchCrime3.php -->
    <hr>
    <br/>
    <br/>
    <div align="center" style="font-size:45;">
    <font color="cadetblue">Search Engine</font>
    </div>
    
    <div id="search" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Learn More About Crimes</u></h2>
      	<h3>Find details of crimes discussed on MFM including<br/>the location, date, and whether it was solved<br/>or not.</h3>
      	<h3>Search by Date Range</h3>
      	<form action="searchCrime1.php" method="POST">
      	  <fieldset style="border:none">
      	    <label for="Date1">Date Range*</label>
      	    <br/>
      	    <input type="text" style="width:250;" placeholder="e.g., 1990-04-12" name="Date1"/>
      	    <label for="Date2"> - </label>
      	    <input type="text" style="width:250;" placeholder="e.g., 1990-12-31" name="Date2"/>
      	    <br/>
      	    <br/>
      	    <button class="button button1" type="submit">Search</button>
      	  </fieldset>
      	</form>
      	<h3>Search by City and State</h3>
      	<form action="searchCrime2.php" method="POST">
      	  <fieldset style="border:none">
      	    <label for="CS">City, State*</label>
      	    <br/>
      	    <input type="text" placeholder="e.g., St. Louis, MO" name="CS"/>
      	    <br/>
      	    <br/>
      	    <button class="button button1" type="submit">Search</button>
      	    <br/>
      	    <br/>
      	  </fieldset>
        </form>
        <h3>Search by Crime Type</h3>
        <form action="searchCrime3.php" method="POST">
          <fieldset style="border:none">
      	    <label for="type">Crime Type*</label>
      	    <br/>
            <input type="text" placeholder="e.g., Murder, Rape" name="type"/>
            <br/>
            <br/>
            <button class="button button1" type="submit">Search</button>
            <br/>
            <br/>
          </fieldset>
        </form>
      </font>
    </div>

    <!-- Script for navigator -->
    <script>
      function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
      }

      function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
      }
    </script>

    <!-- Script for dynamic drop down menu that shows crimes of a given case -->
    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script>
    function getCrime(val) {
    $.ajax({
    type: "POST",
    url: "get_crime.php",
    data: 'CaseColloquialName='+val,
    success:
    function(data) {
    $("#crimes").html(data);
    }
    });
    }   
    </script>
    
  </body>

</html>


