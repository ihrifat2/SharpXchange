<?php

require "dbconnect.php";
if (isset($_GET['testtimonial'])) {
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
}

?>
