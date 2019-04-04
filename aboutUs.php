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
        .content {
            text-align: justify;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/sharpxchange.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="sharpxchange-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-md-6 pt-1 sharpxchange-header-nav-left">
                    <a class="sharpxchange-header-logo text-dark" href="index.php">
                        <img src="assets/img/logo.png">
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
                            <a class="nav-link" href="index.php">EXCHANGE</a>
                            <a class="nav-link" href="testimonials.html">TESTIMONIALS</a>
                            <a class="nav-link" href="contact.html">CONTACT</a>
                            <a class="nav-link active" href="aboutUs.php">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="aboutsection sharpxchange-main">
                    <div class="sharpxchange-post content">
                        <h2 class="sharpxchange-header sharpxchange-post-title py-3 mb-4">About Us</h2>
                        <?php 
                            require "dbconnect.php";
                            $sqlQuery   = "SELECT `text` FROM `tbl_page_settings` WHERE `page_id` = 1";
                            $result     = mysqli_query($dbconnect, $sqlQuery);
                            $rows       = mysqli_fetch_array($result);
                            $text       = $rows['text'];
                            echo $text;
                        ?>
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
        <center>
            <p class="mt-3">Copyright © 2019. SharpXchange</p>
            <p><a href="#">Back to top</a></p>
        </center>
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