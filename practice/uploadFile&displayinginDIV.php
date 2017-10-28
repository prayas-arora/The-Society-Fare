<?php
	$db = "image_upload_practice";
	$conn = mysqli_connect("localhost", "root", "", $db);
	$msg = "";

	if (isset($_POST['upload'])) {
			$valid_formats = array("jpg", "jpeg", "png", "gif", "zip", "bmp");
			$max_file_size = 1024*1024*10; //10 mb
			$path = "uploads/"; // Upload directory
			$count = 0;

			foreach ($_FILES['images']['name'] as $f => $name) {     
		    if ($_FILES['images']['error'][$f] == 4) {
		        continue; // Skip file if any error found
		    }
		    if ($_FILES['images']['error'][$f] == 0) {	           
		        if ($_FILES['images']['size'][$f] > $max_file_size) {
		            $message[] = "$name is too large!.";
		            continue; // Skip large files
		        }
				elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				
					$message[] = "$name is not a valid format";
					continue; // Skip invalid file formats
				}
		        else{ // No error found! Move uploaded files

		        	$image_text = mysqli_real_escape_string($conn, $_POST['image_text']);

		            if(move_uploaded_file($_FILES["images"]["tmp_name"][$f], $path.$name)){
		            	$sql = "INSERT INTO `images` (`image`, `image_text`) VALUES ('$name', '$image_text')";
						mysqli_query($conn, $sql);
		            	$count++; // Number of successfully uploaded file

		            }
		        }
		    }
		}
	}

	$result = mysqli_query($conn, "SELECT * FROM images");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Image Upload</title>
	<link rel="stylesheet" type="text/css" href="css/uploadFile&displayinginDIV_STYLES.css">
</head>
<body>
<div id="content">
<?php

	while ($row = mysqli_fetch_assoc($result)) {
		echo "<div id='img_div'>";
		echo $row['image'];
			echo "<img src='uploads/".$row['image']."' >";
			echo "<p>".$row['image_text']."</p>";
		echo "</div>";
	}
?>

	<form action="uploadFile&displayinginDIV.php" method="POST"  enctype="multipart/form-data">
		
		<input type="file" id="file" name="images[]" multiple="multiple" accept="image/*"/>
		
		<textarea id="text" cols="40" rows="4" name="image_text" placeholder="Say something about this image..."></textarea>
		
		<input type="submit" name="upload" value="Upload!" />
	</form>
</div>
</body>
</html>