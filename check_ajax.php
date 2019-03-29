<?php

session_start();
require "helper.php";
// unset($_SESSION['sxcReceive']);
// unset($_SESSION['sxcSendUs']);

if (isset($_SESSION['sxcSendUs']) == NULL || empty($_SESSION['sxcSendUs'])) {
	$_SESSION['sxcSendUs'] = 7;
}

if (isset($_SESSION['sxcReceive']) == NULL || empty($_SESSION['sxcReceive'])) {
	$_SESSION['sxcReceive'] = 1;
}

//$_SESSION['sxcSendUs'] 	= "Skrill";


if (!empty($_POST["sxcSendUs"])) {
	$sxcSendUsInput 	= $_POST['sxcSendUs'];
	$sxcNumericConfirm 	= checkInputIsNumeric($sxcSendUsInput);
	if ($sxcNumericConfirm) {
		if($sxcSendUsInput >= 0 && $sxcSendUsInput <= 11){
			$sxcSendUsGW			= checkInputExchanger($sxcSendUsInput);
			$sxcSendUsDB			= matchExchangerNameWithDatabase($sxcSendUsGW);
			$_SESSION['sxcSendUs'] 	= $sxcSendUsInput;
			$gtway_nameForSell		= $_SESSION['sxcSendUs'];
			$gtway_nameForReceive	= $_SESSION['sxcReceive'];
			$exchangeRate 			= exchangeRate($gtway_nameForSell, $gtway_nameForReceive);
			$data 			= $exchangeRate;
			$data 			= rtrim($data);
			$data 			= explode(" ",$data);
			$excSendInpt 	= $data[2];
			$excRecvInpt 	= $data[5];
			//echo $gtway_nameForSell . " : " . $gtway_nameForReceive . "\n";
			$inputSell 		= exchangeSendUs($sxcSendUsDB);
			$dataSendUs 	= array($sxcSendUsGW, $exchangeRate, $excSendInpt, $excRecvInpt);
			echo json_encode($dataSendUs);
		}
	}
} 

if (!empty($_POST["sxcReceive"])) {
	$sxcReceiveInput 	= $_POST['sxcReceive'];
	$sxcNumericConfirm 	= checkInputIsNumeric($sxcReceiveInput);
	if ($sxcNumericConfirm) {
		if($sxcReceiveInput >= 0 && $sxcReceiveInput <= 11){
			$sxcReceive 			= checkInputExchanger($sxcReceiveInput);
			$_SESSION['sxcReceive'] = $sxcReceiveInput;
			$gtway_nameForSell		= $_SESSION['sxcSendUs'];
			$gtway_nameForReceive	= $_SESSION['sxcReceive'];
			$exchangeRate 			= exchangeRate($gtway_nameForSell, $gtway_nameForReceive);
			$data 			= $exchangeRate;
			$data 			= rtrim($data);
			$data 			= explode(" ",$data);
			$excSendInpt 	= $data[2];
			$excRecvInpt 	= $data[5];
			$reserveAmount 	= "Reserve: ".ReceiveReserve($gtway_nameForReceive) . bdtOrUsb($sxcReceiveInput);
			$dataReceive 	= array($sxcReceive, $reserveAmount, $exchangeRate, $excSendInpt, $excRecvInpt);
			echo json_encode($dataReceive);
		}
	}
} 

if (isset($_POST['sxcAmountSend']) && !empty($_POST["sellUsStatus"]) && !empty($_POST["reserve"])) {
	$sendAmntInpt = $_POST['sxcAmountSend'];
	if ($sendAmntInpt == null || $sendAmntInpt == "") {
		$sendAmntInpt = 0;
	}
	$exchangeRate 	= trim($_POST['sellUsStatus']);
	$rsevSatus 		= trim($_POST['reserve']);
	$data 			= $exchangeRate;
	$data 			= rtrim($data);
	$data 			= explode(" ",$data);
	$excSendInpt 	= $data[2];
	$excRecvInpt 	= $data[5];
	$excSendGtw		= $_SESSION['sxcSendUs'];
	$excRecvGtw		= $_SESSION['sxcReceive'];
	$excTotal		= exchangePriceRateSell($excSendGtw, $excRecvGtw, $sendAmntInpt, $excSendInpt, $excRecvInpt);
	// echo $sendAmntInpt . " : " . $exchangeRate . " : " . $excRecvInpt . " : " . $excSendGtw . " : " . $excRecvGtw . " : " . $excTotal  . " : " . $rsevSatus . "\n";
	// echo $excTotal;
	
	if ($rsevSatus >= $excTotal) {
		$btnDisable = 0;
		$dataPrice 	= array($excTotal, $btnDisable);
		echo json_encode($dataPrice);
	} else {
		$btnDisable = 1;
		$errortxt	= "The amount of exchange exceed our reserve.";
		$dataPrice 	= array($excTotal, $btnDisable, $errortxt);
		echo json_encode($dataPrice);
	}
}

?>