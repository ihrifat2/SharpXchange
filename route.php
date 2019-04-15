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
		include "index.php";
		break;
	case 'testimonials':
		include "testimonials.html";
		break;
	case 'contact':
		include "contact.html";
		break;
	case "about":
		include "aboutUs.php";
		break;
	case 'policy':
		include "policy.php";
		break;
	case 'track':
		include "track.php";
		break;
	case 'signup':
		include "signup.php";
		break;
	case 'signin':
		require_once "signin.php";
		break;
	case 'tstimnl.php':
		include "tstimnl.php";
		break;
	case 'account':
		include "account.php";
		break;
	case 'exchange':
		include "exchange.php";
		break;
	case 'testimonial':
		include "testimonial.php";
		break;
	case 'logout':
		include "logout.php";
		break;
	case 'testimonial':
		include "testimonial.php";
		break;
	case "error":
		echo "404 Not Found";
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