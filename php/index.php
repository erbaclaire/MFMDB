<html>
	
  <!-- Header and Main Menu navigator -->
  <head style="font-family:didot;">
    <div class="sticky"><font color="white"><span style="font-size:25px;cursor:pointer" onclick="openNav()">&#9776; Main Menu</span></font></div>
    <center><img src="https://desmoinesperformingarts.org/documents/event/featured/001002.1540567089.jpg" width="1600", height="500"></center>
    <br/>
    <br/>
    <br/>
    <center><h1><font color="white" size=100>MY FAVORITE MURDER: THE DATABASE</font></h1></center>
    
    <!-- Classes for the main menu navigator -->
    <meta name="viewport" contect="width=device-width, initial-scale=1">
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
      .container-fluid {text-align: center;}
      }

      div.sticky {
      position: -webkit-sticky;
      position: sticky;
      background-color: black;
      top: 0;
      padding: 50px;
      font-size: 20px;
      }

    </style>
  </head>

  <body style="background-color:black;">
    
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

    <!-- Text and added body images -->
    <div id="navMain" class="contained" align="center" style="font-family:didot;">
      <p><font color="white" size=5>This website catalogues episodes of MFM and the cases they cover.
  	  It houses details on the crimes, victims, suspects, evidence, pleas and
  	  trials discussed in those episodes. Information on minisodes is not
  	  included. Go to the Data Warehouse to find statistics on the cases covered by
  	  MFM. Explore the other sections to add, remove, or search information
  	  on specific cases, crimes, victims, suspects, evidence, and more.</font></p>
      <center><img src="https://ih0.redbubble.net/image.478249217.5481/flat,550x550,075,f.u1.jpg" width="500", height="500"></center>
      <center><img src="https://res.cloudinary.com/teepublic/image/private/s--W6A0h_SE--/t_Preview/b_rgb:686268,c_limit,f_jpg,h_630,q_90,w_630/v1528224662/production/designs/2758792_0.jpg" width="275", height="275">
        <img src="https://ih0.redbubble.net/image.567247409.5901/raf,750x1000,075,t,101010:01c5ca27c6.jpg" width="275", height="275">       
        <img src="https://ih0.redbubble.net/image.464993821.5035/flat,550x550,075,f.u1.jpg" width="275", height="275">
      </center>
      <p><font color="white" size=3>Disclaimer: The database is not a product of My Favorite Murder nor does it seek to profit 
			in any way from the use of MFM materials. Visit <a href="https://www.myfavoritemurder.com/"><font color="white">The MFM Official Website</font></a> for more information on My Favorite Murder.</font></p> 
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

