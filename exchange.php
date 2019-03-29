<?php
session_start();
require "dbconnect.php";
require "usersqlhelper.php";
require "helper.php";
require "auth.php";
$username   = $_SESSION['user_login_session'];
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/accountupdate.css">

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
<body>
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
            <main role="main" class="col-md-9 col-lg-9">
                <h2>YOUR STATISTICS</h2>
                <div class="row ">
                    <div class="col-md-6 text-center">
                        <h4>Total Exchange</h4>
                        <p><?php echo getTotalExchangeByUname($username); ?></p>
                    </div>
                    <div class="col-md-6 text-center">
                        <h4>Total Processed</h4>
                        <p><?php echo getStatus($username); ?></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <h4>My Exchanges</h4>
                    <table class="exchageRateTable table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Send</th>
                                <th scope="col">Recieve</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php

                                    $exchngInfodata = array();
                                    $exchngInfoquery = "SELECT `gateway_sell`, `gateway_recieve`, `amount_sell`, `transaction_id` FROM `tbl_exchange_info` WHERE `username` = '$username'";
                                    $exchngInforesult = $dbconnect->query($exchngInfoquery);
                                    if ($exchngInforesult) {
                                        while ($exchngInforows = $exchngInforesult->fetch_array(MYSQLI_ASSOC)) {
                                            $exchngInfodata[] = $exchngInforows;
                                        }
                                        $exchngInforesult->close();
                                    }                                
                                    foreach ($exchngInfodata as $exchngInfoRow) {
                                        //$currency = bdtOrUsb($exchngInfoRow['gateway_name']);
                                        echo '
                                            <tr>
                                                <td>' . $exchngInfoRow['gateway_sell'] . '</td>
                                                <td>' . $exchngInfoRow['gateway_recieve'] . '</td>
                                                <td>' . $exchngInfoRow['amount_sell'] . bdtOrUsbByGTName($exchngInfoRow['gateway_sell']) . '</td>
                                                <td>' . $exchngInfoRow['transaction_id'] . '</td>
                                            </tr>
                                        ';
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
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
</body>
</html>