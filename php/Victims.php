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
      <font color="cadetblue">Help Keep My Favorite Murder Discussed Victims Up To Date</font>
      <p style="font-size:25;">Add new victims associated with cases and crimes discussed on My Favorite Murder or delete any victims with inaccurate information. Please re-enter the deleted victim with corrected information for any victims you delete.</p> 
    </div>

    <!-- Form for adding a victim; uses addVictim.php -->
    <div id="add" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Add a Victim</u></h2>
        If a victim is the victim in more than one crime or case,<br/>please add the victim to each case/crime combination.
        <br/>
        <br/>
        <form action="addVictim.php" method="POST">
      	  Select the relevant case from the dropdown menu*<br/>
      	  <select id="ccn" name="ccn" onchange="getCrime(this.value);">
            <option value="psac">Please Select a Case*</option>
	          <?php echo load_cases() ?>
          </select>
          <br/>
          <br/>
      	  Select the relevant crime from the dropdown menu*<br/>
      	  <select id="crimes" name="crimes">
            <option value="psac">Please Select a Crime*</option>
          </select>
          <br/>
          <br/>
          <fieldset style="border:none">
            <label for="FName">First Name*</label>
            <br/>
            <input type="text" placeholder="e.g., John" name="FName"/>
            <br/>
            <br/>
            <label for="MName">Middle Name</label>
            <br/>
            <input type="text" placeholder="e.g., Henry" name="MName"/>
            <br/>
            <br/>
            <label for="LName">Last Name*</label>
            <br/>
            <input type="text" placeholder="e.g., Doe" name="LName"/>
            <br/>
            <br/>
            <label for="Age">Age*</label>
            <br/>
            <input type="text" placeholder="e.g., 13" name="Age"/>
            <br/>
            <br/>
            <label for="Harm">Harm to the Victim*</label>
            <br/>
            <input type="text" placeholder="e.g., Death from gunshot to the head." name="Harm"/>
            <br/>
            <br/>
          </fieldset>
	        Gender*<br/>
          <select id="gender" name="gender">
            <option value='select'>Select*</option>
            <option value="M">M</option>
            <option value="F">F</option>
          </select>
          <br/>
          <br/>
	        Race*<br/>
          <select id="race" name="race">
            <option value='select'>Select*</option>
            <option value="Asian">Asian or Pacific Islander</option>
            <option value="Black">Black</option>
            <option value="Caucasian">Caucasian</option>
            <option value="Hispanic">Hispanic/Latino(a)</option>
            <option value="Native American">Native American</option>
            <option value="Other">Other</option>
	          <option value="Unknown">Unknown</option>
          </select>
          <br/>
          <br/>            
          <button class="button button1" type="submit">Add Victim</button>
          <br/>
          <br/>
        </form>
      </font>
    </div>

        
    <!-- Form for Removing a victim; uses removeVictim.php -->
    <div id="remove" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Remove a Victim</u></h2>
        If a victim is the victim of more than one crime or case,<br/>ensure you are removing the victim from the<br/>correct case/crime combinations.
        <br/>
        <br/>
        <form action="removeVictim.php" method="POST">
	        Select the relevant case from the dropdown menu*<br/>
          <select id="ccn2" name="ccn2" onchange="getCrime(this.value);">
            <option value="psac">Please Select a Case*</option>
	          <?php echo load_cases(); ?>
          </select>
          <br/>
          <br/>
	        Select the relevant crime from the dropdown menu*<br/>
          <select id="crimes2" name="crimes2" onchange="getVictim(this.value);">
            <option value="psac">Please Select a Crime*</option>
          </select>
          <br/>
          <br/>
	        Select a victim to remove from the dropdown menu*<br/>
          <select id="victims" name="victims">
            <option value="psav">Please Select a Victim*</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Remove Victim</button>
          <br/>
          <br/>
        </form>
      </font>
     </div>

    <!-- Form for searching for a victim; uses searchVictim.php -->
    <hr>
    <br/>
    <br/>
    <div align="center" style="font-size:45;">
     <font color="cadetblue">Search Engine</font>
    </div>
    
    <div id="search" align="center" style="font-size:20;">
        <font color="dimgray">
          <h2><u>Learn More About a Victim</u></h2>
          <h3>Find information on a victim such as what<br/>cases and crimes they are associated with,<br/> what harm befell them, and demographic<br/>information such as their age, race, and gender.</h3>
	        <form action="searchVictim.php" method="POST">
	          <fieldset style="border:none">
              <label for="FName">First Name</label>
	            <br/>
              <input type="text" name="FName"/>
	            <br/>
	            <br/>
	            <label for="LName">Last Name*</label>
	            <br/>
	            <input type="text" name="LName">
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
      $("#crimes2").html(data);
      }
      });
      }
    </script>
    
    <!-- Script for dynamic drop down menu that shows victims of a given case/crime -->
    <script>
      function getVictim(val) {
      var x = document.getElementById("ccn2").value;
      $.ajax({
      type: "POST",
      url: "get_victim.php",
      data: 'CrimeNo='+val+'&CaseColloquialName=' + x,
      success:
      function(data) {
      $("#victims").html(data);
      }
      });
      }
    </script>
    
  </body>

</html>
