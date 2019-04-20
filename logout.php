<?php
session_start();
if (isset($_SESSION['user_login_session'] )) {
	session_destroy();
	setcookie('SharpXchange_Cookie', '', time() - 3600);
    echo '<script>document.cookie = "SharpXchange_Cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";</script>';
	header('Location: /');
}else{
	header('Location: /');
}

session_destroy();

?>