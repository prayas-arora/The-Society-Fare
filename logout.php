<?php
require 'core.inc.php';
session_destroy();
header('Location: index.php');
//header('Location: '.$http_referer);
?>