<?php
require 'core.inc.php';
require 'connect.inc.php';

if (loggedin()) {
  $firstname = getfield('users','firstname');
  $lastname = getfield('users','lastname');

  
  echo '<div style="margin-left: 22.5%;"><h5>Hello '.$firstname.' '.$lastname.'</h5></div>';   
}
?>

<!--Logging Users IN-->
<?php
global $user_id;
if (isset($_POST['username']) && isset($_POST['password'])) {
  $newEventForm = 0;
  $newSubEventForm = 0;
  $username = $_POST['username'];
  $password = $_POST['password'];
  if (!empty($username) && !empty($password)) {
  $password_hash = md5($password);
    $query = @"SELECT `id` FROM `users` WHERE `username` = '".mysqli_real_escape_string($conn,$username)."' AND `password` = '".mysqli_real_escape_string($conn,$password_hash)."'; ";
    if ($query_run = @mysqli_query($conn,$query)) {
      $query_num_rows = @mysqli_num_rows($query_run);
      if ($query_num_rows==0) {
        echo '
        <script>
        document.write(alert("The username or password did not match"));
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

<!--New Event Form Validation-->
<?php

if (loggedin()) {
  if($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 2){
    $society_table_name = 'ccs_events';
    $society_sub_event_table_name = 'ccs_sub_events';
    $event_gallery = 'ccs_event_gallery';
  }
    if($_SESSION['user_id'] == 3 || $_SESSION['user_id'] == 4){
      $society_table_name = 'ssa_events';
      $society_sub_event_table_name = 'ssa_sub_events';
      $event_gallery = 'ssa_event_gallery';
  }
    if($_SESSION['user_id'] == 5){
      $society_table_name = 'msc_events';
      $society_sub_event_table_name = 'msc_sub_events';
      $event_gallery = 'msc_event_gallery';
  }
    if($_SESSION['user_id'] == 6){
      $society_table_name = 'owasp_events';
      $society_sub_event_table_name = 'owasp_sub_events';
      $event_gallery = 'owasp_event_gallery';
  }
    if($_SESSION['user_id'] == 7){
      $society_table_name = 'tedx_events';
      $society_sub_event_table_name = 'tedx_sub_events';
      $event_gallery = 'tedx_event_gallery';
  }
    if ($_SESSION['user_id'] == 8){
      $society_table_name = 'ieee_events';
      $society_sub_event_table_name = 'ieee_sub_events';
      $event_gallery = 'ieee_event_gallery';
    }

    if (isset($_POST['event_name'])) {
      if (!empty($_POST['event_name'])) {
        $event_name = mysqli_real_escape_string($conn,$_POST['event_name']);
      }else{
        $event_name = NULL;
      }
      if (!empty($_POST['event_date'])) {
        $event_date = mysqli_real_escape_string($conn,$_POST['event_date']);
      }else{
        $event_date = NULL;
      }
      if (!empty($_POST['event_year'])) {
        $event_year = mysqli_real_escape_string($conn,$_POST['event_year']);
      }else{
        $event_year = NULL;
      }
      if (!empty($_POST['event_time'])) {
        $event_time = mysqli_real_escape_string($conn,$_POST['event_time']); 
      }else{
        $event_time = NULL;
      }
      if (!empty($_POST['event_venue'])) {
        $event_venue = mysqli_real_escape_string($conn,$_POST['event_venue']);   
      }else{
        $event_venue = NULL;
      }
      if (!empty($_POST['event_bio'])) {
        $event_bio = mysqli_real_escape_string($conn,$_POST['event_bio']);
      }else{
        $event_bio = NULL;
      }
      if (!empty($_POST['event_report'])) {
        $event_report = mysqli_real_escape_string($conn,$_POST['event_report']);
      }else{
        $event_report = NULL;
      }
      if (!empty($_POST['no_of_students'])) {
        $no_of_students = mysqli_real_escape_string($conn,$_POST['no_of_students']);
      }else{
        $no_of_students = NULL;
      }
      if (!empty($_POST['event_speaker'])) {
        $event_speaker = mysqli_real_escape_string($conn,$_POST['event_speaker']);
      }else{
        $event_speaker = NULL;
      }

      //Processing Images
      $msg = "";

      //POSTER  
        $max_file_size = 1024*1024*10; //10 mb

        $poster_name = NULL;
        if (@$_FILES['poster_image']['name']) {
        $poster_name = @$_FILES['poster_image']['name'];
        $poster_size = @$_FILES['poster_image']['size'];
        $poster_type = @$_FILES['poster_image']['type'];
        $poster_tmp_name = @$_FILES['poster_image']['tmp_name'];
        $extension = strtolower(substr($poster_name, strrpos($poster_name,'.') + 1));

        if (isset($poster_name)) {
          if(!empty($poster_name)){
            if (($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') && ($type = 'image/*') && ($poster_size < $max_file_size)) {
              $location = 'IEEE/uploads/posters/main_events/';

              if(move_uploaded_file($poster_tmp_name, $location.$poster_name)){}
              else{
                echo '
                    <script>
                      alert("There was an error uploading poster");
                    </script>
                ';
              }
            }
            else{
              echo "Poster must be jpg/jpeg/png and 10mb or less";
            }
          }
        }
      }

      $query = "INSERT INTO $society_table_name (`event_id`, `event_name`, `event_date`, `event_time`, `event_year`, `event_venue`, `no_of_students`, `event_speaker`, `event_poster`, `brief_bio`, `event_report`) VALUES ('', '$event_name', '$event_date', '$event_time', '$event_year', '$event_venue', '$no_of_students', '$event_speaker', '$poster_name', '$event_bio', '$event_report')";
    
      if (mysqli_query($conn,$query)) {}
        else{
        echo '
          <script>
            alert("Insert query failed!");
          </script>
        ';
      }

        
  // GALLERY Images
        $valid_formats = array("jpg", "jpeg", "png", "gif", "zip", "bmp");
        $path = "IEEE/uploads/gallery/main_events/"; // Upload directory
        $count = 0;

        foreach ($_FILES['gallery_images']['name'] as $f => $name) {     
          if ($_FILES['gallery_images']['error'][$f] == 4) {
              echo '
              <script>
              alert("There was an error in inserting gallery images. Redirecting...");
              </script>
            ';
              header('Location: homePage.php');
              exit;
              //continue; // Skip file if any error found
          }
          if ($_FILES['gallery_images']['error'][$f] == 0) {             
              if ($_FILES['gallery_images']['size'][$f] > $max_file_size) {
                  $message[] = "$name is too large!.";
                  echo '
                    <script>
                    alert("'.$name.' is too large");
                    </script>
                  ';
                  header('Location: homePage.php');
                  exit;
                  //continue; // Skip large files
              }
          elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
          
            $message[] = "$name is not a valid format";
            echo '
              <script>
              alert("'.$name.' is not a valid format");
              </script>
            ';
            header('Location: homePage.php');
            exit;
            //continue; // Skip invalid file formats
          }
              else{ // No error found! Move uploaded files

                $event_id = NULL;
                  if(move_uploaded_file($_FILES["gallery_images"]["tmp_name"][$f], $path.$name)){
                    $query = "select `event_id` from $society_table_name ORDER BY `event_id` desc LIMIT 1";
                    if($query_run = mysqli_query($conn,$query)){
                      if ($row = mysqli_fetch_assoc($query_run)) {
                        $event_id = $row['event_id'];
                      }else{
                        echo '
                          <script>
                          alert("There was an error in uploading gallery images");
                          </script>
                        ';
                      }
                    }else{
                      echo '
                        <script>
                        alert("Check your Query");
                        </script>
                      ';
                    }

                    $sql = "INSERT INTO `$event_gallery` (`main_event_id`, `main_event_image`) VALUES ('$event_id', '$name')";
                    if(!mysqli_query($conn, $sql)){
                      echo '
                        <script>
                        alert("Check your gallery insertion query");
                        </script>
                      ';
                    }else{
                      $count++; // Number of successfully uploaded file
                      
                    }

                  }
              }
          }
      }
      header('Location: homePage.php');
      exit;
    
  }


    //$result = mysqli_query($conn, "SELECT `images` FROM $event_gallery, $society_table_name where $event_gallery.`event_id` = '$society_table_name.`event_id`'"  );

}
?>

<!--New sub-event Form Validation-->
<?php
if (loggedin()) {
    $check_main_events_query = "select `event_id` from $society_table_name";
    if ($check_main_events_query_run = mysqli_query($conn,$check_main_events_query)) {
    $query_num_rows = mysqli_num_rows($check_main_events_query_run);
      if ($query_num_rows ==0 ) {
        echo '
              <script>
                alert("There are no existing main events in the society database.");
              </script>
            ';
        //header('Location: homePage.php');
        //exit;
      }
    }
    if ( $query_num_rows > 0) {

    if (isset($_POST['sub_event_name']) && isset($_POST['sub_event_year'])) {
      echo '
          <script>
            alert("jkfdvn");
          </script>
        ';
      if ($_POST['BIG_event_name'] != NULL) {
        $main_event_name = $_POST['BIG_event_name'];
        echo '
          <script>
            alert("'.$main_event_name.'jkfdvn");
          </script>
        ';
      }
      else{
        echo '
          <script>
            alert("Please select a main event to which sub-event needs to be added from the list");
          </script>
        ';
      }
      if (!empty($_POST['sub_event_name'])) {
        $sub_event_name = mysqli_real_escape_string($conn,$_POST['sub_event_name']);
      }else{
        $sub_event_name = NULL;
      }
      if (!empty($_POST['sub_event_date'])) {
        $sub_event_date = mysqli_real_escape_string($conn,$_POST['sub_event_date']);
      }else{
        $sub_event_date = NULL;
      }
      if (!empty($_POST['sub_event_year'])) {
        $sub_event_year = mysqli_real_escape_string($conn,$_POST['sub_event_year']);
      }else{
        $sub_event_year = NULL;
      }
      if (!empty($_POST['sub_event_time'])) {
        $sub_event_time = mysqli_real_escape_string($conn,$_POST['sub_event_time']); 
      }else{
        $sub_event_time = NULL;
      }
      if (!empty($_POST['sub_event_venue'])) {
        $sub_event_venue = mysqli_real_escape_string($conn,$_POST['sub_event_venue']);   
      }else{
        $sub_event_venue = NULL;
      }
      if (!empty($_POST['sub_event_bio'])) {
        $sub_event_bio = mysqli_real_escape_string($conn,$_POST['sub_event_bio']);
      }else{
        $sub_event_bio = NULL;
      }
      if (!empty($_POST['sub_event_report'])) {
        $sub_event_report = mysqli_real_escape_string($conn,$_POST['sub_event_report']);
      }else{
        $sub_event_report = NULL;
      }
      if (!empty($_POST['sub_event_no_of_students'])) {
        $sub_event_no_of_students = mysqli_real_escape_string($conn,$_POST['sub_event_no_of_students']);
      }else{
        $sub_event_no_of_students = NULL;
      }
      if (!empty($_POST['sub_event_speaker'])) {
        $sub_event_speaker = mysqli_real_escape_string($conn,$_POST['sub_event_speaker']);
      }else{
        $sub_event_speaker = NULL;
      }

      //Processing Images
      $msg = "";

        $max_file_size = 1024*1024*10; //10 mb

        $sub_event_poster_name = NULL;
        if ($_FILES['sub_event_poster_image']['name']) {
        $sub_event_poster_name = @$_FILES['sub_event_poster_image']['name'];
        $sub_event_poster_size = @$_FILES['sub_event_poster_image']['size'];
        $sub_event_poster_type = @$_FILES['sub_event_poster_image']['type'];
        $sub_event_poster_tmp_name = @$_FILES['sub_event_poster_image']['tmp_name'];
        $sub_event_extension = strtolower(substr($sub_event_poster_name, strrpos($sub_event_poster_name,'.') + 1));

        if (isset($sub_event_poster_name)) {
          if(!empty($sub_event_poster_name)){
            if (($sub_event_extension == 'jpg' || $sub_event_extension == 'jpeg' || $sub_event_extension == 'png') && ($type = 'image/*') && ($sub_event_poster_size < $max_file_size)) {
              $location = 'IEEE/uploads/posters/sub_events/';

              if(move_uploaded_file($sub_event_poster_tmp_name, $location.$sub_event_poster_name)){}
              else{
                echo '
                    <script>
                      alert("There was an error uploading poster");
                    </script>
                ';
              }
            }
            else{
              echo "Poster must be jpg/jpeg/png and 10mb or less";
            }
          }
        }
      }

      $sub_event_query = "select `event_id`,`curr_no_of_sub_events` from $society_table_name where `event_name` = '$main_event_name' ";
      $sub_event_query_run = @mysqli_query($conn,$sub_event_query);

      if (($query_num_rows = @mysqli_num_rows($sub_event_query_run)) != 1) {
        if($query_num_rows == 0) {
          echo '
          <script>
            alert("No such main event exists!");
          </script>
        ';
        }
        if ($query_num_rows > 1) {
          echo '
          <script>
            alert("Multiple main events of same name exist!");
          </script>
        ';
        }

      }else{
       while ($row = mysqli_fetch_assoc($sub_event_query_run)) {
              $main_event_id = $row['event_id'];
              $sub_event_id = $row['curr_no_of_sub_events'] + 1;
            } 
      } 
      if ($sub_event_id == 0 || $main_event_id == 0) {
        echo '
        <script>
          alert("Please select a main event to which sub-event needs to be added from the list");
        </script>
        ';
        header('Location: homePage.php');
        exit;
      }
      $query = "INSERT INTO $society_sub_event_table_name (`main_event_id`, `sub_event_id`, `sub_event_name`, `sub_event_date`, `sub_event_time`, `sub_event_year`, `sub_event_venue`, `sub_event_no_of_students`, `sub_event_speaker`, `sub_event_poster`, `sub_event_brief_bio`, `sub_event_report`) VALUES ('$main_event_id', '$sub_event_id', '$sub_event_name', '$sub_event_date', '$sub_event_time', '$sub_event_year', '$sub_event_venue', '$sub_event_no_of_students', '$sub_event_speaker', '$sub_event_poster_name', '$sub_event_bio', '$sub_event_report')";
    
      if (mysqli_query($conn,$query)) {
        $another_query = "UPDATE $society_table_name SET `curr_no_of_sub_events` = $sub_event_id where `event_id` = '$main_event_id'";
        if (!mysqli_query($conn,$another_query)) {
          echo '
          <script>
            alert("There was an error in updating the main event table!");
          </script>
        ';
        }
      }
        else{
        echo '
          <script>
            alert("There was an error in adding the sub-event!");
          </script>
        ';
      }

        
  // GALLERY Images
        $valid_formats = array("jpg", "jpeg", "png", "gif", "zip", "bmp");
        $path = "IEEE/uploads/gallery/sub_events/"; // Upload directory
        $count = 0;

        foreach ($_FILES['sub_event_gallery_images']['name'] as $f => $name) {     
          if ($_FILES['sub_event_gallery_images']['error'][$f] == 4) {
            echo '
              <script>
              alert("There was an error in inserting gallery images. Redirecting...");
              </script>
            ';
              header('Location: homePage.php');
              exit;
              //continue; // Skip file if any error found
          }
          if ($_FILES['sub_event_gallery_images']['error'][$f] == 0) {             
              if ($_FILES['sub_event_gallery_images']['size'][$f] > $max_file_size) {
                  $message[] = "$name is too large!.";
                  echo '
                    <script>
                    alert("'.$name.' is too large");
                    </script>
                  ';
                  header('Location: homePage.php');
                  exit;
                  //continue; // Skip large files
              }
          elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
          
            $message[] = "$name is not a valid format";
            echo '
              <script>
              alert("'.$name.' is not a valid format");
              </script>
            ';
            header('Location: homePage.php');
            exit;
            //continue; // Skip invalid file formats
          }
              else{ // No error found! Move uploaded files

                $sub_event_id = NULL;
                  if(move_uploaded_file($_FILES["sub_event_gallery_images"]["tmp_name"][$f], $path.$name)){
                    $sql_query = "select `sub_event_id` from $society_sub_event_table_name where `main_event_id` = '$main_event_id' ORDER BY sub_event_id desc LIMIT 1";

                    if($sql_query_run = mysqli_query($conn,$sql_query)){
                      $query_num_rows = mysqli_num_rows($sql_query_run);
                      if ($query_num_rows == 1) {
                      while ($row = mysqli_fetch_assoc($sql_query_run)) {
                        $sub_event_id = $row['sub_event_id'];
                      }
                    }else{
                        echo '
                          <script>
                          alert("There was an error in uploading sub-event gallery images");
                          </script>
                        ';
                      }
                    }else{
                      echo '
                        <script>
                        alert("Sub-event gallery images could not be inserted!");
                        </script>
                      ';
                    }


                    $sql = "INSERT INTO `$event_gallery` (`main_event_id`, `sub_event_id`, `sub_event_image`) VALUES ('$main_event_id', '$sub_event_id', '$name')";
                    if(!mysqli_query($conn, $sql)){
                      echo '
                        <script>
                        alert("Check your sub_event gallery insertion query");
                        </script>
                      ';
                    }
                      $count++; // Number of successfully uploaded file
                      

                  }
              }
          }
      }
    header('Location: homePage.php');
    exit;
  }

    //$result = mysqli_query($conn, "SELECT `images` FROM $event_gallery, $society_table_name where $event_gallery.`event_id` = '$society_table_name.`event_id`'"  );
  //header('Location: homePage.php');

  }

}
?>


<html>
<head>
<title>The Society Fair</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<link rel="stylesheet" type="text/css" href="css/homePageStyles.css">
<link rel="stylesheet" type="text/css" href="css/homePageStylesAfterLogin_1.css">
<link rel="stylesheet" type="text/css" href="css/homePageStylesAfterLogin_2.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!--LIGHTBOX-->
<link rel="stylesheet" type="text/css" href="lightbox2-master/dist/css/lightbox.css">
<script src="lightbox2-master/dist/js/lightbox-plus-jquery.js"></script>

</head>
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
      echo '<a onclick="document.getElementById(`id01`).style.display=`block`" class="w3-bar-item w3-button w3-hover-white">Society Coordinator Login</a>';

    }else{
      echo '<a onclick="document.getElementById(`ADD_EVENT`).style.display=`block`" class="w3-bar-item w3-button w3-hover-white">Add new event</a>';
      echo '<a onclick="document.getElementById(`ADD_SUB_EVENT`).style.display=`block`" class="w3-bar-item w3-button w3-hover-white">Add new sub - event</a>';


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
          <input type="text" placeholder="Enter Username" name="username" minlength="4" maxlength="50" required>

          <label><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password" minlength="6" required>
            
          <button type="submit">Login</button>
      
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </div>
    </form>
  </div>
</div>

<!-- Add Event Form-->
<div id="newEventForm">
  <div id="ADD_EVENT" class="modal">
    <form class = "modal-content animate" action = "<?php echo $current_file; ?>" method = "POST" enctype="multipart/form-data">
      <div class="imgcontainer">
        <span onclick="document.getElementById('ADD_EVENT').style.display='none'" class="close" title="Close Modal">&times;</span>
      </div>

      <div class="container-fluid">
        <input type="hidden" name="newEventForm" value="true">
          <label><b>Event Name</b></label>
          <input type="text" placeholder="Enter Event Name" name="event_name" maxlength="100" required>

          <label><b>Date</b></label>
          <input type="text" placeholder="Enter Event Date" name="event_date" maxlength="30" >

          <label><b>Time</b></label>
          <input type="text" placeholder="Enter Event Time" name="event_time" maxlength="30" >

          <label><b>Year of Event</b></label>
          <input type="text" placeholder="Enter Year of Event (2016,2017..)" name="event_year" maxlength="10" required>

          <label><b>Venue</b></label>
          <input type="text" placeholder="Enter Event Venue" name="event_venue" maxlength="30" >

          <label><b>No. of students</b></label>
          <input type="text" placeholder="Enter the no. of students who attended the event" name="no_of_students" >

          <label><b>Speaker</b></label>
          <input type="text" placeholder="Enter Speaker Name" name="event_speaker" >
          
          <label><b>Brief Bio:</b></label>
          <textarea id="bio_text" cols="59.9%" rows="8" name="event_bio" placeholder="Enter a brief bio about the event" ></textarea><br><br>

          <label><b>Event Report:</b></label>
          <textarea id="report_text" cols="59.9%" rows="8" name="event_report" placeholder="Enter a brief report of the event" ></textarea><br><br>

          <label><b>Event poster &nbsp</b></label>
          <input type="file" name="poster_image"><br><br>

          <label><b>Event images</b></label>
          <input type="file" name="gallery_images[]" multiple="multiple" accept="image/*"/><br><br>

          <button type="submit" name = "submit_newEventForm">Add Event</button>
      
          <button type="button" onclick="document.getElementById('ADD_EVENT').style.display='none'" class="cancelbtn">Cancel</button>
        </div>
    </form>
  </div>
</div>

<!-- Add sub-event Form-->
<div id="newSubEventForm">
  <div id="ADD_SUB_EVENT" class="modal">
    <form class = "modal-content animate" action = "<?php echo $current_file; ?>" method = "POST" enctype="multipart/form-data">
      <div class="imgcontainer">
        <span onclick="document.getElementById('ADD_SUB_EVENT').style.display='none'" class="close" title="Close Modal">&times;</span>
      </div>

      <div class="container-fluid">
        <input type="hidden" name="newSubEventForm" value="true">
          <label><b>Select main event</b></label>
          <br>
          
            <select name="BIG_event_name">
            <option>Select</option>
            <?php
              $query = "select `event_name` from $society_table_name";
              $query_run = mysqli_query($conn,$query);
              while ($fetched_row = mysqli_fetch_assoc($query_run)) {

                $BIG_event_name = $fetched_row['event_name'];
                
                echo '<option value="'.$BIG_event_name.'">'.$BIG_event_name.'</option>';
              }

            ?>
        </select>
        <br><br>

          <label><b>Sub Event Name</b></label>
          <input type="text" placeholder="Enter Event Name" name="sub_event_name" maxlength="100" required>
          
          <label><b>Date</b></label>
          <input type="text" placeholder="Enter Event Date" name="sub_event_date" maxlength="30" required>

          <label><b>Year of Event</b></label>
          <input type="text" placeholder="Enter Year of Event (2016,2017..)" name="sub_event_year" maxlength="10" required>

          <label><b>Time</b></label>
          <input type="text" placeholder="Enter Event Time" name="sub_event_time" maxlength="30">

          <label><b>Venue</b></label>
          <input type="text" placeholder="Enter Event Venue" name="sub_event_venue" maxlength="30">

          <label><b>No. of students</b></label>
          <input type="text" placeholder="Enter the no. of students who attended the event" name="sub_event_no_of_students">

          <label><b>Speaker</b></label>
          <input type="text" placeholder="Enter Speaker Name" name="sub_event_speaker">
          
          <label><b>Brief Bio:</b></label>
          <textarea id="bio_text" cols="59.9%" rows="8" name="sub_event_bio" placeholder="Enter a brief bio about the event" ></textarea><br><br>

          <label><b>Event Report:</b></label>
          <textarea id="sub_event_report_text" cols="59.9%" rows="8" name="sub_event_report" placeholder="Enter a brief report of the sub-event" ></textarea><br><br>

          <label><b>Event poster &nbsp</b></label>
          <input type="file" name="sub_event_poster_image"><br><br>

          <label><b>Event images</b></label>
          <input type="file" name="sub_event_gallery_images[]" multiple="multiple" accept="image/*"/><br><br>

          <button type="submit"  name = "submit_newSubEventForm">Add sub Event</button>
      
          <button type="button" onclick="document.getElementById('ADD_SUB_EVENT').style.display='none'" class="cancelbtn">Cancel</button>
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
      <p style="text-align: justify; text-align-last: left;"">Some text about our services - what we do and what we offer. We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
      dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
      incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
      </p>
      
  
  <!-- Spiritual Scientist Alliance -->
  <div class="w3-container" id="SSA" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Spiritual Scientist Alliance.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p>The best team in the world.</p>
    <p style="text-align: justify; text-align-last: left;"">We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
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
    <p style="text-align: justify; text-align-last: left;"">We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
    incididunt ut labore et quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </p>
  </div>

  <!-- IEEE -->
  <div class="w3-container" id="IEEE" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>IEEE.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p style="text-align: justify; text-align-last: left;"">
                We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
    </p>
  </div>
  <ul>
        <br><li style="cursor: pointer;" onclick="toggle('2k17')"><h5>Events: 2k17</h5></li><br>
        <ul id="2k17" style="display: none;">
          <?php
          $display_query = "select * from $society_table_name where `event_year` = '2017' ORDER BY `event_id` DESC";
          $display_query_run = mysqli_query($conn,$display_query);
            while ($row = mysqli_fetch_assoc($display_query_run)) {
              if ($row['curr_no_of_sub_events'] != 0) {
                echo '';
              }else{
                echo '<li style="cursor: pointer;" onclick="toggle(`Event_1_2k17`)">'.$row['event_name'].'</li>';
                echo '<div id="Event_1_2k17" style="display: none;">';

                echo '<h4><b>'.$row['event_name'].'</b></h4>';
                
                ?>
                <p style="white-space: pre-wrap;
                text-align: justify;
                text-align-last: left;">
                <b>IEEE Student Chapter, Thapar University</b>
<b>IEEE Event :           </b> <?php echo $row['event_name'];?>
<?php
                  if($row['event_year'] != NULL) {echo '<br><b>Date :                     </b>';        echo $row['event_year'];}          
                  if($row['event_venue'] != NULL){echo '<br><b>Venue :                  </b>';        echo $row['event_venue'];}
                  if($row['event_time'] != NULL){echo '<br><b>Time :                     </b>';       echo $row['event_time'];}
                  if($row['no_of_students'] != NULL){echo '<br><b>No. of students : </b>';        echo $row['no_of_students'];}
                  echo '<br><b>Facebook Link :   </b>';    echo '<a href="https://www.facebook.com/ieee.thapar/" style="color: blue;">facebook/ieee</a>';
                  if($row['event_speaker'] != NULL){echo '<br><b>Speaker :               </b>';        echo $row['event_speaker'].'<br>';}
                  if($row['brief_bio'] != NULL){echo '<br><b>Brief Bio : </b>';        echo $row['brief_bio'];}
                  if($row['event_poster'] != NULL) {echo '<br><b><br>Poster Circulated : <br></b><br>';        echo '<img style="width: 50%;" src="IEEE/uploads/posters/main_events/'.$row['event_poster'].'"><br>';}
                  if($row['event_report'] != NULL) {echo '<br><br><b>Report : </b>';        echo $row['event_report'];}
                    echo '</p>';

                  echo '
                  <div class="row">
                    <div class="column">';
                    $main_event_id = $row['event_id'];
                    $this_query = "select `main_event_image` from $event_gallery where `main_event_id` = '$main_event_id'";
                    $this_query_run = mysqli_query($conn,$this_query);
                    $count = 1;
                    $this_query_num_rows = mysqli_num_rows($this_query_run);
                    if($this_query_num_rows != 0){
                      while ($row_gallery = mysqli_fetch_assoc($this_query_run)) {
                        $gallery_image = $row_gallery['main_event_image'];
                        if($count == 1){
                        echo '<a href="IEEE/uploads/gallery/main_events/'.$gallery_image.'" rel="lightbox[IEEE-event]" style="text-decoration: none;"> <b><h5>Event Gallery</b></h5> </a>';
                        $count++;
                        }
                        else{
                        echo '<a href="IEEE/uploads/gallery/main_events/'.$gallery_image.'" rel="lightbox[IEEE-event]"></a>';
                        $count++;
                        }
                      
                      }
                    }
                     echo '</div>
                      </div>
                  
                    </div>
                    </ul>
          ';
                    }
              }

  

        ?>
        
        <!--li><a href="#" style="text-decoration: none;"><h5>Events: 2k16</h5></a></li><br>
        <li><a href="#" style="text-decoration: none;"><h5>Events: 2k15</h5></a></li-->
      </ul>
    </div>

  <!-- MSC -->
  <div class="w3-container" id="MSC" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Microsoft Student Chapter.</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <p>The best team in the world.</p>
    <p style="text-align: justify; text-align-last: left;"">We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
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
var modal_1 = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_1) {
        modal_1.style.display = "none";
    }
}

// Get the ADD_EVENT Form modal
var modal_2 = document.getElementById('ADD_EVENT');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal_2) {
      modal_2.style.display = "none";
  }
}
// Modal Image Gallery
//function onClick(element) {
  //document.getElementById("img01").src = element.src;
  //document.getElementById("modal01").style.display = "block";
  //var captionText = document.getElementById("caption");
  //captionText.innerHTML = element.alt;
//}

function toggle(temp) {
    var x = document.getElementById(temp);
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}

function mess(){
  alert("The event has been successfully added!");
  return true;
}

lightbox.option({
      'fitImagesInViewport': true,
      'resizeDuration': 400,
      'wrapAround': true,
      'maxWidth': .7*(screen.width),
      'maxHeight': .7*(screen.height)
    })

</script>
</body>
</html>
