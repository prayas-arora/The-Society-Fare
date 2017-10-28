<?php
	if (isset($_GET['search_text'])) {
		$search_text = $_GET['search_text'];
	}


	if (!empty($search_text)) {
		if ($conn = @mysqli_connect('localhost','root','','ajax')) {
		$query = "select `name` from `names` where `name` like '".mysqli_real_escape_string($conn,$search_text)."%'";
		$query_run = mysqli_query($conn,$query);

			while ($query_row = mysqli_fetch_assoc($query_run)) {
				echo $name = $query_row['name'].'<br>';
			}
		}
	else if (mysqli_connect_errno()) {
	  echo "Failed to connect to database: ";
	  }
	  
	}
	

?>