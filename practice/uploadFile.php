<?php
	$name = @$_FILES['file']['name'];
	$size = @$_FILES['file']['size'];
	$type = @$_FILES['file']['type'];
	$extension = strtolower(substr($name, strrpos($name,'.') + 1));

	$max_size = 80*1024;
	$tmp_name = @$_FILES['file']['tmp_name'];

	if (isset($name)) {
		if(!empty($name)){
			if (($extension == 'jpg' || $extension == 'jpeg') && ($type = 'image/jpg') && ($size < $max_size)) {
				$location = 'uploads/';

				if(move_uploaded_file($tmp_name, $location.$name)){
					echo "Uploaded!";
				}
				else{
					echo "There was an error";
				}
			}
			else{
				echo "File must be jpg/jpeg and 80kb or less";
			}
		}
		else{
		echo "Please choose a file";
		}
	}
?>
<form action="uploadFile.php" method="POST" enctype="multipart/form-data">
	<input type = "file" name = "file"><br><br>
	<input type = "submit" value = "Submit">
</form>