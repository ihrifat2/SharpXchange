<?php

if(!isset($_SESSION["user_login_session"])){
	header("Location: signin");
}

if ($_SESSION["PHPSESSID"] != $_COOKIE['SharpXchange_Cookie']) {
	header("Location: logout");
}

if (isset($_SESSION['PHPSESSID'])) {
	$phpsessionid = $_SESSION['PHPSESSID'];
	$countSessionId = getSessionStatus($phpsessionid);

	if($countSessionId == 0) {
		header("Location: logout");
	}
}

function getSessionStatus($data) {
	require "dbconnect.php";
	$sqlQuery       = "SELECT COUNT(`session_id`) FROM `tbl_user_sessiontoken` WHERE `session_token` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $session_id 	= $rows['COUNT(`session_id`)'];
    return $session_id;
}

?>
