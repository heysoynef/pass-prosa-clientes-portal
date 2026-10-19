<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pedsPed = isset($_SESSION["peds"]) ? $_SESSION["peds"] : null;
if ($pedsPed == null) {
    header('Location: ./');
    exit(); 
}
unset($_SESSION["peds"]);
?>