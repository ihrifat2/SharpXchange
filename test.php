<?php 

$baseurl = "http://".$_SERVER['SERVER_NAME'] . "dirname($_SERVER['PHP_SELF'])";
echo $baseurl;

$baseurl2 = "http://".$_SERVER['SERVER_NAME'] . "/sxc/";
echo $baseurl2;
?>