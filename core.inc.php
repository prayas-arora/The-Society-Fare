<?php
require 'connect.inc.php';
ob_start();
session_start();
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
