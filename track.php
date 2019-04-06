<?php
session_start();
require "dbconnect.php";
require "usersqlhelper.php";
require "helper.php";

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['sxcTrackBtn'])) {
    $exId = $_POST['sxcTrackExID'];
    $exId = validate_input($exId);
    $exId = mysqli_real_escape_string($dbconnect, $exId);
    $sqlQuery   = "SELECT `gateway_sell`, `gateway_recieve`, `amount_sell`, `amount_recieve`, `status`, `date` FROM `tbl_exchange_info` WHERE `transaction_id` = '$exId'";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    $rows       = mysqli_fetch_array($result);
    $gt_sell    = $rows['gateway_sell'];
    $gt_rcev    = $rows['gateway_recieve'];
    $amnt_sel   = $rows['amount_sell'];
    $amnt_rce   = $rows['amount_recieve'];
    $status     = $rows['status'];
    $date       = $rows['date'];
}
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
    <meta property="og:type" content="Website">
    <title>SharpXchange</title>
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
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sharpxchange.js"></script>
</head>
<body class="pagecontainer">
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <?php
                    if (isset($_SESSION['user_login_session'])) {
                        echo '
                        <div class="col-sm-4 col-md-4 pt-1 sharpxchange-header-nav-left dropdown">
                            <a class="btn btn-outline-sxc dropdown-toggle" href="#" role="button" id="accountDetails" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Settings
                            </a>

                            <div class="dropdown-menu" aria-labelledby="accountDetails">
                                <a class="dropdown-item" href="account.php">Account Settings</a>
                                <a class="dropdown-item" href="exchange.php">Exchange Details</a>
                                <a class="dropdown-item" href="testimonial.php">Testimonial</a>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="col-sm-4 col-md-4 pt-1 sharpxchange-header-nav-left">
                            <a class="text-muted" href="signup.php">Registration</a>
                            <a>/</a>
                            <a class="text-muted" href="signin.php">login</a>
                        </div>
                        ';
                    }
                ?>
                <div class="col-sm-4 col-md-4 text-center">
                    <a class="sharpxchange-header-logo text-dark" href="index.php">SharpXchange</a>
                </div>
                <div class="col-sm-4 col-md-4 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
                    <a class="text-muted">
                        Work time: 10:00 - 20:00, GMT +6
                    </a>
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mt-3 mb-3">
            <header class="masthead mb-auto">
                <div class="inner">
                    <nav class="nav nav-masthead justify-content-end">
                        <a class="nav-link" href="index.php">EXCHANGE</a>
                        <a class="nav-link" href="testimonials.html">TESTIMONIALS</a>
                        <a class="nav-link active" href="contact.html">CONTACT</a>
                        <a class="nav-link" href="aboutUs.php">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="line"></div>

    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <main role="main" class="col-md-9 col-lg-9  mt-4">
                <div class="exchageTrack section4 mb-2">
                    <form class="exchageTrackSection" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h5 class="title">Track Exchange</h5>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Exchange ID" name="sxcTrackExID">
                            <div class="input-group-append">
                                <button class="btn btn-outline-sxc" type="submit" name="sxcTrackBtn">Track</button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <div class="container-fluid" >
        <div class="row justify-content-md-center">
            <?php 

            if (!empty($gt_sell) || !empty($gt_rcev) || !empty($date)) {
                ?>
                <main role="main" class="col-md-9 col-lg-9 section4 mt-4">
                    <table class="table table-striped">
                        <tr>
                            <td colspan="2">
                                <h2 class="text-center">
                                    <img src="assets/img/<?php echo datanameToPic($gt_sell); ?>" width="50px" height="50px" class="img-circle">
                                    <b><?php echo $gt_sell; ?></b><i class="fa fa-refresh ml-4 mr-4"></i>
                                    <img src="assets/img/<?php echo datanameToPic($gt_rcev); ?>" width="50px" height="50px" class="img-circle">
                                    <b><?php echo $gt_rcev; ?></b>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">Send: <?php echo $amnt_sel . bdtOrUsbByGTName($gt_sell); ?></td>
                            <td colspan="1">Receive: <?php echo $amnt_rce . bdtOrUsbByGTName($gt_rcev); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Transaction ID: <?php echo $exId; ?></td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                Status: <?php echo getbadgefromStatus($status); ?>
                            </td>
                            <td colspan="1">
                                Created on<span class="badge badge-default"><?php echo $date; ?></span>
                            </td>
                        </tr>
                    </table>
                </main>
            <?php 
            } else {
            ?>
                <main role="main" class="col-md-9 col-lg-9 section4 mt-4 pt-2">
                    <h4>Nothing found. Please check the Exchange ID.</h4>
                </main>
            <?php 
            }
            ?>
        </div>
    </div>

    <footer class="sharpxchange-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Quick access</h3>
                    <ul>
                        <li><a href="index.php">Exchanger</a></li>
                        <li><a href="testimonials.html">Testimonials</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li><a href="policy.php">Privacy Policy</a></li>
                        <li><a href="aboutUs.php">About Us</a></li>
                        <li><a href="contact.html">Contact</a></li>
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

    <noscript>
        <style type="text/css">
            .pagecontainer {display:none;}
        </style>
        Your browser does not support JavaScript!
    </noscript>
</body>
</html>