<?php

session_start();
require "helper.php";
// require "auth.php";
$redirect = 0;
if(!isset($_SESSION["user_login_session"])){
	// header("Location: http://sharpxchange.com/signin.php", true, 301);
	// die();
	// exit();
	// echo "<script>javascript:document.location='signin.php'</script>";
	$redirect 		= 1;
	$redirectUrl 	= "signin.php";
	
}

if (isset($_POST['sxcSendUs']) && isset($_POST['sxcReceive']) && isset($_POST['sxcAmountSend'])) {
	$exChgeSendGateway = $_POST['sxcSendUs'];
	$exChgeRecvGateway = $_POST['sxcReceive'];
	$sxcAmountSend = $_POST['sxcAmountSend'];
	if ($exChgeSendGateway >= 3 && $exChgeSendGateway <= 7) {
		$payoutAmount = $sxcAmountSend . " USD";
		if ($sxcAmountSend < 10) {
			$limit = "The minimum amount for exchange is 10 USD.";
			$btnhide = 1;
		} else {
			$limit = "";
			$btnhide = 0;
		}
	} else {
		$payoutAmount = $sxcAmountSend . " BDT";
		if ($sxcAmountSend < 1000) {
			$limit = "The minimum amount for exchange is 1000 BDT.";
			$btnhide = 1;
		} else {
			$limit = "";
			$btnhide = 0;
		}
	}
	$exChgeSendGT = checkInputExchanger($exChgeSendGateway);
	$exChgeSendGT = matchExchangerNameWithDatabase($exChgeSendGT);

	$exChgeRecvGT = checkInputExchanger($exChgeRecvGateway);
	$exChgeRecvGT = matchExchangerNameWithDatabase($exChgeRecvGT);
	
	$excGatwyAddress = getGatewayAddress($exChgeSendGT);
	if ($exChgeSendGateway >= 3 && $exChgeSendGateway <= 7) {
		$exChgeSendGT = $exChgeSendGT . " Address";
	} else {
		$exChgeSendGT = $exChgeSendGT . " Number";
	}
	if ($exChgeRecvGateway >= 3 && $exChgeRecvGateway <= 7) {
		$exChgeRecvGT = $exChgeRecvGT . " Address";
	} else {
		$exChgeRecvGT = $exChgeRecvGT . " Number";
	}
	if ($redirect == 1) {
		$dataLimit = array($limit, $btnhide, $exChgeRecvGT, $exChgeSendGT, $excGatwyAddress, $payoutAmount, $redirect, $redirectUrl);
	} else {
		$dataLimit = array($limit, $btnhide, $exChgeRecvGT, $exChgeSendGT, $excGatwyAddress, $payoutAmount, $redirect);
	}
	echo json_encode($dataLimit);
	// echo $limit . " : " . $btnhide . " : " . $exChgeRecvGT . " : " . $exChgeSendGT . " : " . $excGatwyAddress . " : " . $payoutAmount;
	// echo $exChgeSendGateway . " : " . $exChgeRecvGateway . " : " . $exChgeSendGT . " : " . $exChgeRecvGT;
}

?>