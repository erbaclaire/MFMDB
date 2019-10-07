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
      opacity: 1;
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
      <font color="cadetblue">Help Keep My Favorite Murder Episodes Up To Date</font>
      <p style="font-size:25;">Add new episodes of My Favorite Murder or delete any episodes that are inaccurate. Please re-enter the deleted episode with corrected information for any episodes you delete. If you add an episode make sure to add all of the cases, crimes, victims, suspects, evidence, pleas, and trials discussed on the episode using the links in the Main Menu.</p>
    </div>
    
    <!-- Form for adding an episode; uses addEpisode.php -->
    <div id="add" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Add an Episode</u></h2>
        <form action="addEpisode.php" method="POST">
          <fieldset class="fs" style="border:none">
            <label for="EpisodeNumber">Episode Number*</label>
            <br/>
            <input type="text" placeholder="e.g., 1" name="EpisodeNumber"/>
            <br/>
            <br/>
            <label for="EpisodeTitle">Title*</label>
            <br/>
            <input type="text" placeholder="e.g., Live at the Fox Theatre" name="EpisodeTitle"/>
            <br/>
            <br/>
            <label for="EpisodeDate">Date Aired*</label>
            <br/>
            <input type="text" placeholder="e.g., 1990-04-12" name="EpisodeDate"/>
            <br/>
            <br/>
            <label for="EpisodeLocation">Recording Location*</label>
            <br/>
            <input type="text" placeholder="e.g., Podloft" name="EpisodeLocation"/>
            <br/>
            <br/>
            <label for="Link">Link to Episode*</label>
            <br/>
            <input type="text" placeholder="e.g., http://podbay.fm/show/1074507850/e/1558000800?autostart=1" name="EpisodeLink">
            <br/>
            <br/>
            <label for="EpisodeLength">Episode Length (Minutes)*</label>
            <br/>
            <input type="text" placeholder="e.g., 180.35" name="EpisodeLength"/>
            <br/>
            <br/>
            <button class="button button1" type="submit">Add Episode</button>
            <br/>
            <br/>
          </fieldset>
        </form>	  
      </font>
     </div>
      
    <!-- Form for removing an episode; uses removeEpisode.php -->
    <div id="remove" align="center" style="font-size:20;">
        <font color="dimgray">
          <h2><u>Remove an Episode</u></h2>
          <form action="removeEpisode.php" method="POST">
            <fieldset style="border:none">
              <label for="EpisodeNumber">Episode Number*</label>
              <br/>
              <input type="text" placeholder="e.g., 1" name="EpisodeNumber"/>
              <br/>
              <br/>
              <button class="button button1" type="submit">Remove Episode</button>
              <br/>
              <br/>
            </fieldset>
          </form>
        </font>
    </div>
    
    <!-- Forms for searching an episode; uses searchEpisode1.php, searchEpisode2.php, and searchEpisode3.php -->
    <hr>
    <br/>
    <br/>
    <div align="center" style="font-size:45;">
      <font color="cadetblue">Search Engine</font>
    </div>
    
    <div id="search" align="center" style="font-size:20;">
      <font color="dimgray">	
    	<h3>Search by Episode Number</h3>
    	<form action="searchEpisode1.php" method="POST">
    	  <fieldset style="border:none">
    	    <label for="EpisodeNumber">Episode Number*</label>
    	    <br/>
    	    <input type="text" placeholder="e.g., 1" name="EpisodeNumber"/>
    	    <br/>
    	    <br/>
    	    <button class="button button1" type="submit">Search</button>
    	    <br/>
    	  </fieldset>
    	</form>
    	<h3>Search by Episode Air Date Range</h3>
    	<form action="searchEpisode2.php" method="POST">
    	  <fieldset style="border:none">
    	    <label for="Date1">Date Range*</label>
    	    <br/>
    	    <input type="text" style="width:250;" placeholder="e.g., 1990-04-12" name="Date1"/>
    	    <label for="Date2"> - </label>
    	    <input type="text" style="width:250;" placeholder="e.g., 1991-04-12" name="Date2"/>
    	    <br/>
    	    <br/>
    	    <button class="button button1" type="submit">Search</button>
    	  </fieldset>
    	</form>
    	<h3>Search for Live Shows</h3>
    	<form action="searchEpisode3.php" method="POST">
    	  <fieldset style="border:none">
    	    <label for="LS">Live Show City*</label>
    	    <br/>
    	    <input type="text" placeholder="e.g., St. Louis" name="LS"/>
    	    <br/>
    	    <br/>
    	    <button class="button button1" type="submit">Search</button>
    	    <br/>
    	    <br/>
    	  </fieldset>
    	</form>
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
