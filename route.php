<?php

// function __autoload($file_name) {
// 	if (file_exists('./assets/css/'.$file_name.'.css')) {
// 		require_once './assets/css/'.$file_name.'.css';
// 	} elseif (file_exists('./assets/js/'.$file_name.'.js')) {
// 		require_once './assets/js/'.$file_name.'.js';
// 	} elseif (file_exists('./assets/js/'.$file_name.'.png')) {
// 		require_once './assets/js/'.$file_name.'.png';
// 	}
// }

$params = explode("/", $_GET["url"]);
$action = $params[0];
// var_dump($params);
// echo $action;
// echo "<br>";
// echo $_GET["url"];
// echo "<br>";
// $path = $_SERVER['REQUEST_URI'];
// echo $path;
// $others = array_slice($params, 1);
switch ($action) {
	case "":
		require_once "index.php";
		break;
	case 'testimonials':
		require_once "testimonials.html";
		break;
	case 'contact':
		require_once "contact.html";
		break;
	case "about":
		require_once "aboutUs.php";
		break;
	case 'policy':
		require_once "policy.php";
		break;
	case 'track':
		require_once "track.php";
		break;
	case 'signup':
		require_once "signup.php";
		break;
	case 'signin':
		require_once "signin.php";
		break;
	case 'tstimnl.php':
		require_once "tstimnl.php";
		break;
	case 'account':
		require_once "account.php";
		break;
	case 'exchange':
		require_once "exchange.php";
		break;
	case 'testimonial':
		require_once "testimonial.php";
		break;
	case 'logout':
		require_once "logout.php";
		break;
	case 'testimonial':
		require_once "testimonial.php";
		break;
	case 'active':
		require_once "active.php";
		break;
	case 'confirmEmail':
		require_once "confirmEmail.php";
		break;
	case 'changePassword':
		require_once "changePassword.php";
		break;
	case "error":
		require_once "error.html";
		break;
	case "block":
		include "block.php";
		break;
	default:
		// header("Location: error");
		header("HTTP/1.1 404 Not Found");
		echo "404 Not Found";
		// if (isset($others[0]) && isset($others[1])) {
		// 	include "$action/$others[0]/$others[1]";
		// } else {
		// 	echo "404 Not Found";
		// }
		break;
}


?>