<!-- Function to load cases in to the drop down menu -->
<html>
  <?php
     function load_cases() {
     //Connection information
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
      textarea {font-size: 20px};
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
    
    <!-- Form for adding a case; uses addCase.php -->
    <hr>
    <div align="center" style="font-size:45;">
      <font color="cadetblue">Help Keep My Favorite Murder Discussed Cases Up To Date</font>
      <p style="font-size:25;">Add new cases discussed on My Favorite Murder or delete any cases that are inaccurate. Please re-enter the deleted cases with corrected information for any cases you delete. If you add a case make sure to add all of the crimes, victims, suspects, evidence, pleas, and trials relating to the case using the links in the Main Menu.</p>
    </div>
    
    <div id="add" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Add a Case</u></h2>
        <form action="addCase.php" method="POST">
          <fieldset style="border:none">
            <label for="CaseColloquialName">Case Name*</label>
            <br/>
            <input type="text" placeholder="e.g., The Rape and Murder of Angela Samota" name="CaseColloquialName"/>
            <br/>
            <br/>
            <label for="Pic">Link to Case Picture*</label>
            <br/>
            <input type="text" placeholder="e.g., https://fakephoto.jpg" name="Pic"/>
            <br/>
            <br/>
            <label for="Link">Link for More Information*</label>
            <br/>
            <input type="text" placeholder="e.g., https://en.wikipedia.org/wiki/Golden_State_Killer" name="Link"/>
            <br/>
            <br/>
            <label for="Episodes">Episodes That Discuss the Case*</label>
            <br/>
            <input type="text" placeholder="Enter Episode Numbers as a List, e.g., 1, 2, 3" name="Episodes"/>
            <br/>
            <br/>
            <button class="button button1" type="submit">Add Case</button>
            <br/>
            <br/>
          </fieldset>
        </form>
      </font>
    </div>

    <!-- Form for removing a case; uses removeCase.php and a dynamic drop down menu -->
    <div id="remove" align="center" style="font-size:20;"> 
      <font color="dimgray">
        <h2><u>Remove a Case</u></h2>
      	<h3>WARNING: Removing a case will remove all crimes, <br/>victims, suspects, trial or pleas, and any and all data<br/>relating to the case from the database.</h3>
      	<form action="removeCase.php" method="POST">	  
      	  Select a case to remove from the dropdown menu*<br/>
      	  <select id="ccn" name="ccn">;
        	  <option value = "psac">Please Select a Case*</option>
        	  <?php echo load_cases(); ?>
      	  </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Remove Case</button>
          <br/>
          <br/>
        </form>
      </font>
    </div>

    <!-- Form for searching a case and grabbing the details of that case (crimes, suspects, charged, etc.); uses searchCase.php -->
    <hr>
    <br/>
    <br/>
    <div align="center" style="font-size:45;">
      <font color="cadetblue">Search Engine</font>
    </div>
    
    <div id="search" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Learn More About a Case</u></h2>
      	<h3>Find information on crimes, victims,<br/>suspects, evidence, pleas and trials<br/>associated with a case.</h3>
        <form action="searchCase.php" method="POST">
      	  Select a case from the dropdown menu*<br/>
      	  <select id="ccn2" name="ccn2">;
        	  <option value = "psac">Please Select a Case*</option>
        	  <?php echo load_cases(); ?>
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

  </body>

</html>
