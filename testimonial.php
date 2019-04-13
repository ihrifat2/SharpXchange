<?php
session_start();
require "dbconnect.php";
require "usersqlhelper.php";
require "auth.php";
$username = $_SESSION['user_login_session'];
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
    <link rel="stylesheet" href="http://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://asset.sharpxchange.com/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://asset.sharpxchange.com/assets/css/accountupdate.css">

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
    <script src="http://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="http://asset.sharpxchange.com/assets/js/popper.min.js"></script>
    <script src="http://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
    <script src="http://asset.sharpxchange.com/assets/js/sharpxchange.js"></script>
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
                                <a class="dropdown-item" href="account">Account Settings</a>
                                <a class="dropdown-item" href="exchange">Exchange Details</a>
                                <a class="dropdown-item" href="testimonial">Testimonial</a>
                                <a class="dropdown-item" href="logout">Logout</a>
                            </div>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="col-sm-4 col-md-4 pt-1 sharpxchange-header-nav-left">
                            <a class="text-muted" href="signup">Registration</a>
                            <a>/</a>
                            <a class="text-muted" href="signin">login</a>
                        </div>
                        ';
                    }
                ?>
                <div class="col-sm-4 col-md-4 text-center">
                    <a class="sharpxchange-header-logo text-dark" href="/">SharpXchange</a>
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
                        <a class="nav-link" href="/">EXCHANGE</a>
                        <a class="nav-link" href="testimonials">TESTIMONIALS</a>
                        <a class="nav-link" href="contact">CONTACT</a>
                        <a class="nav-link" href="about">ABOUT US</a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <div class="line"></div>

    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <main role="main" class="col-md-9 col-lg-9">
                <div class="d-flex bd-highlight mt-3">
                    <div class="p-2 bd-highlight">
                        <h4>My Testimonial</h4>
                    </div>
                    <div class="ml-auto p-2 bd-highlight">
                        <button type="button" class="btn btn-outline-sxc" data-toggle="modal" data-target="#newFeedback">
                            <b>+</b> New Feedback
                        </button>
                    </div>
                </div>
                <!-- <p id="error"></p> -->
                <div class="row">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Feedback</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $testimonialdata = array();
                                $testimonialquery = "SELECT `testimonial_id`, `testimonial_text`, `status` FROM `tbl_user_testimonials` WHERE `username` = '$username'";
                                $testimonialresult = $dbconnect->query($testimonialquery);
                                if ($testimonialresult) {
                                    while ($testimonialrows = $testimonialresult->fetch_array(MYSQLI_ASSOC)) {
                                        $testimonialdata[] = $testimonialrows;
                                    }
                                    $testimonialresult->close();
                                }                                
                                foreach ($testimonialdata as $testimonialRate) {
                                    //$currency = bdtOrUsb($testimonialRate['gateway_name']);
                                    echo '
                                        <tr>
                                            <td>' . $testimonialRate['testimonial_text'] . '</td>
                                            <td>' . $testimonialRate['status'] . '</td>
                                            <td><button type="button" class="btn btn-outline-sxc" data-toggle="modal" data-target="#deleteFeedback" onclick="testimonialid('. $testimonialRate['testimonial_id'] .')">Delete</button></td>
                                        </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="newFeedback" tabindex="-1" role="dialog" aria-labelledby="newFeedbackLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/testimonial" method="post" accept-charset="utf-8">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newFeedbackLabel">TESTIMONIAL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="testimonialType">Type</label>
                            <select class="form-control" id="testimonialType" name="testimonialType">
                                <option value="1">Positive</option>
                                <option value="2">Negative</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="testimonialFeedback">Feedback</label>
                            <textarea class="form-control" id="testimonialFeedback" name="testimonialFeedback" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-sxc" name="testimonialBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteFeedback">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo htmlspecialchars("/testimonial");?>" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Feedback Delete</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        Do you want to delete this Feedback?
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-dismiss="modal">No</button>
                        <button type="Submit" class="btn btn-outline-danger" name="deleteFeedbackbtn">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="sharpxchange-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Quick access</h3>
                    <ul>
                        <li><a href="/">Exchanger</a></li>
                        <li><a href="testimonials">Testimonials</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Terms & Support</h3>
                    <ul>
                        <li><a href="policy">Privacy Policy</a></li>
                        <li><a href="about">About Us</a></li>
                        <li><a href="contact">Contact</a></li>
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
        function testimonialid($data) {
            document.cookie = "tstmonID="+$data;
        }
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
if (isset($_POST['testimonialBtn'])) {
    $tstmnlType     = validate_input($_POST['testimonialType']);
    $tstmnlFdbck    = validate_input($_POST['testimonialFeedback']);
    $view           = 0;
    $dt             = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $time           = $dt->format('F j, Y, l g:i a');
    $notifyText     = "New Testimonial Recieved";
    $notifyUrl      = "testimonials.php";
    
    if ($tstmnlType == 1 || $tstmnlType == 2) {
        if ($tstmnlType == 1) {
            $tstmnlType = "Positive";
        } else {
            $tstmnlType = "Negative";
        }
        $sqlQuery   = "INSERT INTO `tbl_user_testimonials`(`testimonial_id`, `username`, `testimonial_text`, `view`, `status`, `date`) VALUES (NULL,'$username','$tstmnlFdbck','$view','$tstmnlType','$time')";
        $sqlQuerynotify = "INSERT INTO `tbl_admin_notification`(`notify_id`, `notify_text`, `notify_url`, `notify_imran`, `notify_nur`, `notify_robin`) VALUES (NULL,'$notifyText','$notifyUrl','0','0','0')";
        $result         = mysqli_query($dbconnect, $sqlQuery);
        $resultnotify   = mysqli_query($dbconnect, $sqlQuerynotify);
        if ($result || $resultnotify) {
            echo "<script>javascript:document.location='/testimonial'</script>";
        } else {
            echo "<script>document.getElementById('error').innerHTML = 'Error while updating new feedback.'</script>";
        }
    } else {
        echo "<script>location.replace('error.html');</script>";
    }
}
if (isset($_POST['deleteFeedbackbtn'])) {
    $deleteFeedbackId = $_COOKIE['tstmonID'];
    $deleteFeedbackQuery = "DELETE FROM `tbl_user_testimonials` WHERE `testimonial_id` = '$deleteFeedbackId' AND `username` = '$username'";
    $deleteFeedbackResult = mysqli_query($dbconnect, $deleteFeedbackQuery);
    if ($deleteFeedbackResult) {
        setcookie('tstmonID', '', time() - 3600);
        echo '<script>document.cookie = "tstmonID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";</script>';
        echo "<script>javascript:document.location='/testimonial'</script>";
    } else {
        echo "<script>document.getElementById('error').innerHTML = 'Feedback not Deleted.' </script>";
    }
}
?>