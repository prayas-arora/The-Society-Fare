<?php
require 'core.inc.php';
require 'connect.inc.php';

?>

<?php

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password_hash = md5($password);
  if (!empty($username) && !empty($password)) {
    $query = @"SELECT `id` FROM `users` WHERE `username` = '$username' AND `password` = '$password_hash'; ";
    if ($query_run = @mysqli_query($conn,$query)) {
      $query_num_rows = @mysqli_num_rows($query_run);
      if ($query_num_rows==0) {
        echo '
        <script>
        document.write(window.alert("The username or password did not match"));
        </script>
        ';
      }
      elseif ($query_num_rows==1) {
        $row = mysqli_fetch_assoc($query_run);
        $user_id = $row['id'];
        $_SESSION['user_id'] = $user_id;
        header('Location: homePage.php');
      }
    }
  }
  else{
    echo "None of the fields can be empty";
  }
}

?>

<!DOCTYPE html>
<html>
<title>The Society Fair</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" type="text/css" href="css/homePageStyles.css">
<!--LIGHTBOX-->
<link rel="stylesheet" type="text/css" href="lightbox2-master/dist/css/lightbox.css">
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <a class="navbar-brand pull-left visible-sm visible-md visible-lg" target="_blank" href="http://www.thapar.edu/" style="text-decoration: none;">
      <div class="LOGO img-responsive">
        <img src="images/TULogo2.png">
      </div>
      <h3 class="w3-padding-44" style="font-size: 27px;">Thapar University</h3> 
    </a>
  </div>
  <div class="w3-bar-block">
    <!--a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a-->
    <a href="#showcase" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Showcase</a>

    <?php
    if (!loggedin()) {
      echo '<a href="#login" id="loginToggle" onclick="document.getElementById(`id01`).style.display=`block`" class="w3-bar-item w3-button w3-hover-white">Society Coordinator Login</a>';
    }else{
     echo '<a href="logout.php" class="w3-bar-item w3-button w3-hover-white">Logout</a>';
    }
    ?>  
    <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">About</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Thapar University</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Login Form-->
<div id="loginForm">
  <div id="id01" class="modal">
    <form class = "modal-content animate" action = "<?php echo $current_file; ?>" method = "POST">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="images/Avatar/admin.png" alt="Avatar" class="avatar">
      </div>

      <div class="container-fluid">
          <label><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="username" required>

          <label><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password" required>
            
          <button type="submit">Login</button>
      
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </div>
    </form>
  </div>
</div>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:10px" id="showcase">
    <h1 class="w3-jumbo"><b>The Society Fair</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Showcase.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>
  
  <!-- Photo grid (modal) -->
  <div class="w3-row-padding">
    <div class="w3-half">
      <a href="#CCS" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"> <img src="images/CCS/CCS_LOGO.png" style="width:400px;" alt="Creative Computing Society"> </a>
       <a href="#TEDx" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"> <img src="images/TEDx/TEDx-logo.jpg" style="width:100%" alt="TEDx"> </a>
       <a href="#MSC" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"> <img src="images/MSC/logo_msc.png" style="width:400px; height: 400px;" alt="Microsoft Student Chapter"> </a>
    </div>

    <div class="w3-half">
      <a href="#SSA" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"> <img src="images/Virsa/LOGO1.jpg" style="width:100%;"  alt="Spiritual Scientist Alliance"> </a>
      <a href="#IEEE" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white"> <img src="images/IEEE/IEEE_LOGO.jpg" style="width:300px;" alt="IEEE"> </a>
  </div>

  <!-- CCS -->
    <div class="w3-container" style="margin-top:75px">
      <h1 class="w3-xxxlarge w3-text-red" id = "CCS"><b>Creative Computing Society.</b></h1>
      <hr style="width:50px; border:5px solid red" class="w3-round">
      <p>We are a interior design service that focus on what's best for your home and what's best for you!</p>
      <p>Some text about our services - what we do and what we offer. We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
      dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
      incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
      </p>
      
  
  <!-- Spiritual Scientist Alliance -->
  <div class="w3-container" id="SSA" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Spiritual Scientist Alliance.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p>The best team in the world.</p>
    <p>We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
    incididunt ut labore et quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </p>
    <!--p><b>Our designers are thoughtfully chosen</b>:</p-->
  </div>

  <!-- TEDx -->
  <div class="w3-container" id="TEDx" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>TEDx.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p>The best team in the world.</p>
    <p>We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
    incididunt ut labore et quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </p>
    <!--p><b>Our designers are thoughtfully chosen</b>:</--p>
  </div>

  <!-- IEEE -->
  <div class="w3-container" id="IEEE" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>IEEE.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p>The best team in the world.</p>
    <p>We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
    incididunt ut labore et quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </p>
    <!--p><b>Our designers are thoughtfully chosen</b>:</p-->
  </div>
  <ul>
        <br><li style="cursor: pointer;" onclick="toggle('2k17')"><h5>Events: 2k17</h5></li><br>
        <ul id="2k17" style="display: none;">
          <li style="cursor: pointer;" onclick="toggle('Event_1_2k17')">Invited Talk May_1_2k17</li>
          <div id="Event_1_2k17" style="display: none;">
          <h4><b>Invited Talk May_1_2k17</b></h4>
          <p style="white-space: pre-wrap;">
            <b>IEEE Student Chapter, Thapar University</b>
IEEE Event:      How to Crack Civil Service Exams in First Attempt
Date:        May 1, 2017          Venue:       C- Hall
Time:          5:05 pm to 7:30 p.m.
No. of Students Attended:  Sixty Two
Facebook Link:    https://www.facebook.com/ieee.thapar/
Speaker:       Mr. Lachman Singh (Delhi based Academician)
Brief Bio:      Mr. Lachman Singh Maluka is Director at MALUKA’S IAS, Delhi. He has done his Masters from School of Governance at MIT, Pune. He has five years of experience in teaching general studies. Recently, He has started his own civil services institute in Jan 2016. And in a very short span of time he has produced good results. In the first batch of twenty six students, twenty two students cleared Prelims. Nine of them cleared Mains. He has recently opened one of the branches at Patiala and is soon planning to open more institutes in Punjab. He has done agreement with MISSION IAS in Amravati (Maharashtra) for providing free education to poor students. In every institute, he would provide free coaching to 20 poor and hard-working students. He has done agreement with Suryoday Institute (Indore, Madhya Pradesh) to provide free online classes from June-July 2017 for IAS/PCS in 250 institutes of higher education allocated to Suryoday Institute by Madhya Pradesh Government. 
 
Poster Circulated:
<img style="width: 50%;" src="IEEE/IEEE Student Chapter_ Event_ Invited Talk May 1 2017/poster_invited_talk_may_1_2k17.png">
<h6><b>Report:</b></h6>
This event was organized on demand of third year students. Approximately fifty Students of all branches and batches attended the event enthusiastically. Students spared precious time from their busy schedule in last week of the semester. The session started with a motivational speech by Mr. Lachman Singh where he highlighted some social issues existing in the nation.  In the latter session, the speaker discussed the strategies on how to crack and prepare for civil services exam. Mr. Saurav Sharma described the eligibility criteria, the right age to start preparing for civil services exam and kind of zeal and determination needed to be a bureaucrat. Mr. Lachman Singh and Mr. Saurav Sharma answered students’ queries regarding civil services preparation in last half an hour of the session. The students were really keen to know about the preparation strategies that the one hour session stretched to two and a half hour.
          </p>
          <div class="row">
            <div class="column">
              <a href="IEEE/IEEE Student Chapter_ Event_ Invited Talk May 1 2017/image_1.jpg" rel="lightbox[IEEE-poster_invited_talk_may_1_2k17]" style="text-decoration: none;"> <b><h5>Event Gallery</b></h5> </a>
              <a href="IEEE/IEEE Student Chapter_ Event_ Invited Talk May 1 2017/image_2.jpg" rel="lightbox[IEEE-poster_invited_talk_may_1_2k17]"></a>
              <a href="IEEE/IEEE Student Chapter_ Event_ Invited Talk May 1 2017/image_3.jpg" rel="lightbox[IEEE-poster_invited_talk_may_1_2k17]"></a>
              <a href="IEEE/IEEE Student Chapter_ Event_ Invited Talk May 1 2017/image_4.jpg" rel="lightbox[IEEE-poster_invited_talk_may_1_2k17]"></a>
              <a href="IEEE/IEEE Student Chapter_ Event_ Invited Talk May 1 2017/image_5.jpg" rel="lightbox[IEEE-poster_invited_talk_may_1_2k17]"></a>
            </div>
          </div>
      
        </div>
        </ul>
        
        <li><a href="#" style="text-decoration: none;"><h5>Events: 2k16</h5></a></li><br>
        <li><a href="#" style="text-decoration: none;"><h5>Events: 2k15</h5></a></li>
      </ul>
    </div>

  <!-- MSC -->
  <div class="w3-container" id="MSC" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Microsoft Student Chapter.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p>The best team in the world.</p>
    <p>We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
    incididunt ut labore et quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </p>
    <!--p><b>Our designers are thoughtfully chosen</b>:</p-->
  </div>
  <!-- The Team -->
  <!--div class="w3-row-padding w3-grayscale">
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="/w3images/team2.jpg" alt="John" style="width:100%">
        <div class="w3-container">
          <h3>John Doe</h3>
          <p class="w3-opacity">CEO & Founder</p>
          <p>Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.</p>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="/w3images/team1.jpg" alt="Jane" style="width:100%">
        <div class="w3-container">
          <h3>Jane Doe</h3>
          <p class="w3-opacity">Designer</p>
          <p>Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.</p>
        </div>
      </div>
    </div>
    <div class="w3-col m4 w3-margin-bottom">
      <div class="w3-light-grey">
        <img src="/w3images/team3.jpg" alt="Mike" style="width:100%">
        <div class="w3-container">
          <h3>Mike Ross</h3>
          <p class="w3-opacity">Architect</p>
          <p>Phasellus eget enim eu lectus faucibus vestibulum. Suspendisse sodales pellentesque elementum.</p>
        </div>
      </div>
    </div>
  </div-->
  
  <!-- Contact -->
  <div class="w3-container" id="contact" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Contact.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p>Do you want us to style your home? Fill out the form and fill me in with the details :) We love meeting new people!</p>
    <form action="/action_page.php" target="_blank">
      <div class="w3-section">
        <label>Name</label>
        <input class="w3-input w3-border" type="text" name="Name" required>
      </div>
      <div class="w3-section">
        <label>Email</label>
        <input class="w3-input w3-border" type="text" name="Email" required>
      </div>
      <div class="w3-section">
        <label>Message</label>
        <input class="w3-input w3-border" type="text" name="Message" required>
      </div>
      <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom">Send Message</button>
    </form>  
  </div>

<!-- End page content -->
</div>

<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

// Get the Login Form modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}

function toggle(temp) {
    var x = document.getElementById(temp);
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
</script>
<script src="lightbox2-master/dist/js/lightbox-plus-jquery.js"></script>
</body>
</html>
