<?php
	$conn = mysqli_connect('localhost','root','','ajax');
	if (isset($_POST['text'])) {
		$text = $_POST['text'];
		if (!empty($text)) {
			$query = "insert into `names` VALUES ('','".mysqli_real_escape_string($conn,$text)."');";
			if($query_run = mysqli_query($conn,$query)){
				echo "Data Inserted!";
			}
			else{
				echo "Data Insertion Failed!";
			}
		}
		else{
			echo 'Please type and submit something';
		}
	}

?>