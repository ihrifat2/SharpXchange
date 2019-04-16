<?php

header_remove("X-Powered-By");
header_remove("Server");
header('X-Frame-Options: DENY');
error_reporting(0);

?>