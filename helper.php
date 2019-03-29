<?php

function exchangeSendUs($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `we_buy` FROM `tbl_gateway_info` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $we_buy			= $rows['we_buy'];
    return $we_buy;
}

function exchangeReceive($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `we_sell` FROM `tbl_gateway_info` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $we_sell		= $rows['we_sell'];
    return $we_sell;
}

function ReceiveReserve($data){
	require "dbconnect.php";
	$data = checkInputExchanger($data);
	$data = matchExchangerNameWithDatabase($data);
	$sqlQuery       = "SELECT `amount` FROM `tbl_reserve_list` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $reserveAmount	= $rows['amount'];
    return $reserveAmount;
}

function ReceiveReserveDefault($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `amount` FROM `tbl_reserve_list` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $reserveAmount	= $rows['amount'];
    return $reserveAmount;
}

function getGatewayAddress($data){
	require "dbconnect.php";
	$sqlQuery       = "SELECT `gateway_address` FROM `tbl_gateway_info` WHERE `gateway_name` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $gatway_address	= $rows['gateway_address'];
    return $gatway_address;
}

function getActiveStatus(){
    require "dbconnect.php";
    $sqlQuery   = "SELECT `activeStatus` FROM `tbl_additional_info`";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    $rows       = mysqli_fetch_array($result);
    $data       = $rows['activeStatus'];
    return $data;
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
	        return "Mass with the best die like the rest";
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
	        return "Mass with the best die like the rest";
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

function exchangeStatus($value){
	switch ($value) {
	    case 1:
	        return "Processing";
	        break;
	    case 2:
	        return "Awaiting Payment";
	        break;
	    case 3:
	        return "Processed";
	        break;
	    case 4:
	        return "Timeout";
	        break;
	    case 5:
	        return "Canceled";
	        break;
	    default:
	        return "Mass with the best die like the rest";
	}
}

function getDateFormat($data){
	$date = $data;
	$date = explode(",",$date);
	$date = $date[0] . $date[1];
	$date = explode(" ",$date);
	$month 	= getMonth($date[0]);
	$day	= $date[1];
	$year	= $date[2];
	$date = $day . "-" . $month . "-" . $year;
	return $date;
}

function getMonth($value){
	$value = ucfirst($value);
	switch ($value) {
	    case "January":
	        return "01";
	        break;
	    case "February":
	        return "02";
	        break;
	    case "March":
	        return "03";
	        break;
	    case "April":
	        return "04";
	        break;
	    case "May":
	        return "05";
	        break;
	    case "June":
	        return "06";
	        break;
	    case "July":
	        return "07";
	        break;
	    case "August":
	        return "08";
	        break;
	    case "September":
	        return "09";
	        break;
	    case "October":
	        return "10";
	        break;
	    case "November":
	        return "11";
	        break;
	    case "December":
	        return "12";
	        break;
	    default:
	        return "Mass with the best die like the rest";
	}
}

function bdtOrUsbByGTName($data){
    $currency;
    switch ($data) {
        case "Bkash Personal":
            $currency = " BDT";
            return $currency;
            break;
        case "DBBL Rocket":
            $currency = " BDT";
            return $currency;
            return ;
            break;
        case "Coinbase":
            $currency = " USD";
            return $currency;
            break;
        case "Ethereum":
            $currency = " USD";
            return $currency;
            break;
        case "Neteller":
            $currency = " USD";
            return $currency;
            break;
        case "Payza":
            $currency = " USD";
            return $currency;
            break;
        case "Skrill":
            $currency = " USD";
            return $currency;
            break;
        default:
            return "Mass with the best die like the rest";
    }
}

function getbadgefromStatus($data) {
	switch ($data) {
	    case 1:
	        return '<span class="badge badge-info"><i class="fa fa-clock-o"></i> Processing</span>';
	        break;
	    case 2:
	        return '<span class="badge badge-warning"><i class="fa fa-clock-o"></i> Awaiting Payment</span>';
	        break;
	    case 3:
	        return '<span class="badge badge-success"><i class="fa fa-check"></i> Processed</span>';
	        break;
	    case 4:
	        return '<span class="badge badge-danger"><i class="fa fa-times"></i> Timeout</span>';
	        break;
	    case 5:
	        return '<span class="badge badge-danger"><i class="fa fa-times"></i> Canceled</span>';
	        break;
	    default:
	        return "Mass with the best die like the rest";
	}
}

function datanameToPic($data){
	switch ($data) {
	    case "Bkash Personal":
	        return "bkash.png";
	        break;
	    case "DBBL Rocket":
	        return "dutchbangla.png";
	        break;
	    case "Coinbase":
	        return "coinbase.png";
	        break;
	    case "Ethereum":
	        return "ethereum.png";
	        break;
	    case "Neteller":
	        return "neteller.png";
	        break;
	    case "Payza":
	        return "payza.png";
	        break;
	    case "Skrill":
	        return "skrill.png";
	        break;
	    default:
	        return "Mass with the best die like the rest";
	}
}

?>