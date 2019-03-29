<?php

function getfirstname($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `first_name` FROM `tbl_user_info` WHERE `username` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $first_name		= $rows['first_name'];
    return $first_name;
}

function getlastname($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `last_name` FROM `tbl_user_info` WHERE `username` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $last_name		= $rows['last_name'];
    return $last_name;
}

function getphonenumber($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `phone` FROM `tbl_user_info` WHERE `username` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $phone			= $rows['phone'];
    return $phone;
}

function getgender($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `gender` FROM `tbl_user_info` WHERE `username` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $gender			= $rows['gender'];
    return $gender;
}

function getemailaddress($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `email` FROM `tbl_user_info` WHERE `username` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $email			= $rows['email'];
    return $email;
}

function matchPassword($data, $passwd){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `passwd` FROM `tbl_user_info` WHERE `username` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $store_passwd	= $rows['passwd'];
    $check          = password_verify($passwd, $store_passwd);
    return $check;
}

function getStatus($data){
    require "dbconnect.php";
    $sqlQuery       = "SELECT COUNT(`status`) FROM `tbl_exchange_info` WHERE `username` = '$data' AND `status` = 1";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $status         = $rows['COUNT(`status`)'];
    return $status;
}

function getTotalExchangeByUname($data){
    require "dbconnect.php";
    $sqlQuery       = "SELECT COUNT(`status`) FROM `tbl_exchange_info` WHERE `username` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $status         = $rows['COUNT(`status`)'];
    return $status;
}

?>