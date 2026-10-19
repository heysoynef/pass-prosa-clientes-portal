<?php
require 'sessionMonitorIndex.php';

if (isset($_POST["ap"]) && $_POST["ap"] === 'Apr') {
    $_SESSION["peds"] = isset($_POST["peds"]) ? $_POST["peds"] : null;
    echo $_SESSION["peds"];
} else {
    unset($_SESSION["peds"]);
}
?>