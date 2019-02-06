<?php

if (!empty($_POST["sxcSendUs"])) {
	$sxcSendUsInput = $_POST['sxcSendUs'];
	$sxcNumericConfirm = checkInputIsNumeric($sxcSendUsInput);
	if ($sxcNumericConfirm) {
		if($sxcSendUsInput >= 0 && $sxcSendUsInput <= 11){
			echo checkInputExchanger($sxcSendUsInput);
		}
	}
}

if (!empty($_POST["sxcRecieve"])) {
	$sxcRecieveInput = $_POST['sxcRecieve'];
	$sxcNumericConfirm = checkInputIsNumeric($sxcRecieveInput);
	if ($sxcNumericConfirm) {
		if($sxcRecieveInput >= 0 && $sxcRecieveInput <= 11){
			echo checkInputExchanger($sxcRecieveInput);
		}
	}
}


function checkInputIsNumeric($data)
{
	if (is_numeric($data)) {
		return true; 
	} else { 
		return false; 
	}
}

function checkInputExchanger($data)
{
	switch ($data) {
	    case 1:
	        return "skrill";
	        break;
	    case 2:
	        return "bkash";
	        break;
	    case 3:
	        return "coinbase";
	        break;
	    case 4:
	        return "bitcoin";
	        break;
	    case 5:
	        return "litcoin";
	        break;
	    case 6:
	        return "bitcoin";
	        break;
	    case 7:
	        return "dutchbangla";
	        break;
	    case 8:
	        return "neteller";
	        break;
	    case 9:
	        return "perfectmoney";
	        break;
	    case 10:
	        return "payoneer";
	        break;
	    case 11:
	        return "rocket";
	        break;
	    default:
	        return "Mass with the best die like the rest";
	}
}

?>