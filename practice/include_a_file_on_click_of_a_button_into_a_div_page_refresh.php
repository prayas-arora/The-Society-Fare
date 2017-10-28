<?php
echo md5('pass123');
?>

<?php
	if (isset($_GET['show'])) {
		include $_GET['show'];
	}
?>


<input type="submit" name="include_a_file" onclick="window.location = 'test.php?show=test.php'">

