<?php

require "dbconnect.php";
require "helpertwo.php";

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!empty($_POST['contName']) && !empty($_POST['contMail']) && !empty($_POST['contSub']) && !empty($_POST['conTxt'])) {
	$platform 	= parse_user_agent()['platform'];
	$browser 	= parse_user_agent()['browser'];
	$version 	= parse_user_agent()['version'];
	$contact_name = ucfirst($_POST['contName']);
	$contact_mail = $_POST['contMail'];
	$contact_subj = ucfirst($_POST['contSub']);
	$contact_text = ucfirst($_POST['conTxt']);
	$dt 		= new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $time 		= $dt->format('F j, Y, l g:i a');
    $ip 		= get_ip_address();
    $notifyText = "New Contact Message Recieved";
    $notifyUrl 	= "contactus.php";
    if (filter_var($contact_mail, FILTER_VALIDATE_EMAIL)) {
    	$sqlQuery = "INSERT INTO `tbl_contact_info`(`contact_id`, `contact_name`, `contact_mail`, `contact_sub`, `contact_text`, `contact_date`, `contact_ip`, `contact_platform`, `contact_browser`, `contact_version`) VALUES (NULL, '$contact_name', '$contact_mail', '$contact_subj', '$contact_text', '$time', '$ip', '$platform', '$browser', '$version')";
    	$sqlQuerynotify = "INSERT INTO `tbl_admin_notification`(`notify_id`, `notify_text`, `notify_url`, `notify_imran`, `notify_nur`, `notify_robin`) VALUES (NULL,'$notifyText','$notifyUrl','0','0','0')";
		$result 		= mysqli_query($dbconnect, $sqlQuery);
        $resultnotify 	= mysqli_query($dbconnect, $sqlQuerynotify);
		if ($result || $resultnotify) {
			$status 	= 0;
			$text 		= "Contact Form Submitted.";
		} else {
			$status 	= 1;
			$text 		= "Error while submitting form.";
		}
    } else {
    	$status 	= 1;
		$text 		= "Invalid Email.";
    }
	$dataLimit 	= array($status, $text);
	echo json_encode($dataLimit);
} else {
	$status 	= 1;
	$text 		= "All fields are required.";
	$dataLimit 	= array($status, $text);
	echo json_encode($dataLimit);
}

?>