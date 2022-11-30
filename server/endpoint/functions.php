<?php

define('DB_SERVER', '31.170.160.154');
define('DB_USERNAME', 'u878630845_root');
define('DB_PASSWORD', 'D5p8hA*~');
define('DB_NAME', 'u878630845_ezscripts');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$method = 'aes-256-cbc';
$iv = chr(0x1) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

function sanitize($s) {
    return filter_var($s, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

function getName($n) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return strtoupper($randomString);
}

function getIP() {
    $ip = isset($_SERVER['HTTP_CLIENT_IP']) 
    ? $_SERVER['HTTP_CLIENT_IP'] 
    : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
      ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
      : $_SERVER['REMOTE_ADDR']);

    return $ip;
}

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

function decrypt($text, $pkey)
{
    $key = substr($pkey, 0, 16);
    $text = base64_decode($text);
    $IV = substr($text, strrpos($text, "-[--IV-[-") + 9);
    $text = str_replace("-[--IV-[-".$IV, "", $text);

    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_CBC, $IV), "\0");
}

function encrypt($text, $pkey)
{
    $key = substr($pkey, 0, 16);
    $IV = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_RAND);

    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_CBC, $IV)."-[--IV-[-".$IV);
}

function authenticate($hwid, $username, $password, $ip, $date) {
    if(!isset($username) || !isset($password) || !isset($hwid)) { 
        header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        die("Not today.");
    }

    $authstatus = 3;

    $enabled = queryDB("SELECT `enabled` FROM `loader`")[0];

    $banned = queryDB("SELECT `banned` FROM `users` WHERE `username` = '$username' AND `password` = '$password'")[0];
    $registered = queryDB("SELECT `hwid` FROM `users` WHERE `username` = '$username' AND `password` = '$password'")[0];

    if ($enabled != "0") {
        if($banned != '1') {
            if ($registered == '') {
                queryDB("UPDATE `users` SET `hwid` = '$hwid' WHERE `username` = '$username' AND `password` = '$password'");
            }

            if($hwid == queryDB("SELECT `hwid` FROM `users` WHERE `username` = '$username' AND `password` = '$password'")[0]) {
                queryDB("UPDATE `users` SET `ip` = '$ip' WHERE `username` = '$username' AND `password` = '$password'");
                queryDB("UPDATE `users` SET `last_login` = '$date' WHERE `username` = '$username' AND `password` = '$password'");
                queryDB("UPDATE `users` SET `online` = '1' WHERE `username` = '$username' AND `password` = '$password'");

                $authstatus = 0;
            }
        }

        else {
            $authstatus = 1;
        }
    }

    else {
        $authstatus = 2;
    }

    return $authstatus;
}

$download = [
    "Rust" => [
        "BarrelCollection" => [
            "None" => [0],
            "Silencer" => [0]
        ],

        "SightCollection" => [
            "None" => [0],
            "Holographic Sight" => [0],
            "Simple Sight" => [0],
            "8x Scope" => [0],
            "16x Scope" => [0]
        ],
        
        "WeaponColletion" => [
            "None" => [0, []],
            "Assault Rifle" => [240, [
                [-5, 50], 
                [-9, 50], 
                [-30.5, 50], 
                [-25.5, 50], 
                [-27.5, 50], 
                [-34, 50], 
                [-35.5, 50],
                [-38, 50],
                [-30, 50],
                [-30, 50],
                [-32, 50],
                [-32, 50],
                [-35, 50],
                [-35, 50],
                [-35, 50],
                [-35, 50],
                [-35, 50],
                [-32, 50],
                [-34, 50],
                [-34, 50],
                [-32, 50]
            ]],
            "Thompson" => [228, [
                [0, 20],
                [0, 20], 
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20]
            ]],
            "Custom SMG" => [180, [
                [0, 20],
                [0, 20], 
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20]
            ]],
            "LR" => [53, [
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20]
            ]],
            "MP5" => [78, [
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20],
                [0, 20]
            ]],
            "HMLMG" => [37, [
                [0, 10],
                [2, 12], 
                [3, 12],
                [5, 15], 
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13],
                [7, 13], 
                [7, 13], 
                [7, 13]
            ]],
            "M249" => [40, [
                [0, 10],
                [2, 12]
            ]],
        ]
    ]
  ];

?>
