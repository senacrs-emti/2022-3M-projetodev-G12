<?php
include_once "db.php";

if (isset($_POST["cor"])) { 
    $cor = $_POST["cor"];

    queryDB("UPDATE `ultima` SET `cor` = '$cor' WHERE `ultima`.`id` = 1");
}

echo (queryDB("SELECT `cor` FROM `ultima` WHERE `id` = '1'")[0]);

?>