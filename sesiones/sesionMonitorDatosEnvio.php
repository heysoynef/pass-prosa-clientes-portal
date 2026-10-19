<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Inicia la sesiиоn solo si no estив ya activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si la clave "peds" existe en $_SESSION
$pedsPed = isset($_SESSION["peds"]) ? $_SESSION["peds"] : null;

// Si $pedsPed es null, redirige al usuario
if ($pedsPed == null) {
    // Redirige al usuario
    header('Location: index.php');
    exit(); // Asegи▓rate de que el script se detenga despuижs de la redirecciиоn
}
?>