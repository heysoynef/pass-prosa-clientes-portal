<?php
    session_start(); // No necesitas verificar si session_start() retorna true
    include 'ruta.php';
    // Inicializar variables con valores predeterminados si no están definidas
    $usuario = isset($_SESSION["userName"]) ? $_SESSION["userName"] : null;
    $cliente = isset($_SESSION["clieNom"]) ? $_SESSION["clieNom"] : null;
    $mailUser = isset($_SESSION["email"]) ? $_SESSION["email"] : null;
    $saldo = isset($_SESSION["saldo"]) ? $_SESSION["saldo"] : null;
    $limcred = isset($_SESSION["limcred"]) ? $_SESSION["limcred"] : null;
    $status = isset($_SESSION["status"]) ? $_SESSION["status"] : null;
    $facts = isset($_SESSION["facts"]) ? $_SESSION["facts"] : null;

    if (trim((string) $usuario) === '3981') {
        $_SESSION = array();
        session_destroy();
        $usuario = $cliente = $mailUser = null;
    }

    if ($cliente !== null && $usuario !== null && $mailUser !== null) {
        header('Location:'.$ruta);
        exit(); // Asegúrate de usar exit() después de header() para detener la ejecución del script
    }
?>
