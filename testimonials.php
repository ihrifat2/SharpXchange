<?php

require "dbconnect.php";
require "header.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SharpXchange">
    <meta name="author" content="Imran Hadid">
    <meta name="generator" content="Imran">
    <title>SharpXchange</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <script src="https://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/sharpxchange.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-md-6 pt-1 sharpxchange-header-nav-left">
                    <a class="sharpxchange-header-logo text-dark" href="/">
                        <img src="https://asset.sharpxchange.com/assets/img/logo.png">
                    </a>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center sharpxchange-header-nav-right">
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
                        <a class="nav-link" href="/">EXCHANGE</a>
                        <a class="nav-link active" href="testimonials">TESTIMONIALS</a>
                        <a class="nav-link" href="contact">CONTACT</a>
                        <a class="nav-link" href="about">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="aboutsection sharpxchange-main">
                    <div class="sharpxchange-post">
                        <h2 class="sharpxchange-header sharpxchange-post-title py-3 mb-4">Testimonials</h2>
                        <div class="row">
                            <?php

                                $tstimonlData = array();
                                $tstimonlQuery = "SELECT `testimonial_id`, `username`, `testimonial_text` FROM `tbl_user_testimonials` WHERE `status` = 'Positive' ORDER BY `testimonial_id` DESC LIMIT 10";
                                $tstimonlResult = $dbconnect->query($tstimonlQuery);
                                if ($tstimonlResult) {
                                    while ($tstimonlRows = $tstimonlResult->fetch_array(MYSQLI_ASSOC)) {
                                        $tstimonlData[] = $tstimonlRows;
                                    }
                                    $tstimonlResult->close();
                                }
                                foreach ($tstimonlData as $tstimonlRow) {
                                    echo '
                                        <div class="col-md-4 col-sm-6 col-xs-12 mt-4 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                  <h5 class="card-title">' . $tstimonlRow['username'] . '</h5>
                                                  <p class="card-text text-justify">' . $tstimonlRow['testimonial_text'] . '</p>
                                                </div>
                                            </div>
                                        </div>
                                    ';
                                }
                            ?>
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
                            <a href="policy.php">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="aboutUs.php">About Us</a>
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