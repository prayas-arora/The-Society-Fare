<?php
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
$mysql_db = 'the society fare';

$conn = @mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
if (mysqli_connect_errno())
  {
  echo '
  		<script>
  			alert("Failed to connect to database: ");
  		</script>
  ';
  die();
  }


?>