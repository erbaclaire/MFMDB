<html>
<!-- Function to load cases in to the drop down menu -->
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

      div.padding {
      padding: 8px 525px 8px 8px;
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
      textarea {font-size: 20px}
      }

      input[type="text"], textarea {
      background-color: FBFCFC;
      height: 35px;
      width: 500px;
      font-size: 20px;
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
      <font color="cadetblue">Help Keep My Favorite Murder Discussed Plea Deals Up To Date</font>
      <p style="font-size:25;">Add new pleas associated with cases, crimes, and charged individuals discussed on My Favorite Murder or delete any plea deals with inaccurate information. Please re-enter the deleted plea deal with corrected information for any pleas you delete.</p>
    </div>
    
    <!-- Form for adding a plea; uses addPlea.php -->
    <div id="add" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Add a Plea</u></h2>
        If a charged individual pleas on more than one count, please<br/>add the charged individual for each legal count he or she pleads to<br/>for each case/crime/legal count combination.
        <br/>
        <br/>
        <form action="addPlea.php" method="POST">
      	  Select the relevant case from the dropdown menu*<br/>
      	  <select id="ccn" name="ccn" onchange="getCrime(this.value);">
            <option value="psac">Please Select a Case*</option>
	          <?php echo load_cases(); ?>
          </select>
          <br/>
          <br/>
      	  Select the relevant crime from the dropdown menu*<br/>
      	  <select id="crimes" name="crimes" onchange="getSuspect(this.value);">
            <option value="psac">Please Select a Crime*</option>
          </select>
	        <br/>
          <br/>
          Select the relevant suspect from the dropdown menu*<br/>
          <select id="suspects" name="suspects">
            <option value="psas">Please Select a Suspect*</option>
          </select>
          <br/>
          <br/>
          <fieldset style="border:none">
            <label for="LegalCount">Legal Count*</label>
            <br/>
            <input type="text" placeholder="e.g., Homicide in the First Degree" name="LegalCount">
            <br/>
            <br/>
            <label for="Plea">Plea*</label>
            <br/>
            <input type="text" placeholder="e.g., Guilty, No Contest" name="Plea"/>
            <br/>
            <br/>
            <label for="Date">Plea Date*</label>
            <br/>
            <input type="text" placeholder="e.g., 1990-04-12" name="Date"/>
            <br/>
            <br/>
            <label for="SentLength">Sentence Length*</label>
            <br/>
            <input type="text" placeholder="e.g., 1 Year, Life, N/A" name="SentLength"/>
            <br/>
            <br/>
          </fieldset>
	        Sentence Type*<br/>
          <select id="sentence" name="sentence">
            <option value="select">Select*</option>
            <option value="Prison">Prison</option>
            <option value="Death Penalty">Death Penalty</option>
            <option value="Community Service">Community Service</option>
            <option value="Time Served">Time Served</option>
            <option value="Parole">Parole</option>
	          <option value="Combination">Combination</option>
	          <option value="Rolled in to Another Plea">Rolled in to Another Plea</option>
          </select>
          <br/>
          <br/>
          Is the charged individual parole eligible?*<br/>
          <select id="pe" name="pe">
            <option value="select">Select*</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
	          <option value="N/A">N/A</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Add Plea</button>
          <br/>
          <br/>
        </form>
      </font>
    </div>

    <!-- Remove a plea; uses removePlea.php -->
    <div id="remove" align="center" style="font-size:20">
      <font color="dimgray">
        <h2><u>Remove a Plea</u></h2>
        <form action="removePlea.php" method="POST">
	        Select the relevant case from the dropdown menu*<br/>
          <select id="ccn2" name="ccn2" onchange="getCrime(this.value);">
            <option value="psac">Please Select a Case*</option>
	          <?php echo load_cases(); ?>
          </select>
          <br/>
          <br/>
	        Select the relevant crime from the dropdown menu*<br/>
          <select id="crimes2" name="crimes2" onchange="getSuspect2(this.value);">
            <option value="psac">Please Select a Crime*</option>
          </select>
          <br/>
          <br/>
	        Select the relevant charged individual from the dropdown menu*<br/>
          <select id="suspects2" name="suspects2" onchange="getLegalCount(this.value);">
            <option value="psas">Please Select a Charged Individual*</option>
          </select>
          <br/>
          <br/>
          Select the legal count to remove from the dropdown menu*<br/>
          <select id="lcs" name="lcs">
            <option value="psalc">Please Select a Legal Count*</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Remove Plea</button>
          <br/>
	        <br/>
        </form>
      </font>
    </div>

    <!-- See pleas for a suspect; uses seePlea.php -->
    <hr>
    <br/>
    <br/>
    <div align="center" style="font-size:45;">
      <font color="cadetblue">Search Engine</font>
    </div>

    <div id="search" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Learn More About a Plea Deal</u></h2>
      	<h3>Find information on a plea deal such as what sentence<br/>was handed down for a given charged individual.</h3>
	      <form action="searchPlea.php" method="POST">
          Select the charged individual from the dropdown menu*<br/>
          <select id="suspects3" name="suspects3">
	          <option value="psas">Please Select a Charged Individual*</option>
      	    <!-- php code to list all the suspects who have plead to a crime in a dropdown list-->
      	    <?php
      	       //Connection information
               $host = 'mfm-db.c1pgugonorfb.us-east-2.rds.amazonaws.com';
               $username = 'karenandgeorgia';
               $password = 'stevensmustache';
               $database = 'mfmdb';

      	       //connect to database
      	       $dbcon = mysqli_connect($host, $username, $password, $database)or die('Could not connect: ' . mysqli_connect_error());
      	       
      	       //query and insert in to drop down menu
      	       $query = "SELECT DISTINCT CONCAT(TRIM(LastName), ', ', TRIM(FirstName)) AS SuspectConcat
                               FROM SuspectLookup
      			 WHERE LegalCount != ''
      			 ORDER BY SuspectConcat";
      	       $result = mysqli_query($dbcon, $query);
      	       while($row = mysqli_fetch_array($result)) {
      	       echo '<option value="'.$row[0].'">'.$row[0].'</option>';
      	       }
      	       mysqli_close($dbcon);
      	  ?>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Search</button>
          <br/>
          <br/>
          <br/>
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
      $("#crimes2").html(data);
      }
      });
      }
    </script>

    <!-- Script for dynamic drop down menu that shows suspects of a given case/crime when adding a plea -->
    <script>
      function getSuspect(val) {
      var x = document.getElementById("ccn").value;
      $.ajax({
      type: "POST",
      url: "get_suspect.php",
      data: 'CrimeNo='+val+'&CaseColloquialName=' + x,
      success:
      function(data) {
      $("#suspects").html(data);
      }
      });
      }
    </script>

    <!-- Script for dynamic drop down menu that shows suspects of a given case/crime when removing a plea -->
    <script>
      function getSuspect2(val) {
      var x = document.getElementById("ccn2").value;
      $.ajax({
      type: "POST",
      url: "get_suspect.php",
      data: 'CrimeNo='+val+'&CaseColloquialName=' + x,
      success:
      function(data) {
      $("#suspects2").html(data);
      }
      });
      }
    </script>

    <!-- Script for dynamic drop down menu that shows legal counts of a given case/crime/charged individual combination -->
    <script>
      function getLegalCount(val) {
      var x = document.getElementById("ccn2").value;
      var y = document.getElementById("crimes2").value;
      $.ajax({
      type: "POST",
      url: "get_legalcount.php",
      data: 'SuspectNo='+val+'&CaseColloquialName='+x+'&CrimeNo='+y,
      success:
      function(data) {
      $("#lcs").html(data);
      }
      });
      }
    </script>
										    
  </body>

</html>
