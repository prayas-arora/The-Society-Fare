<?php
class DatabaseConnect{
	public function __construct($db_host, $db_username, $db_password, $db_name){
		if (!@$this->Connect($db_host, $db_username, $db_password, $db_name)) {
			echo 'Connection Failed!';
		}
		else{
			echo 'Connected to '.$db_host;
		}
	}
	public function Connect($db_host, $db_username, $db_password, $db_name){
		if (!mysqli_connect($db_host, $db_username, $db_password, $db_name)) {
			return false;		}
	}
	else{
		return true;
	}
}
?>