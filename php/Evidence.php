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
      <font color="cadetblue">Help Keep My Favorite Murder Discussed Evidence Up To Date</font>
      <p style="font-size:25;">Add new evidence associated with cases and crimes discussed on My Favorite Murder or delete any evidence with inaccurate information. Please re-enter the deleted piece of evidence with corrected information for any evidence you delete.<br/></p>
    </div>
    
    <!-- Form for adding evidence; uses addEvidence.php -->
    <div id="add" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Add Evidence</u></h2>
      	If a piece of evidence appears in more than one<br/>
      	case or crime, be sure to add the evidence for each<br/>
      	case/crime combination.
        <br/>
        <br/>
        <form action="addEvidence.php" method="POST">
	       Select the relevant case from the dropdown menu*<br/>
	       <select id="ccn" name="ccn" onchange="getCrime(this.value);">
          <option value="psac">Please Select a Case*</option>
	        <?php echo load_cases(); ?>
         </select>
         <br/>
         <br/>
	       Select the relevant crime from the dropdown menu*<br/>
	       <select id="crimes" name="crimes" onchange="getEvidence(this.value);">
          <option value="psac">Please Select a Crime*</option>
         </select>
	       <br/>
         <br/>
         Select the evidence type from the dropdown menu*<br/>
	       <select id="Etype" name="Etype">
          <option value="select">Please Select the Evidence Type*</option>
          <option value="Circumstantial">Circumstantial</option>
          <option value="Direct">Direct (e.g. A confession)</option>
          <option value="Forensic">Forensic</option>
         </select>
         <br/>
	       <br/>
         <fieldset style="border:none">
          <label for="Item">Item*</label>
          <br/>
          <input type="text" placeholder="e.g., Ransom Note" name="Item"/>
          <br/>
          <br/>
          <label for="Desc">Item Description*</label>
          <br/>
          <input type="text" placeholder="e.g., A ransom note found on the stairs asking for $1,000,000." name="Desc"/>
          <br/>
          <br/> 
          <label for="Pic">Link to a Picture of the Evidence</label>
          <br/>
          <input type="text" placeholder="http://oohlo.com/wp-content/uploads/2016/08/ransom.jpg" name="Pic"/>
          <br/>
          <br/>
          <label for="Video">Link to Video of the Evidence</label>
          <br/>
          <input type="text" placeholder="e.g., https://www.youtube.com/watch?v=CfnEO-6Ca7U" name="Video"/>
          <br/>
          <br/>
          <label for="Implicates">Evidence Implicates Suspect(s)</label>
          <br/>
          <input type="text" placeholder="List of Suspect Numbers the Evidence Implicates, e.g., 1, 2, 3" name="Implicates"/>
          <br/>Don't know what Suspect Number(s) are implicated by the<br/>
	        evidence you want to add? Find them by searching all of the<br/>
          crimes and suspects associated with a case via the Search<br/>
          tool found here: <a href="Cases.php"><font color="black">Search Cases</font></a>.
          <br/>
          <br/>    
         </fieldset>    
         <button class="button button1" type="submit">Add Evidence</button>
         <br/>
         <br/>
        </form>
      </font>
    </div>

    <!-- Form for removing evidence; uses removeEvidence.php -->
    <div id="remove" align="center" style="font-size:20;">
      <font color="dimgray">
        <h2><u>Remove Evidence</u></h2>
        If a piece of evidence is cited in more than one crime or case,<br/>
	      ensure you are removing the piece of evidence from the correct<br/>
	      crime/case combinations.
        <br/>
        <br/>
        <form action="removeEvidence.php" method="POST">
	      Select the relevant case from the dropdown menu*<br/>
          <select id="ccn2" name="ccn2" onchange="getCrime(this.value);">
            <option value="psac">Please Select a Case*</option>
	          <?php echo load_cases(); ?>
          </select>
          <br/>
          <br/>
	        Select the relevant crime from the dropdown menu*<br/>
          <select id="crimes2" name="crimes2" onchange="getEvidence(this.value);">
            <option value="psac">Please Select a Crime*</option>
          </select>
          <br/>
          <br/>
	        Select a piece of evidence to remove from the dropdown menu*<br/>
          <select id="evidence" name="evidence">
            <option value="pse">Please Select a Piece of Evidence*</option>
          </select>
          <br/>
          <br/>
          <button class="button button1" type="submit">Remove Evidence</button>
          <br/>
          <br/>
        </form>
      </font>
    </div>
    
    <!-- Form for searching for a evidemce; uses searchEvidence.php -->
    <hr>
    <br/>
    <br/>
    <div align="center" style="font-size:45;">
      <font color="cadetblue">Search Engine</font>
    </div>

    <div id="search" align="center" style="font-size:20;">
      <font color="dimgray">
    	<h2><u>See the Evidence</u></h2>
    	<h3>Where available, see the evidence for a case up close and personal.</h3>								    
    	<form action="searchEvidence.php" method="POST">
    	  Select the relevant case from the dropdown menu*<br/>
        <select id="ccn3" name="ccn3" onchange="getCrime(this.value);">
         <option value="psac">Please Select a Case*</option>
    	   <?php echo load_cases(); ?>
        </select>
        <br/>
        <br/>
    	  Select the relevant crime from the dropdown menu*<br/>
        <select id="crimes3" name="crimes3" onchange="getEvidence2(this.value);">
         <option value="psac">Please Select a Crime*</option>
        </select>
    	  <br/>
        <br/>
    	  Select a piece of evidence from the dropdown menu*<br/>
        <select id="evidence2" name="evidence2">
         <option value="pse">Please Select a Piece of Evidence*</option>
        </select>
    	  <br/>
    	  <br/>
    	  <button class="button button1" type="submit">Search</button>
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
    $("#crimes3").html(data);
    }
    });
    }
    </script>

    <!-- Script for dynamic drop down menu that shows evidence of a given case/crime (remove) -->
    <script>
    function getEvidence(val) {
    var x = document.getElementById("ccn2").value;
    $.ajax({
    type: "POST",
    url: "get_evidence.php",
    data: 'CrimeNo='+val+'&CaseColloquialName=' + x,
    success:
    function(data) {
    $("#evidence").html(data);
    }
    });
    }
    </script>

    <!-- Script for dynamic drop down menu that shows evidence of a given case/crime (search) -->
    <script>
    function getEvidence2(val) {
    var x = document.getElementById("ccn3").value;
    $.ajax({
    type: "POST",
    url: "get_evidence.php",
    data: 'CrimeNo='+val+'&CaseColloquialName=' + x,
    success:
    function(data) {
    $("#evidence2").html(data);
    }
    });
    }
    </script>

  </body>

</html>
