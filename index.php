<?php
session_start();
require "dbconnect.php";
require "helper.php";
unset($_SESSION['sxcReceive']);
unset($_SESSION['sxcSendUs']);

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

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SharpXchange">
    <meta name="author" content="Imran Hadid">
    <meta name="generator" content="Imran">
    <title>SharpXchange</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="assets/js/sharpxchange.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <?php
                    if (isset($_SESSION['user_login_session'])) {
                        echo '
                        <div class="col-sm-6 col-md-6 pt-1 sharpxchange-header-nav-left">
                            <a class="text-muted" href="logout.php">Logout</a>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="col-sm-6 col-md-6 pt-1 sharpxchange-header-nav-left">
                            <a class="text-muted" href="signup.php">Registration</a>
                            <a>/</a>
                            <a class="text-muted" href="signin.php">login</a>
                        </div>
                        ';
                    }
                ?>
                <div class="col-sm-6 col-md-6 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
                    <a class="text-muted">
                        Work time: 10:00 - 20:00, GMT +6
                    </a>
                </div>
            </div>
        </header>

        <div class="nav-scroller">
            <header class="masthead mb-auto">
                <div class="inner">
                    <h3 class="masthead-brand">SharpXchange</h3>
                    <nav class="nav nav-masthead justify-content-end">
                        <a class="nav-link active" href="index.php">EXCHANGE</a>
                        <a class="nav-link" href="testimonials.html">TESTIMONIALS</a>
                        <a class="nav-link" href="contact.html">CONTACT</a>
                        <a class="nav-link" href="aboutUs.html">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12 col-md-12">
                <center> 
                    <span class="btn" style="text-align: center; font-weight: 600; background: #1b1464; color: white; width: 100%; height:35px;">
                        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" id="MARQUEE1" style="text-align: left;" class="scrolling">  
                            <span style="color: yellow">
                                <strong> Notice : </strong>
                            </span>
                            যে কোন প্রয়োজনে আমাদের কে ফোন করুন 01XXXXXXXXX এবং লেনদেন শেষে আমাদের TESTIMONIALS দিতে ভুলবেন না। 
                        </marquee>
                    </span>
                </center>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12 col-md-12">
                <center> 
                    <span class="btn" style="text-align: center; font-weight: 600; background: #29abe2; color: white; width: 100%; height:35px;">
                        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" id="MARQUEE1" style="text-align: left;" class="scrolling">  
                            <span style="color: yellow"><strong> New Update  :  </strong>
                            </span>
                            Skrill 10 Dollar (1060 Taka) Neteller 10 Dolllar (1060 Taka) Old Or New Rate:- Skrill Buy = 100 (old rate 96) Neteller Buy = 100 (old rate 96)  এখন থেকে যারা &zwj;skrill or neteller dollar ওডার করবেন তাদের কে skrill or neteller full fee বহন করতে হবে।   
                        </marquee>
                    </span>
                </center>
            </div>
        </div>  

        <div class="row mt-3 mb-3 sharpxchange-section-group1">
            <div class="col-sm-8 col-md-8">
                <div class="section1 mb-4">
                    <form method="POST" id="sharpxchange-form" action="#">
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
                                                        <img src="assets/img/skrill.png" id="sxc_imageSendUs" width="72px" height="72px" class="img-circle">
                                                        <p id="sxc_imageSendStatus"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <select class="form-control" id="sxcSendUs" name="sxcSendUs" onchange="checkSendUsGateway()">
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
                                                    <input type="number" class="form-control" id="sxcAmountSend" placeholder="0" value="<?php echo $sendRate; ?>" onkeyup="calculateAmount()">
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
                                                        <img src="assets/img/bkash.png" id="sxc_imageReceive" width="72px" height="72px" class="img-circle img-bordered">
                                                    </div>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <select class="form-control" id="sxcReceive" name="sxcReceive" onchange="checkReceiveGateway()">
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
                                                    <input type="number" class="form-control" id="sxcAmountReceive" value="<?php echo $recvRate; ?>" placeholder="0" readonly>
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
                                            <button type="button" class="btn btn-outline-sxc" id="btn_sharpxchange_step1" onclick="sxc_exchange_step1()">
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
                                            <label for="sxcActiveEmail">Active Email address</label>
                                            <input type="email" class="form-control" id="sxcActiveEmail">
                                        </div>
                                        <div class="form-group">
                                            <label for="sxcGatewayEmail">Skrill address</label>
                                            <input type="email" class="form-control" id="sxcGatewayEmail">
                                        </div>
                                        <div class="form-group">
                                            <label for="sxcActivePhone">Active Phone Number</label>
                                            <input type="email" class="form-control" id="sxcActivePhone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <center>
                                            <button type="button" class="btn btn-outline-sxc" id="btn_sharpxchange_step2">
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
                                                    <td>Our Skrill Account</td>
                                                    <td>skrill@email.com</td>
                                                </tr>
                                                <tr>
                                                    <td>Paymant Amount</td>
                                                    <td>10 USD</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="form-group">
                                            <label for="sxcActivePhone">Enter Transaction ID/Number/Batch</label>
                                            <input type="email" class="form-control" id="sxctransactionID">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <center>
                                            <button type="button" class="btn btn-outline-sxc">
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

            <div class="col-sm-4 col-md-4">
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
                                    $buySellquery = "SELECT `gateway_name`, `we_buy`, `we_sell` FROM `gateway_info`";
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

    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-9 sharpxchange-main section3 mb-3">
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
                                <tr>
                                    <td>Bkash Personal BDT</td>
                                    <td>Skrill. USD</td>
                                    <td>1020 BDT</td>
                                    <td>Jhon</td>
                                    <td>1/2/19</td>
                                    <td>Processed</td>
                                </tr>
                                <tr>
                                    <td>DBBL Rocket BDT</td>
                                    <td>Neteller . USD</td>
                                    <td>2100 BDT</td>
                                    <td>Petter</td>
                                    <td>16/1/19</td>
                                    <td>Processed</td>
                                </tr>
                                <tr>
                                    <td>Bkash Personal BDT</td>
                                    <td>Neteller . USD</td>
                                    <td>2025 BDT</td>
                                    <td>Mark</td>
                                    <td>22/5/19</td>
                                    <td>Awaiting Payment</td>
                                </tr>
                                <tr>
                                    <td>DBBL Rocket BDT</td>
                                    <td>Skrill. USD</td>
                                    <td>1170 BDT</td>
                                    <td>Marry</td>
                                    <td>7/8/19</td>
                                    <td>Cancel</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="col-sm-3 col-md-3 sharpxchange-sidebar">
                <div class="exchageTrack section4 mb-2">
                    <div class="exchageTrackSection">
                        <h5 class="title">Track Exchange</h5>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Track ID" aria-label="Track ID" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-sxc" type="button" id="button-addon1">Track</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="exchageTrack section6 mb-2">
                    <div class="exchageTrackSection">
                        <h5 class="title">Our Reserve</h5>
                        <table class="exchageRateTable table table-striped table-hover">
                            <tbody>
                                <?php
                                    $reserveData = array();
                                    $reserveQuery = "SELECT `gateway_name`, `amount` FROM `reserve_list`";
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

        <div class="row">
            <div class="exchageTrack section5 col-sm-12 col-md-12">
                <div>
                    <h5 class="title">Testimonials</h5>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div class="item popular-item">
                            <div class="thumb">
                                <h3 class="item-price"><span class="label label-success" style="color:#fff; font-size: 14px;"><i class="fa fa-smile-o"></i> Positive</span></h3>
                                <h4>Imran</h4>
                                <h5>"Great job. awesome service."</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <div class="item popular-item">
                            <div class="thumb">
                                <h3 class="item-price"><span class="label label-success" style="color:#fff; font-size: 14px;"><i class="fa fa-smile-o"></i> Positive</span></h3>
                                <h4>Nur</h4>
                                <h5>"Very Fast Service Thanks"</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <div class="item popular-item">
                            <div class="thumb">
                                <h3 class="item-price"><span class="label label-success" style="color:#fff; font-size: 14px;"><i class="fa fa-smile-o"></i> Positive</span></h3>
                                <h4>Robin</h4>
                                <h5>"just awesome site"</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <div class="item popular-item">
                            <div class="thumb">
                                <h3 class="item-price"><span class="label label-success" style="color:#fff; font-size: 14px;"><i class="fa fa-smile-o"></i> Positive</span></h3>
                                <h4>Nipa</h4>
                                <h5>"Good and fast service! Thank you."</h5>
                            </div>
                        </div>
                    </div>
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
                            <a href="index.php">Exchanger</a>
                        </li>
                        <li>
                            <a href="testimonials.html">Testimonials</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li>
                            <a href="policy.html">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="aboutUs.html">About Us</a>
                        </li>
                        <li>
                            <a href="contact.html">Contact</a>
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
            $('#btn_sharpxchange_step1').click(function(){
                var sxcAmountSend = $("#sxcAmountSend").val();
                if (sxcAmountSend <= 10) {
                    $("#sxc_exchange_results").html("The minimum amount for exchange is 10 USD.");
                } else {
                    $('#sharpxchange_step1').removeClass('active');
                    $('#sharpxchange_step2').addClass('active in');
                }                
            });
            $('#btn_sharpxchange_step2').click(function(){
                $('#sharpxchange_step2').removeClass('active');
                $('#sharpxchange_step3').addClass('active in');
            });
            $('#btn_sharpxchange_step3').click(function(){
                $('#sharpxchange_step3').removeClass('active');
                $("#sharpxchange-form").submit();
            });
        });
    </script>
</body>
</html>
<?php
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
?>