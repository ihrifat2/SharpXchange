<?php

function exchangeSendUs($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `we_buy` FROM `gateway_info` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $we_buy			= $rows['we_buy'];
    return $we_buy;
}

function exchangeReceive($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `we_sell` FROM `gateway_info` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $we_sell		= $rows['we_sell'];
    return $we_sell;
}

function ReceiveReserve($data){
	require "dbconnect.php";
	$data = checkInputExchanger($data);
	$data = matchExchangerNameWithDatabase($data);
	$sqlQuery       = "SELECT `amount` FROM `reserve_list` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $reserveAmount	= $rows['amount'];
    return $reserveAmount;
}

function ReceiveReserveDefault($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `amount` FROM `reserve_list` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $reserveAmount	= $rows['amount'];
    return $reserveAmount;
}

function checkInputIsNumeric($data){
	if (is_numeric($data)) {
		return true; 
	} else { 
		return false; 
	}
}

function checkInputExchanger($data){
	switch ($data) {
	    case 1:
	        return "bkash";
	        break;
	    case 2:
	        return "dutchbangla";
	        break;
	    case 3:
	        return "coinbase";
	        break;
	    case 4:
	        return "ethereum";
	        break;
	    case 5:
	        return "neteller";
	        break;
	    case 6:
	        return "payza";
	        break;
	    case 7:
	        return "skrill";
	        break;
	    default:
	        return "Mass with the best die like the rest1";
	}
}

function matchExchangerNameWithDatabase($data){
	switch ($data) {
	    case "bkash":
	        return "Bkash Personal";
	        break;
	    case "dutchbangla":
	        return "DBBL Rocket";
	        break;
	    case "coinbase":
	        return "Coinbase";
	        break;
	    case "ethereum":
	        return "Ethereum";
	        break;
	    case "neteller":
	        return "Neteller";
	        break;
	    case "payza":
	        return "Payza";
	        break;
	    case "skrill":
	        return "Skrill";
	        break;
	    default:
	        return "Mass with the best die like the rest2";
	}
}

function bdtOrUsb($data){
	$currency;
	if ($data >= 3 && $data <= 7) {
		$currency = " USD";
	} else {
		$currency = " BDT";
	}
	return $currency;
}

function exchangeRate($buy, $sell){
	$buyNum 	= $buy;
	$buyGWNum 	= checkInputExchanger($buyNum);
	$buyGtwy 	= matchExchangerNameWithDatabase($buyGWNum);
	$sellNum 	= $sell;
	$sellGWNum 	= checkInputExchanger($sellNum);
	$sellGtwy 	= matchExchangerNameWithDatabase($sellGWNum);
	$changeRate;
	// echo $buyNum . " : " . $buyGWNum . " : " . $buyGtwy . "\n";
	// echo $sellNum . " : " . $sellGWNum . " : " . $sellGtwy . "\n";
	if (($buyNum == 1 || $buyNum == 2) && $sellNum == 1) {
		$changeRate = "Exchange rate: 1 BDT = " . exchangeSendUs($buyGtwy) . " BDT";
	} elseif (($buyNum >= 3 && $buyNum <= 7) && $sellNum == 1) {
		$changeRate = "Exchange rate: 1 USD = " . exchangeSendUs($buyGtwy) . " BDT";
	} elseif (($buyNum == 1 || $buyNum == 2) && $sellNum == 2) {
		$changeRate = "Exchange rate: 1 BDT = " . exchangeSendUs($buyGtwy) . " BDT";
	} elseif (($buyNum >= 3 && $buyNum <= 7) && $sellNum == 2) {
		$changeRate = "Exchange rate: 1 USD = " . exchangeSendUs($buyGtwy) . " BDT";
	} elseif ($buyNum == 1 && ($sellNum == 1 || $sellNum == 2)) {
		$changeRate = "Exchange rate: 1 BDT = " . exchangeReceive($buyGtwy) . " BDT";
	} elseif ($buyNum == 1 && ($sellNum >= 3 && $sellNum <= 7) ) {
		$changeRate = "Exchange rate: " . exchangeReceive($sellGtwy) . " BDT = 1 USD";
	} elseif ($buyNum == 2 && ($sellNum == 1 || $sellNum == 2)) {
		$changeRate = "Exchange rate: 1 BDT = " . exchangeReceive($buyGtwy) . " BDT";
	} elseif ($buyNum == 2 && ($sellNum >= 3 && $sellNum <= 7) ) {
		$changeRate = "Exchange rate: " . exchangeReceive($sellGtwy) . " BDT = 1 USD";
	} elseif (($buyNum >= 3 && $buyNum <= 7) && ($sellNum >= 3 && $sellNum <= 7)) {
		$changeRate = "Exchange rate: 1 USD = 1 USD";
	} else {
		//$changeRate = "Exchange rate: 1 USD = 1 USD";
		$changeRate = "Somethings wrong ";
	}
	return $changeRate;
}

function exchangePriceRateSell($buyGw, $sellGw, $buyAmount, $buyRate, $sellRate){
	$total;
	if (($buyGw >= 3 && $buyGw <= 7) && ($sellGw == 1 || $sellGw == 2)) {
		$total = $buyAmount * $sellRate;
	} elseif (($buyGw == 1 || $buyGw == 2) && ($sellGw >= 1 && $sellGw <= 2)) {
		$total = $buyAmount / $sellRate;
	} elseif (($buyGw == 1 || $buyGw == 2) && ($sellGw >= 3 && $sellGw <= 7)) {
		$total = $buyAmount / $buyRate;
		$total = number_format((float)$total, 2, '.', '');
	} elseif (($buyGw >= 3 || $buyGw <= 7) && ($sellGw >= 3 && $sellGw <= 7)) {
		$total = $buyAmount / $sellRate;
	} else {
		$total = "ok";
	}
	return $total;
}

?>