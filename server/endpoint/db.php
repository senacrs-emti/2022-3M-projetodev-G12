<?php

define('DB_SERVER', '31.170.160.154');
define('DB_USERNAME', 'u878630845_roleta');
define('DB_PASSWORD', 'x2=ADPA@Kt7C');
define('DB_NAME', 'u878630845_roleta');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

function queryDB($query) {
    global $link;
    $result = $link->query($query);
    $row = mysqli_fetch_array($result);
    return $row;
}

function queryDBRows($query) {
    global $link;
    $result = $link->query($query);
    return $result;
}

?>
