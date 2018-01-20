<?php
require 'connect.inc.php';

function my_session_start($timeout = 20*60) {
    ini_set('session.gc_maxlifetime', $timeout);
    session_start();

    if (isset($_SESSION['timeout_idle']) && $_SESSION['timeout_idle'] < time()) {
        session_destroy();
        session_start();
        session_regenerate_id();
        $_SESSION = array();
        header("Location:homePage.php");
    }

    $_SESSION['timeout_idle'] = time() + $timeout;
}

ob_start();
my_session_start();
$current_file = $_SERVER['SCRIPT_NAME'];

if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
	$http_referer = @$_SERVER['HTTP_REFERER'];	
}

function loggedin()
{
	if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {    
    return true;      
	}
	else{
		return false;
	}
}

function getfield($table_name,$field){
	$query = "select `$field` from `$table_name` where `id` = '".$_SESSION['user_id']."';";
	global $conn;
	if ($query_run = @mysqli_query($conn,$query)) {
		if (($query_num_rows = @mysqli_num_rows($query_run)) > 0) {
			$query_result = @mysqli_fetch_assoc($query_run);
			return $query_result[$field];
		}
	}
}
?>

<?php
	
	function eventScript($conn, $society, $society_CAPS, $society_name, $society_table_name, $society_sub_event_table_name, $society_event_gallery_table_name, $fb_link, $disp_delete="none"){
echo '<div>';
	    global $count_events_of_same_year;

	    echo '<ul>';
	    	$event_query = "select * from `$society_table_name` ORDER BY `event_year` DESC";

		    if($event_query_run = mysqli_query($conn,$event_query)){

		      	if( mysqli_num_rows($event_query_run) > 0) {
		      	$year_prev = NULL;
		        	while ($event_row = mysqli_fetch_assoc($event_query_run)) {

			          	$year = $event_row['event_year'];
			          	if ($year != $year_prev) {
		      				echo '<li style="cursor: pointer;" onclick="toggle(`'.$society_name.'-'.$year.'`)"><h5>Events: '.$year.'</h5></li>';
									$year_prev = $year;
									$new_query = "select * from $society_table_name where `event_year` = '$year'";
									$new_query_run = mysqli_query($conn,$new_query);
									$count_events_of_same_year = mysqli_num_rows($new_query_run);
									echo '<ul id="'.$society_name.'-'.$year.'" style="display: none;">';
			          	}

			          	

			          	if($event_row['curr_no_of_sub_events'] > 0){

                      	$main_event_id = $event_row['event_id'];

                  echo '<li style="cursor: pointer;" onclick="toggle(`Event_'.$main_event_id.'_'.$year.'`)">'.$event_row["event_name"].'';

                    echo '<ul>';
                          $display_sub_event_query = "select * from `$society_sub_event_table_name` where `main_event_id` = '$main_event_id' ORDER BY `sub_event_id` DESC ";
                          $display_sub_event_query_run = mysqli_query($conn,$display_sub_event_query);

                          while ($row_sub_event = mysqli_fetch_assoc($display_sub_event_query_run)) {
                        $sub_event_id = $row_sub_event['sub_event_id'];
                        $sub_event_name = $row_sub_event['sub_event_name'];
                        

                          echo '<li id = "subList'.$main_event_id.'-'.$sub_event_id.'" style="cursor: pointer; width: 100%" onclick="toggle(`Event_sub_event_'.$main_event_id.'-'.$sub_event_id.'_'.$year.'`)">'.$sub_event_name.'<span id = "subSpan'.$main_event_id.'-'.$sub_event_id.'" style="position: relative; margin-left: 40px;"></span><a id = "subA'.$main_event_id.'-'.$sub_event_id.'" href="javascript: delete_sub_event('.$main_event_id.','.$sub_event_id.')" class="close" style = "color: red; text-decoration:none; display: inline-block; width: 3px; height: 3px;" title="Delete main event and corresponding sub-events">&times;</a></li>';

                          echo '<div id="Event_sub_event_'.$main_event_id.'-'.$sub_event_id.'_'.$year.'" style="display: none;">';

                          echo '<h4><b>'.$sub_event_name.'</b></h4>';
                  
                  
                  ?>
                  
                  <p style="white-space: pre-wrap;
                  text-align: justify;
                  text-align-last: left;">
                  <b><?php echo $society_name ?></b>
<b><?php echo $society_CAPS?> Event :           </b> <?php echo $row_sub_event['sub_event_name'];?>
  <?php
                    if($row_sub_event['sub_event_date'] != NULL) {echo '<br><b>Date :                     </b>';        echo $row_sub_event['sub_event_date'];}          
                    if($row_sub_event['sub_event_venue'] != NULL){echo '<br><b>Venue :                  </b>';        echo $row_sub_event['sub_event_venue'];}
                    if($row_sub_event['sub_event_time'] != NULL){echo '<br><b>Time :                     </b>';       echo $row_sub_event['sub_event_time'];}
                    if($row_sub_event['sub_event_no_of_students'] != NULL){echo '<br><b>No. of students : </b>';        echo $row_sub_event['sub_event_no_of_students'];}
                    echo '<br><b>Facebook Link :   </b>';    echo '<a target="_blank" href='.$fb_link.' style="color: blue;">facebook/'.$society.'</a>';
                    if($row_sub_event['sub_event_speaker'] != NULL){echo '<br><b>Speaker :               </b>';        echo $row_sub_event['sub_event_speaker'].'<br>';}
                    if($row_sub_event['sub_event_brief_bio'] != NULL){echo '<br><b>Brief Bio : </b>';        echo $row_sub_event['sub_event_brief_bio'];}
                    if($row_sub_event['sub_event_poster'] != NULL) {echo '<br><b><br>Poster Circulated : <br></b><br>';        echo '<img style="width: 50%;" src="SOCIETIES DATA/'.$society_CAPS.'/uploads/posters/sub_events/'.$row_sub_event['sub_event_poster'].'"><br>';}
                    if($row_sub_event['sub_event_report'] != NULL) {echo '<br><br><b>Report : </b>';        echo $row_sub_event['sub_event_report'];}


                    echo '
                      <div class="row">
                        <div class="column">';
                        $this_sub_event_query = "select `sub_event_attendance_image` from `$society_event_gallery_table_name` where `main_event_id` = '$main_event_id' and `sub_event_id` = '$sub_event_id' and `sub_event_attendance_image` IS NOT NULL";
                        $this_sub_event_query_run = mysqli_query($conn,$this_sub_event_query);
                        $count_sub_event_attendance = 1;
                        $this_sub_event_query_num_rows = mysqli_num_rows($this_sub_event_query_run);

                        if($this_sub_event_query_num_rows != 0){
                          
                          while ($row_sub_event_attendance = mysqli_fetch_assoc($this_sub_event_query_run)) {
                            $sub_event_attendance_image = $row_sub_event_attendance['sub_event_attendance_image'];
                            if($count_sub_event_attendance == 1){
                            echo '<br><a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/attendance/sub_events/'.$sub_event_attendance_image.'" rel="lightbox['.$society_CAPS.'-event-attendance-'.$main_event_id.'-'.$sub_event_id.']" style="text-decoration: none; border: solid; padding: 4px;"> <b>Sub Event Attendance</b></a><br><br>';
                            $count_sub_event_attendance++;
                            }
                            else{
                            echo '<a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/attendance/sub_events/'.$sub_event_attendance_image.'" rel="lightbox['.$society_CAPS.'-event-attendance-'.$main_event_id.'-'.$sub_event_id.']"></a>';
                            $count_sub_event_attendance++;
                            }
                          
                          }
                        }
                    echo '</div>
                        </div>';


                    echo '
                    <div class="row">
                      <div class="column">';
                      $this_sub_event_query = "select `sub_event_image` from `$society_event_gallery_table_name` where `main_event_id` = '$main_event_id' and `sub_event_id` = '$sub_event_id' and `sub_event_image` IS NOT NULL";
                      $this_sub_event_query_run = mysqli_query($conn,$this_sub_event_query);
                      $count_sub_event = 1;
                      $this_sub_event_query_num_rows = mysqli_num_rows($this_sub_event_query_run);

                      if($this_sub_event_query_num_rows != 0){
                        
                        while ($row_sub_event_gallery = mysqli_fetch_assoc($this_sub_event_query_run)) {
                          $sub_event_gallery_image = $row_sub_event_gallery['sub_event_image'];
                          if($count_sub_event == 1){
                          echo '<br><a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/gallery/sub_events/'.$sub_event_gallery_image.'" rel="lightbox['.$society_CAPS.'-event-'.$main_event_id.'-'.$sub_event_id.']" style="text-decoration: none; border: solid; padding: 4px;"> <b>Sub Event Gallery</b></a><br><br>';
                          $count_sub_event++;
                          }
                          else{
                          echo '<a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/gallery/sub_events/'.$sub_event_gallery_image.'" rel="lightbox['.$society_CAPS.'-event-'.$main_event_id.'-'.$sub_event_id.']"></a>';
                          $count_sub_event++;
                          }
                        
                        }
                      }
                    echo '</div>
                        </div>
                      </div>';
                        if (!loggedin()) {
                          echo '
                        <script>
                        document.getElementById("subSpan'.$main_event_id.'-'.$sub_event_id.'").style.display = "none";
                        document.getElementById("subA'.$main_event_id.'-'.$sub_event_id.'").style.display = "none";
                        </script>
                        ';
                        }else{
                          echo '
                        <script>
                        document.getElementById("subSpan'.$main_event_id.'-'.$sub_event_id.'").style.display = "'.$disp_delete.'";
                        document.getElementById("subA'.$main_event_id.'-'.$sub_event_id.'").style.display = "'.$disp_delete.'";
                        document.getElementById("subList'.$main_event_id.'-'.$sub_event_id.'").style.display = "list-item";
                        </script>
                        ';
                        }
                      }
                    echo '</ul>';
                    
                      echo '</li>';

                      }


			          	else{
			          		
			          		    $main_event_id = $event_row['event_id'];
                  			$main_event_name = $event_row['event_name'];

                  			echo '<li id = "subList'.$main_event_id.'" style="cursor: pointer; width: 100%" onclick="toggle(`Event_'.$main_event_id.'_'.$year.'`)">'.$main_event_name.'<span id = "subSpan'.$main_event_id.'_'.$year.'" style="position: relative; margin-left: 40px;"></span><a id = "subA'.$main_event_id.'_'.$year.'" href="javascript: delete_main_event('.$main_event_id.')" class="close" style = "color: red; text-decoration:none; display: inline-block; width: 3px; height: 3px;" title="Delete main event and corresponding sub-events">&times;</a></li>';

                  			echo '<div id="Event_'.$main_event_id.'_'.$year.'" style="display: none;">';

                  			echo '<h4><b>'.$main_event_name.'</b></h4>';
                  
                  ?>

                  <p style="white-space: pre-wrap;
                  text-align: justify;
                  text-align-last: left;">
                  <b><?php echo $society_name; ?></b>
<b><?php echo $society_CAPS;?> Event :           </b> <?php echo $event_row['event_name'];?>
  <?php
                    if($event_row['event_date'] != NULL) {echo '<br><b>Date :                     </b>';        echo $event_row['event_date'];}          
                    if($event_row['event_venue'] != NULL){echo '<br><b>Venue :                  </b>';        echo $event_row['event_venue'];}
                    if($event_row['event_time'] != NULL){echo '<br><b>Time :                     </b>';       echo $event_row['event_time'];}
                    if($event_row['no_of_students'] != NULL){echo '<br><b>No. of students : </b>';        echo $event_row['no_of_students'];}
                    echo '<br><b>Facebook Link :   </b>';    echo '<a target="_blank" href='.$fb_link.' style="color: blue;">facebook/'.$society.'</a>';
                    if($event_row['event_speaker'] != NULL){echo '<br><b>Speaker :               </b>';        echo $event_row['event_speaker'].'<br>';}
                    if($event_row['brief_bio'] != NULL){echo '<br><b>Brief Bio : </b>';        echo $event_row['brief_bio'];}
                    if($event_row['event_poster'] != NULL) {echo '<br><b><br>Poster Circulated : <br></b><br>';        echo '<img style="width: 50%;" src="SOCIETIES DATA/'.$society_CAPS.'/uploads/posters/main_events/'.$event_row['event_poster'].'"><br>';}
                    if($event_row['event_report'] != NULL) {echo '<br><br><b>Report : </b>';        echo $event_row['event_report'];}
                    
                      echo '</p>';

                    echo '
                      <div class="row">
                        <div class="column">';
                        $this_query = "select `main_event_attendance_image` from `$society_event_gallery_table_name` where `main_event_id` = '$main_event_id' and `main_event_attendance_image` IS NOT NULL";
                        $this_query_run = mysqli_query($conn,$this_query);
                        $count_attendance = 1;
                        $this_query_num_rows = mysqli_num_rows($this_query_run);
                        if($this_query_num_rows != 0){
                          while ($row_attendance = mysqli_fetch_assoc($this_query_run)) {
                            $attendance_image = $row_attendance['main_event_attendance_image'];
                            if($count_attendance == 1){
                            echo '<br><a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/attendance/main_events/'.$attendance_image.'" rel="lightbox['.$society_CAPS.'-event-attendance-'.$main_event_id.']" style="text-decoration: none; border: solid; padding: 4px;"><b>Event Attendance</b></a><br><br>';
                            $count_attendance++;
                            }
                            else{
                            echo '<a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/attendance/main_events/'.$attendance_image.'" rel="lightbox['.$society_CAPS.'-event-attendance-'.$main_event_id.']"></a>';
                            $count_attendance++;
                            }
                          
                          }
                        }
                    echo '</div>
                        </div>';

                    echo '
                    <div class="row">
                      <div class="column">';
                      $this_query = "select `main_event_image` from `$society_event_gallery_table_name` where `main_event_id` = '$main_event_id' and `main_event_image` IS NOT NULL";
                      $this_query_run = mysqli_query($conn,$this_query);
                      $count = 1;
                      $this_query_num_rows = mysqli_num_rows($this_query_run);
                      if($this_query_num_rows != 0){
                        while ($row_gallery = mysqli_fetch_assoc($this_query_run)) {
                          $gallery_image = $row_gallery['main_event_image'];
                          if($count == 1){
                          echo '<br><a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/gallery/main_events/'.$gallery_image.'" rel="lightbox['.$society_CAPS.'-event-'.$main_event_id.']" style="text-decoration: none; border: solid; padding: 4px;"><b>Event Gallery</b></a><br><br>';
                          $count++;
                          }
                          else{
                          echo '<a href="SOCIETIES DATA/'.$society_CAPS.'/uploads/gallery/main_events/'.$gallery_image.'" rel="lightbox['.$society_CAPS.'-event-'.$main_event_id.']"></a>';
                          $count++;
                          }
                        
                        }
                      }
                    echo '</div>
                        </div>
                      </div>';
                      
                      $count = 0;
                      }
                      
                      
								if (!loggedin()) {
						                          echo '
						                        <script>
  						                        document.getElementById("subSpan'.$main_event_id.'_'.$year.'").style.display = "none";
  						                        document.getElementById("subA'.$main_event_id.'_'.$year.'").style.display = "none";
						                        </script>
						                        ';
						                        }
						                        else{
						                          echo '
  					                        <script>
                                      document.getElementById("subSpan'.$main_event_id.'_'.$year.'").style.display = "'.$disp_delete.'";
                                      document.getElementById("subA'.$main_event_id.'_'.$year.'").style.display = "'.$disp_delete.'";
  					                          document.getElementById("subList'.$main_event_id.'_'.$year.'").style.display = "list-item";
						                        </script>
						                        ';
						                        }

								$count_events_of_same_year--;
						if($count_events_of_same_year==0){echo '</ul>';}

		    		}

				}
			}


	    echo '</ul>';

echo '</div>';
	}

?>
