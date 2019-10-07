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
      }

      .button {
      background-color: #4CAF50; /* Green */
      border: none;
      color: white;
      padding: 50px 50px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 23px;
      margin: 4px 2px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      z-index: 1;
      }

      .button1 {
      background-color: white;
      color: black;
      border: 2px solid cadetblue;
      }

      .button1:hover {
      background-color: cadetblue;
      color: white;
      }

      .button2 {
      background-color: #4CAF50; /* Green */
      border: none;
      color: white;
      padding: 50px 100px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 23px;
      margin: 4px 2px;
      -webkit-transition-duration: 0.4s; /* Safari */
      transition-duration: 0.4s;
      cursor: pointer;
      z-index: 1;
      }

      .button3 {
      background-color: white;
      color: black;
      border: 2px solid seagreen;
      }

      .button3:hover {
      background-color: seagreen;
      color: white;
      }

      /* Create three equal columns that floats next to each other */
      .column {
      float: left;
      width: 31%;
      padding: 10px;

      /* Clear floats after the columns */
      .row:after {
      content: "";
      display: table;
      clear: both;
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
    <div align="center" style="font-size:50;">
      <font color="cadetblue">Generate a Report Summarizing Statistics Related to My Favorite Murder and the Cases the Podcast Has Covered</font>
      <p align="left" style="font-size:30;"><font color="dimgray">Two reports of particular interest to a user are:<br/><br/>1) The types of relationships between charged individuals and their victims where the charged was tried and found guilty or plead to the crime against their victim. The general concensus is that you are more likely to be harmed by somebody you know than a stranger. Let's see if the cases discussed on My Favorite Murder support this theory and how this might change over time. In today's day and age are you more likely to get harmed by someone you know than a stranger and how does that compare to the past? for instance. This report combines data from the Charged, SuspectHasRelationshipToVictim, Trial, and Plea tables.<br/><br/>2) The number of pieces of evidence by evidence type for suspects of crimes where the crime was not solved. It is interesting that unsolved crimes with a lot of evidence against a suspect would not be solved. It is interesting to see who these suspects are so that a user could find out more about the case and why it might not be solved. A user could do this via the Search Case application in the Cases tab. It is also interesting to see how pieces of evidence for unsolved crimes change over time. Are unsolved crimes more likely to have circumstantial evidence or forensic and how has this changed over time? for instance. This report combines data from the Evidence, EvidenceImplicatesSuspect, Crime, and Suspect tables.</font></p>
      <br/>
    </div>

    <!-- Forms for generating reports -->
    <div id="row" class="row" style="font-color:dimgray;">
      <div id="col1" align="center" class="column" style="font-size:30;">
	     <form action="countVictims.php" method="POST">
	      Number of Victims<br/>by Race, Gender,<br/>and Age Group
	      <br/>
	      <button align="center" class="button button1" type="submit">Create Report</button>
	     </form>
	     <br/>
	     <form action="episodeLength.php" method="POST">
	      Average Episode<br/>Length by Year<br/>and Recording Location
	      <br/>
	      <button class="button button1" type="submit">Create Report</button>
	     </form>
      </div>
      <div id="col2" class="column" align="center" style="font-size:30;">
	     <form action="countEvidence.php" method="POST">
	      Number of Pieces of Evidence<br/>by Evidence Type for Unsolved</br>Crimes
	      <br/>
	      <button class="button button1" type="submit">Create Report</button>
	     </form>
	     <br/>
	     <form action="countWeapons.php" method="POST">
	      Number of Times<br/>a Weapon Has<br/>Been Used
	      <br/>
	      <button class="button button1" type="submit">Create Report</button>
	     </form>
	     <br/>
	     <br/>
	     <br/>
	     <u>Download All My Favorite Murder Data</u>
	     <br/>
	     <br/>
	     <form align="center" action="download.php" method="POST">
	      <button class="button2 button3" type="submit">Download</button>
	     </form>
      </div>
      <div id="col3" class="column" align="center" style="font-size:30;">
	     <form action="countRelationships.php" method="POST">
	      Relationships Between<br/>Victims and Those<br/>Charged and Found Guilty
	      <br/>
	      <button class="button button1" type="submit">Create Report</button>
	     </form>
	     <br/>
	     <form action="countGuilty.php" method="POST">
	     Guilty Individuals<br/>by Race, Gender,<br/>and Age Group
	     <br/>
	     <button align="center" class="button button1" type="submit">Create Report</button>
	    </form>
    </div>
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
