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
      textarea {font-size: 20px;}
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
      <font color="cadetblue">Help Keep My Favorite Murder Discussed Trials Up To Date</font>
      <p style="font-size:25;">Add new trials associated with cases, crimes, and charged individuals discussed on My Favorite Murder or delete any trials with inaccurate information. Please re-enter the deleted trials with corrected information for any trials you delete.</p>
    </div>
    
    <!-- Form for adding a trial; uses addTrial.php -->
    <div id="add" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Add a Trial</u></h2>
        If a charged individual has more than one trial for a given case and crime,<br/>
	     add the charged individual to each case/crime/trial combination.
        <br/>
        <br/>
        <form action="addTrial.php" method="POST">
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
            <label for="TrialName">Trial Name*</label>
            <br/>
            <input type="text" placeholder="e.g., THE PEOPLE, Plaintiffs, v. OJ SIMPSON, Defendant" name="TrialName"/>
            <br/>
            <br/>
	          <label for="Court">Court*</label>
            <br/>
            <input type="text" placeholder="e.g., Sixth Circuit Court" name="Court"/>
            <br/>
            <br/>
            <label for="Date1">Trial Start Date*</label>
            <br/>
            <input type="text" placeholder="e.g., 1990-04-12" name="Date1"/>
            <br/>
            <br/>
	          <label for="Date2">Trial End Date*</label>
            <br/>
            <input type="text" placeholder="e.g., 1990-06-18" name="Date2"/>
            <br/>
            <br/>
	          <label for="Ver">Verdict*</label>
            <br/>
            <input type="text" placeholder="e.g., Guilty, Not Guilty, Mistrial" name="Ver"/>
            <br/>
            <br/>
      	  </fieldset>
      	  <u>Sentence</u><br/>
      	  If a charged individual is found guilty you should enter his or her sentence here!<br/>Do not skip this just because it is not required!<br/><br/>
      	  <fieldset style="border:none">
            <label for="SentLength">Sentence Length</label>
            <br/>
            <input type="text" placeholder="e.g., 1 Year, Life" name="SentLength"/>
            <br/>
            <br/>
          </fieldset>
	        Sentence Type<br/>
          <select id="sentence" name="sentence">
            <option value="select">Select</option>
            <option value="Prison">Prison</option>
            <option value="Death Penalty">Death Penalty</option>
            <option value="CommunityService">Community Service</option>
            <option value="Time Served">Time Served</option>
            <option value="Parole">Parole</option>
	          <option value="Combination">Combination</option>
	          <option value="Rolled in to Another Sentence">Rolled in to Another Sentence</option>
          </select>
          <br/>
          <br/>
          Is the individual parole eligible?<br/>
          <select id="pe" name="pe">
            <option value="select">Select</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
	          <option value="N/A">N/A</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Add Trial</button>
          <br/>
          <br/>
        </form>
      </font>
    </div>

    <!-- Remove a trial; uses removeTrial.php -->
    <div id="remove" align="center" style="font-size:20">
      <font color="dimgray">
        <h2><u>Remove a Trial</u></h2>
        <form action="removeTrial.php" method="POST">
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
	        Select the relevant suspect from the dropdown menu*<br/>
          <select id="suspects2" name="suspects2" onchange="getTrial(this.value);">
            <option>Please Select a Suspect*</option>
          </select>
          <br/>
          <br/>
          Select the relevant trial to remove from the dropdown menu*<br/>
          <select id="trials" name="trials">
            <option value="psat">Please Select a Trial*</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Remove Trial</button>
          <br/>
          <br/>
        </form>
      </font>
     </div>

    <!-- See trials for a suspect; uses searchTrial.php -->
    <hr>
    <br/>
    <br/>
    <div align="center" style="font-size:45;">
      <font color="cadetblue">Search Engine</font>
    </div>

    <div id="remove" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Learn More About a Trial</u></h2>
      	<h3>Find information on a trial such as what sentence<br/>was handed down for a given charged individual.</h3>
      	<form action="searchTrial.php" method="POST">
          Select the charged individual from the dropdown menu*<br/>
          <select id="suspects3" name="suspects3">
	          <option value="psas">Please Select a Charged Individual*</option>
            <!-- php code to list all the suspects who have been tried in a dropdown list-->
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
                         WHERE TrialName != ''
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

    <!-- Script for dynamic drop down menu that shows suspects of a given case/crime when adding a trial -->
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

    <!-- Script for dynamic drop down menu that shows suspects of a given case/crime when removing a trial -->
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
    
    <!-- Script for dynamic drop down menu that shows trial start date of a given case/crime/charged individual combination -->
    <script>
      function getTrial(val) {
      var x = document.getElementById("ccn2").value;
      var y = document.getElementById("crimes2").value;
      $.ajax({
      type: "POST",
      url: "get_trial.php",
      data: 'SuspectNo='+val+'&CaseColloquialName='+x+'&CrimeNo='+y,
      success:
      function(data) {
      $("#trials").html(data);
      }
      });
      }
    </script>
    
  </body>

</html>
