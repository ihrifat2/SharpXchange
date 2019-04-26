<?php
session_start();
require "dbconnect.php";
require "helper.php";
require "xsrf.php";
require "hash.php";
require "header.php";
require 'pusher/vendor/autoload.php';

$options = array(
    'cluster' => 'ap2',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    'c0d39fd7bd9c14eb2b6a',
    '8c4db4e31baead871afd',
    '764369',
    $options
);

unset($_SESSION['sxcReceive']);
unset($_SESSION['sxcSendUs']);

$baseurl = "http://".$_SERVER['SERVER_NAME'];

function defaultExchangeRate(){
    $sendGT = 7;
    $recvGT = 1;
    $exchangeRate = exchangeRate($sendGT, $recvGT);
    return $exchangeRate;
}

function defaultReserve(){
    $recvGT = "Bkash Personal";
    $reserveAmount  = "Reserve: ".ReceiveReserveDefault($recvGT) . bdtOrUsbByGTName($recvGT);
    return $reserveAmount;
}

$data           = defaultExchangeRate();
$data           = rtrim($data);
$data           = explode(" ",$data);
$sendRate       = $data[2];
$recvRate       = $data[5];

$sqlQueryForNotice = "SELECT `notice1`, `notice2` FROM `tbl_additional_info`";
$result     = mysqli_query($dbconnect, $sqlQueryForNotice);
$rows       = mysqli_fetch_array($result);
$notice1    = $rows['notice1'];
$notice2    = $rows['notice2'];

if (isset($_POST['sxcConfirmTransaction'])) {
    sleep(5);

    $sessionHash   = 1337;
    $sessionHash   = encode($sessionHash);
    $_SESSION['SharpXchanger'] = $sessionHash;

    $status         = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);
    $sxcSendUsGT    = validate_input($_POST['sxcSendUsGT']);
    $sxcSendUsAmnt  = validate_input($_POST['sxcSendUsAmnt']);
    $sxcReceiveGt   = validate_input($_POST['sxcReceiveGt']);
    $sxcReceiveAmnt = validate_input($_POST['sxcReceiveAmnt']);
    $sxcActEmail    = validate_input($_POST['sxcActEmail']);
    $sxcRecvGWEm    = validate_input($_POST['sxcRecvGWEm']);
    $sxcActPhone    = validate_input($_POST['sxcActPhone']);
    $sxctransID     = validate_input($_POST['sxctransID']);
    $sxcSendUsGT    = checkGTNum($sxcSendUsGT);
    $sxcReceiveGt   = checkGTNum($sxcReceiveGt);
    $datetime       = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $time           = $datetime->format('F j, Y, l g:i a');
    $uname          = getUsername();
    $status         = 1;
    $hash           = uniqid() . ":" . $uname . ":" . getDateFormat($time);
    $hash           = encryptTransID($hash);
    $notifyText     = "New Transaction order Recieved";
    $notifyUrl      = "exchanges.php";

    if (!$status) {
        echo '<div id="snackbar">CSRF FAILED!</div>';
        echo "<script>snackbarMessage()</script>";
    } else {
        if (empty($sxcSendUsGT) || empty($sxcSendUsAmnt) || empty($sxcReceiveGt) || empty($sxcReceiveAmnt) || empty($sxcActEmail) || empty($sxcRecvGWEm) || empty($sxcActPhone) || empty($hash)) {
            echo "All fields are required.";
        } else {
            $sqlQuery = "INSERT INTO `tbl_exchange_info`(`exchange_id`, `gateway_sell`, `gateway_recieve`, `amount_sell`, `amount_recieve`, `username`, `email`, `phone_number`, `gateway_info_address`, `transaction_id`, `additional_info`, `status`, `create`) VALUES (NULL,'$sxcSendUsGT','$sxcReceiveGt','$sxcSendUsAmnt','$sxcReceiveAmnt','$uname','$sxcActEmail','$sxcActPhone','$sxcRecvGWEm', '$hash','$sxctransID','$status','$time')";
            $sqlQuerynotify = "INSERT INTO `tbl_admin_notification`(`notify_id`, `notify_text`, `notify_url`, `notify_imran`, `notify_nur`, `notify_robin`) VALUES (NULL,'$notifyText','$notifyUrl','0','0','0')";
            $result = mysqli_query($dbconnect, $sqlQuery);
            $resultnotify = mysqli_query($dbconnect, $sqlQuerynotify);
            if ($result || $resultnotify) {
                $text1 = '<div class="section0"><div class="row mb-4 box"><div class="col-sm-12 col-md-12">';
                $text1 .= "Thank you! After manually check all information, your transaction will make the exchange.";
                $text1 .= "</div></div>";
                $text1 .= '<div class="row mt-4 box"><div class="col-sm-12 col-md-12">';
                $text1 .= "You can track your exchange at this exchange Id: <br>";
                $text1 .= $hash;
                $text1 .= "</div></div></div>";
                echo "<script>document.getElementById('exchangeSection').innerHTML = '" . $text1 . "'</script>";
                $data['message'] = 1;
                $pusher->trigger('sharpxchange', 'notification', $data);
            } else {
                $text1 = '<div class="row box"><div class="col-sm-12 col-md-12">';
                $text1 .= "Thank you! If you facing any error please contact with us.";
                $text1 .= "</div></div>";
                echo "<script>document.getElementById('sharpxchange_step1').innerHTML = '" . $text1 . "'</script>";
            }
        }
    }
}
generateSessionToken();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Money Exchanger, Dollar Buy and Sell, Trusted Source">
    <meta name="keywords" content="Money Exchanger, Dollar Buy and Sell, Trusted Source">
    <meta property="og:url" content="https://www.sharpxchange.com">
    <meta property="og:title" content="Money Exchanger, Dollar Buy and Sell">
    <meta property="og:description" content="Money Exchanger, Dollar Buy and Sell, Trusted Source">
    <meta property="og:image" content="https://www.sharpxchange.com/assets/img/logo.png">
    <meta property="og:type" content="SharpXchange">
    <meta name="author" content="SharpXchange">
    <meta name="generator" content="SharpXchange">
    <title>SharpXchange</title>
    <base href="<?php echo $baseurl ?>">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900">
    <script src="https://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/popper.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/sharpxchange.js"></script>
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <script>
    Pusher.logToConsole = false;

    var pusher = new Pusher('c0d39fd7bd9c14eb2b6a', {
        cluster: 'ap2',
        forceTLS: true
    });

    var channel = pusher.subscribe('sharpxchange');
    channel.bind('notification', function(data) {
        // alert(JSON.stringify(data));
        // console.log(data['message']);
        if (data['message'] == 2) {
            document.getElementById('activeStatus').innerHTML = 'Operator : <span class="badge badge-success mr-2"><i class="fa fa-check"></i>Active</span>';
        }
        if (data['message'] == 3) {
            document.getElementById('activeStatus').innerHTML = 'Operator : <span class="badge badge-danger mr-2"><i class="fa fa-times"></i>Offline</span>';
        }
    });
    </script>
</head>
<body>
    <div class="container-fluid">
        <header class="sharpxchange-header py-3 sharpxchange-section-index">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <?php
                if (isset($_SESSION['user_login_session'])) {
                    echo '
                        <div class="col-md-6 pt-1 sharpxchange-header-nav-left dropdown">
                            <a class="btn btn-outline-sxc dropdown-toggle" href="#" role="button" id="accountDetails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Settings
                            </a>
                            <div class="dropdown-menu" aria-labelledby="accountDetails">
                                <a class="dropdown-item" href="account">Account Settings</a>
                                <a class="dropdown-item" href="exchange">Exchange Details</a>
                                <a class="dropdown-item" href="testimonial">Testimonial</a>
                                <a class="dropdown-item" href="logout">Logout</a>
                            </div>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="col-md-6 pt-1 sharpxchange-header-nav-left">
                            <a class="text-muted" href="/signup">Registration</a>
                            <a>/</a>
                            <a class="text-muted" href="/signin">login</a>
                        </div>
                        ';
                    }
                ?>
                <div class="col-sm-6 col-md-6 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
                    <span id="activeStatus">
                        Operator : 
                        <?php
                        if (getActiveStatus() == 0) {
                            echo '<span class="badge badge-danger mr-2"><i class="fa fa-times"></i>Offline</span>';
                        } else {
                            echo '<span class="badge badge-success mr-2"><i class="fa fa-check"></i>Active</span>';
                        }
                        ?>
                    </span>
                    <a class="text-dark">
                        Work time: 10:00 - 20:00, GMT +6
                    </a>
                </div>
            </div>
        </header>

        <div class="nav-scroller sharpxchange-section-index">
            <header class="masthead mb-auto">
                <div class="inner">
                    <h3 class="masthead-brand mb-3">
                        <img src="https://asset.sharpxchange.com/assets/img/logo.png">
                    </h3>
                    <nav class="nav nav-masthead justify-content-end">
                        <a class="nav-link active" href="/">EXCHANGE</a>
                        <a class="nav-link" href="/testimonials">TESTIMONIALS</a>
                        <a class="nav-link" href="/contact">CONTACT</a>
                        <a class="nav-link" href="/about">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>

        <?php
            if ($notice1 != NULL || $notice1 != "") {
                ?>
                <div class="row mb-3 mt-2">
                    <div class="sharpxchange-section-index col-md-12">
                        <center> 
                            <span class="btn notice1" >
                                <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" id="marquee" class="scrolling">  
                                    <span style="color: yellow">
                                        <strong> Notice : </strong>
                                    </span>
                                    <?php echo $notice1; ?>
                                </marquee>
                            </span>
                        </center>
                    </div>
                </div>
                <?php
            }
        ?>

        <?php
            if ($notice2 != NULL || $notice2 != "") {
                ?>
                <div class="row mb-3 mt-2">
                    <div class="sharpxchange-section-index col-md-12">
                        <center> 
                            <span class="btn notice1" >
                                <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" id="marquee" class="scrolling">  
                                    <span style="color: yellow">
                                        <strong> New Update : </strong>
                                    </span>
                                    <?php echo $notice2; ?>
                                </marquee>
                            </span>
                        </center>
                    </div>
                </div>
                <?php
            }
        ?> 

        <?php
            if (isset($_SESSION['SharpXchanger'])) {
                $session    = htmlspecialchars($_SESSION['SharpXchanger']);
                $session    = decode($session);
                if ($session == 1337) {
                    echo '<div class="row mt-3 mb-3 sharpxchange-section-group1">';
                    echo $text1;
                    echo "</div>";
                    // echo $text1;
                }
            }
        ?>

        <div class="row mt-3 mb-3 sharpxchange-section-group1" id="exchangeSection">
            <?php
                if (isset($_SESSION['SharpXchanger'])) {
                    unset($_SESSION['SharpXchanger']);
                    echo "<script>document.getElementById('exchangeSection').setAttribute('class', 'hide')</script>";
                }
            ?>
            <div class="col-md-8">
                <div class="section1 mb-4" id="section1">
                    <form method="POST" id="sharpxchange-form" action="<?php echo htmlspecialchars("/");?>">
                        <p id="sxc_exchange_results"></p>
                        <div class="tab-content">
                            <div class="tab-pane active" id="sharpxchange_step1">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <h3 class="sharpxchange-header py-3">
                                                    <i class="fa fa-arrow-down"></i> Send Us
                                                </h3>
                                                <div class="col-sm-12 col-md-12 hidden-xs hidden-sm text-center">
                                                    <div>
                                                        <img src="https://asset.sharpxchange.com/assets/img/skrill.png" id="sxc_imageSendUs" width="72px" height="72px" class="img-circle">
                                                        <p id="sxc_imageSendStatus"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <select class="form-control" id="sxcSendUs" name="sxcSendUsGT" onchange="checkSendUsGateway()">
                                                        <option value="1">Bkash Personal BDT</option>
                                                        <option value="2">DBBL Rocket BDT</option>
                                                        <option value="3">Coinbase USD</option>
                                                        <option value="4">Ethereum USD</option>
                                                        <option value="5">Neteller USD</option>
                                                        <option value="6">Payza USD</option>
                                                        <option value="7" selected>Skrill. USD</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" id="sxcAmountSend" name="sxcSendUsAmnt" placeholder="0" value="<?php echo $sendRate; ?>" onkeyup="calculateAmount()">
                                                </div>
                                                <div class="form-group">
                                                    <p id="sellUsStatus">
                                                        <?php
                                                            echo defaultExchangeRate();
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <h3 class="sharpxchange-header py-3">
                                                    <i class="fa fa-arrow-up"></i> You Receive
                                                </h3>
                                                <div class="col-sm-12 col-md-12 hidden-xs hidden-sm text-center">
                                                    <div>
                                                        <img src="https://asset.sharpxchange.com/assets/img/bkash.png" id="sxc_imageReceive" width="72px" height="72px" class="img-circle img-bordered">
                                                    </div>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <select class="form-control" id="sxcReceive" name="sxcReceiveGt" onchange="checkReceiveGateway()">
                                                        <option value="1" selected>Bkash Personal BDT</option>
                                                        <option value="2">DBBL Rocket BDT</option>
                                                        <option value="3">Coinbase USD</option>
                                                        <option value="4">Ethereum USD</option>
                                                        <option value="5">Neteller USD</option>
                                                        <option value="6">Payza USD</option>
                                                        <option value="7">Skrill. USD</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" id="sxcAmountReceive" name="sxcReceiveAmnt" value="<?php echo $recvRate; ?>" placeholder="0" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <p id="reserveStatus">
                                                        <?php 
                                                            echo defaultReserve();
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <center>
                                            <button type="button" class="btn btn-outline-sxc" id="btn_sharpxchange_step1" onclick="sxc_exchange_stepone()">
                                                <i class="fa fa-refresh"></i> Exchange
                                            </button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="sharpxchange_step2">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="sxcEmail">Active Email address</label>
                                            <input type="email" class="form-control" id="sxcActiveEmail" name="sxcActEmail">
                                        </div>
                                        <div class="form-group">
                                            <label for="sxcGatewayEmail" id="sxcReceiveGatewayName"></label>
                                            <input type="text" class="form-control" id="sxcReceiveGatewayEmail" name="sxcRecvGWEm">
                                        </div>
                                        <div class="form-group">
                                            <label for="sxcPhone">Active Phone Number</label>
                                            <input type="text" class="form-control" id="sxcActivePhone" name="sxcActPhone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <center>
                                            <button type="button" class="btn btn-outline-sxc" id="btn_sharpxchange_step2" onclick="sxc_exchange_steptwo()">
                                                <i class="fa fa-refresh"></i> Process Exchange
                                            </button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="sharpxchange_step3">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="exchageRateTable table table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    Account details
                                                </tr>
                                                <tr>
                                                    <td id="gateway_name"></td>
                                                    <td id="gateway_address"></td>
                                                </tr>
                                                <tr>
                                                    <td>Paymant Amount</td>
                                                    <td id="payoutAmount"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="form-group">
                                            <label for="sxctransactionID">Enter Transaction ID/Number/Batch</label>
                                            <input type="text" class="form-control" id="sxctransactionID" name="sxctransID">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <center>
                                            <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                                            <button type="submit" class="btn btn-outline-sxc" name="sxcConfirmTransaction">
                                                <i class="fa fa-refresh"></i> Confirm Transaction
                                            </button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="exchageRate section2 mb-4">
                    <div class="exchageRateSection">
                        <h5 class="title">Buy-Sell Rate</h5>
                        <table class="exchageRateTable table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">WE ACCEPT</th>
                                    <th scope="col">WE BUY</th>
                                    <th scope="col">WE SELL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $buySelldata = array();
                                    $buySellquery = "SELECT `gateway_name`, `we_buy`, `we_sell` FROM `tbl_gateway_info`";
                                    $buySellresult = $dbconnect->query($buySellquery);
                                    if ($buySellresult) {
                                        while ($buySellrows = $buySellresult->fetch_array(MYSQLI_ASSOC)) {
                                            $buySelldata[] = $buySellrows;
                                        }
                                        $buySellresult->close();
                                    }                                
                                    foreach ($buySelldata as $buySellRate) {
                                        //$currency = bdtOrUsb($buySellRate['gateway_name']);
                                        echo '
                                            <tr>
                                                <td>' . $buySellRate['gateway_name'] . '</td>
                                                <td>' . $buySellRate['we_buy'] . ' BDT' . '</td>
                                                <td>' . $buySellRate['we_sell'] . ' BDT' . '</td>
                                            </tr>
                                        ';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row sharpxchange-section-group2">
            <div class="col-md-9 sharpxchange-main section3 mb-3">
                <div class="exchageRate">
                    <div class="exchageRateSection">
                        <h5 class="title">Latest Exchange's</h5>
                        <table class="exchageRateTable table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Send</th>
                                    <th scope="col">Receive</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    $lastExchangedata = array();
                                    $lastExchangequery = "SELECT `gateway_sell`, `gateway_recieve`, `amount_sell`, `username`, `status`, `create` FROM `tbl_exchange_info` ORDER BY `exchange_id` DESC LIMIT 10";
                                    $lastExchangeresult = $dbconnect->query($lastExchangequery);
                                    if ($lastExchangeresult) {
                                        while ($lastExchangerows = $lastExchangeresult->fetch_array(MYSQLI_ASSOC)) {
                                            $lastExchangedata[] = $lastExchangerows;
                                        }
                                        $lastExchangeresult->close();
                                    }                                
                                    foreach ($lastExchangedata as $lastExchangeRate) {
                                        //$currency = bdtOrUsb($lastExchangeRate['gateway_name']);
                                        echo '
                                            <tr>
                                                <td>' . $lastExchangeRate['gateway_sell'] . '</td>
                                                <td>' . $lastExchangeRate['gateway_recieve'] . '</td>
                                                <td>' . $lastExchangeRate['amount_sell'] . bdtOrUsbByGTName($lastExchangeRate['gateway_sell']) . '</td>
                                                <td>' . ucfirst($lastExchangeRate['username']) . '</td>
                                                <td>' . getDateFormat($lastExchangeRate['create']) . '</td>
                                                <td>' . getbadgefromStatus($lastExchangeRate['status']) . '</td>
                                            </tr>
                                        ';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="col-md-3 sharpxchange-sidebar">
                <div class="exchageTrack section4 mb-2">
                    <form class="exchageTrackSection" method="get" action="<?php echo htmlspecialchars("/track");?>">
                        <h5 class="title">Track Exchange</h5>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Exchange ID" name="sxcTrackExID">
                            <div class="input-group-append">
                                <button class="btn btn-outline-sxc" type="submit" name="sxcTrackBtn">Track</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="exchageTrack section6 mb-2">
                    <div class="exchageTrackSection">
                        <h5 class="title">Our Reserve</h5>
                        <table class="exchageRateTable table table-striped table-hover">
                            <tbody>
                                <?php
                                    $reserveData = array();
                                    $reserveQuery = "SELECT `gateway_name`, `amount` FROM `tbl_reserve_list`";
                                    $reserveResult = $dbconnect->query($reserveQuery);
                                    if ($reserveResult) {
                                        while ($reserveRows = $reserveResult->fetch_array(MYSQLI_ASSOC)) {
                                            $reserveData[] = $reserveRows;
                                        }
                                        $reserveResult->close();
                                    }                                
                                    foreach ($reserveData as $reserveRate) {
                                        $currency = bdtOrUsbByGTName($reserveRate['gateway_name']);
                                        echo '
                                            <tr>
                                                <td>' . $reserveRate['gateway_name'] . '</td>
                                                <td>' . $reserveRate['amount'] . $currency . '</td>
                                            </tr>
                                        ';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </aside>
        </div>

        <div class="row sharpxchange-section-group2">
            <div class="exchageTrack section5 col-sm-12 col-md-12 ">
                <div>
                    <h5 class="title">Testimonials</h5>
                </div>
                <div class="row">
                    <?php
                        $tstimonlData = array();
                        $tstimonlQuery = "SELECT `username`, `testimonial_text` FROM `tbl_user_testimonials` WHERE `view` = 1 ORDER BY RAND() DESC LIMIT 3";
                        $tstimonlResult = $dbconnect->query($tstimonlQuery);
                        if ($tstimonlResult) {
                            while ($tstimonlRows = $tstimonlResult->fetch_array(MYSQLI_ASSOC)) {
                                $tstimonlData[] = $tstimonlRows;
                            }
                            $tstimonlResult->close();
                        }                                
                        foreach ($tstimonlData as $tstimonlRate) {
                            echo '
                                <div class="col-md-4">
                                    <div class="item">
                                        <h4>' . $tstimonlRate['username'] . '</h4>
                                        <h5>' . $tstimonlRate['testimonial_text'] . '</h5>
                                    </div>
                                </div>
                            ';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="sharpxchange-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Quick access</h3>
                    <ul>
                        <li>
                            <a href="/">Exchanger</a>
                        </li>
                        <li>
                            <a href="/testimonials">Testimonials</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li>
                            <a href="/policy">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="/about">About Us</a>
                        </li>
                        <li>
                            <a href="/contact">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Contact Information</h3>
                    <ul>
                        <li>Email : </li>
                        <li>Facebook : </li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="mt-3">Copyright © 2019. SharpXchange</p>
        <p><a href="#">Back to top</a></p>
    </footer>
    <script type="text/javascript">
        $(document).ready(function(){
            // $('#btn_sharpxchange_step1').click(function(){
            //     var sxcAmountSend = $("#sxcAmountSend").val();
            //     if (sxcAmountSend <= 10) {
            //         $("#sxc_exchange_results").html("");
            //     } else {
            //         $('#sharpxchange_step1').removeClass('active');
            //         $('#sharpxchange_step2').addClass('active in');
            //     }                
            // });
            // $('#btn_sharpxchange_step2').click(function(){
            //     $('#sharpxchange_step2').removeClass('active');
            //     $('#sharpxchange_step3').addClass('active in');
            // });
            $('#btn_sharpxchange_step3').click(function(){
                $('#sharpxchange_step3').removeClass('active');
                $("#sharpxchange-form").submit();
            });
        });
    </script>
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5ca249e21de11b6e3b064991/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
</body>
</html>
<?php

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkGTNum($data){
    if ($data >= 0 && $data <= 7) {
        $data = numToGtName($data);
        return $data;
    } else {
        header('Location : error.html');
        exit();
    }
}

function getUsername(){
    $username = $_SESSION['user_login_session'];
    if (empty($username)) {
        die();
    } else {
        return $username;
    }
}

function numToGtName($data){
    switch ($data) {
        case 1:
            return "Bkash Personal";
            break;
        case 2:
            return "DBBL Rocket";
            break;
        case 3:
            return "Coinbase";
            break;
        case 4:
            return "Ethereum";
            break;
        case 5:
            return "Neteller";
            break;
        case 6:
            return "Payza";
            break;
        case 7:
            return "Skrill";
            break;
        default:
            return "Mass with the best die like the rest";
    }
}

?>