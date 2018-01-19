<?php
require 'core.inc.php';
session_destroy();
header('Location: homePage.php');
//header('Location: '.$http_referer);
?>