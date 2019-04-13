<?php
session_start();
if (isset($_SESSION['user_login_session'] )) {
	session_destroy();
	header('Location: /');
}else{
	header('Location: /');
}

session_destroy();

?>