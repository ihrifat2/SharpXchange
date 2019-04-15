<?php

session_start();
require "dbconnect.php";
require "helper.php";
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!empty($_POST["username"])) {
	$username 	= validate_input($_POST["username"]);
	$user_count = checkUsername($username);
	if($user_count>0) {
		echo "Username Not Available.";
		echo "<script>document.getElementById('sxcSignupUsername').setAttribute('class', 'form-control is-invalid')</script>";
		echo "<script>document.getElementById('sxcUsernameStatus').setAttribute('class', 'invalid-feedback')</script>";
		// echo "<script>document.getElementById('sxcsignupbtn').setAttribute('disabled', true)</script>";
	} else {
		echo "Username Available.";
		echo "<script>document.getElementById('sxcSignupUsername').setAttribute('class', 'form-control is-valid')</script>";
		echo "<script>document.getElementById('sxcUsernameStatus').setAttribute('class', 'valid-feedback')</script>";
		// echo "<script>document.getElementById('sxcsignupbtn').removeAttribute('disabled')</script>";
	}
} elseif (!empty($_POST["email"])) {
	$email 		= validate_input($_POST["email"]);
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$user_count = checkEmail($email);
		if($user_count>0) {
			echo "Email Not Available.";
			echo "<script>document.getElementById('sxcSignupEmail').setAttribute('class', 'form-control is-invalid')</script>";
			echo "<script>document.getElementById('sxcEmailStatus').setAttribute('class', 'invalid-feedback')</script>";
			// echo "<script>document.getElementById('sxcsignupbtn').setAttribute('disabled', true)</script>";
		} else {
			echo "Email Available.";
			echo "<script>document.getElementById('sxcSignupEmail').setAttribute('class', 'form-control is-valid')</script>";
			echo "<script>document.getElementById('sxcEmailStatus').setAttribute('class', 'valid-feedback')</script>";
			// echo "<script>document.getElementById('sxcsignupbtn').removeAttribute('disabled')</script>";
		}
	} else {
		echo "Invalid Email.";
		echo "<script>document.getElementById('sxcSignupEmail').setAttribute('class', 'form-control is-invalid')</script>";
		echo "<script>document.getElementById('sxcEmailStatus').setAttribute('class', 'invalid-feedback')</script>";
		// echo "<script>document.getElementById('sxcsignupbtn').setAttribute('disabled', true)</script>";
	}
		
} elseif (!empty($_POST["passwd"])) {
	$passwd	= validate_input($_POST["passwd"]);
	if(strlen($passwd) <= 7) {
		echo "Password too short.";
		echo "<script>document.getElementById('sxcSignupPassword').setAttribute('class', 'form-control is-invalid')</script>";
		echo "<script>document.getElementById('sxcPasswdStatus').setAttribute('class', 'invalid-feedback')</script>";
		// echo "<script>document.getElementById('sxcsignupbtn').setAttribute('disabled', true)</script>";
	} else {
		$_SESSION['tempPasswd'] = $passwd;
		echo "<script>document.getElementById('sxcSignupConfirmPassword').setAttribute('class', 'form-group row show')</script>";
		echo "<script>document.getElementById('sxcSignupPassword').setAttribute('class', 'form-control is-valid')</script>";
		echo "<script>document.getElementById('sxcPasswdStatus').setAttribute('class', 'valid-feedback')</script>";
		// echo "<script>document.getElementById('sxcsignupbtn').removeAttribute('disabled')</script>";
	}
} elseif (!empty($_POST["conpasswd"])) {
	$conpasswd = validate_input($_POST["conpasswd"]);
	$mainpaswd = $_SESSION['tempPasswd'];
	if($conpasswd != $mainpaswd || strlen($conpasswd) != strlen($mainpaswd)) {
		echo "Password Not Matched.";
		echo "<script>document.getElementById('sxcSignupConPassword').setAttribute('class', 'form-control is-invalid')</script>";
		echo "<script>document.getElementById('sxcConPasswdStatus').setAttribute('class', 'invalid-feedback')</script>";
		// echo "<script>document.getElementById('sxcsignupbtn').setAttribute('disabled', true)</script>";
	} else {
		echo "<script>document.getElementById('sxcSignupConPassword').setAttribute('class', 'form-control is-valid')</script>";
		echo "<script>document.getElementById('sxcConPasswdStatus').setAttribute('class', 'valid-feedback')</script>";
		echo "<script>document.getElementById('sxcsignupbtn').removeAttribute('disabled')</script>";
	}
} else {
	echo "<span id='error'>Required.</span>";
	// echo "<script>document.getElementById('sxcsignupbtn').setAttribute('disabled', true)</script>";
}
mysqli_close($dbconnect);
?>