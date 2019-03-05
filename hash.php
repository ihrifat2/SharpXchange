<?php 

function encrypt( $string ) {
    $algorithm = 'imranhadid-1337'; // You can use any of the available
    $key = md5( "imranHadid", true); // bynary raw 16 byte dimension.
    $iv_length = mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
    $iv = mcrypt_create_iv( $iv_length, MCRYPT_RAND );
    $encrypted = mcrypt_encrypt( $algorithm, $key, $string, MCRYPT_MODE_CBC, $iv );
    $result = base64_encode( $iv . $encrypted );
    return $result;
}
function decrypt( $string ) {
    $algorithm =  'imranhadid-1337';
    $key = md5( "imranHadid", true );
    $iv_length = mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
    $string = base64_decode( $string );
    $iv = substr( $string, 0, $iv_length );
    $encrypted = substr( $string, $iv_length );
    $result = mcrypt_decrypt( $algorithm, $key, $encrypted, MCRYPT_MODE_CBC, $iv );
    return $result;
}

?>