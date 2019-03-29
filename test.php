<!DOCTYPE html>
<html>
<head>
    <title>test</title>
</head>
<body>
</body>
</html>
<?php

require "hash.php";

echo encrypt(1);

echo "<br>";

$decrypt = "6X15tSHjG01vA3DEWCIj6XR/A64NylmYUwat7v9SGtrWJMQf7gceJBVtNUi+1hT7bxBhNQNASCs6FXex4BWtsg";

echo decrypt($decrypt);




