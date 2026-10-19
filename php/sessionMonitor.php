<?php

    // Establece el tiempo de vida de la cookie de sesión en 1 hora (3600 segundos)
    session_set_cookie_params(3600);
    // Establece el tiempo máximo de vida de la sesión en el servidor
    ini_set('session.gc_maxlifetime', 3600);
// Inicia la sesión si no está iniciada aún


    // Verificar si las variables de sesión están definidas
    if (isset($_SESSION["userName"], $_SESSION["clieNom"], $_SESSION["email"])) {
        // Asignar las variables de sesión a variables locales
        $usuario = $_SESSION["userName"];
        $cliente = $_SESSION["clieNom"];
        $mailUser = $_SESSION["email"];
        $saldo = $_SESSION["saldo"];
        $limcred = $_SESSION["limcred"];
        $status = $_SESSION["status"];
        $facts = $_SESSION["facts"];

        // Obtener el valor de la variable de sesión "peds"
        $pedsValue = isset($_SESSION["peds"]) ? $_SESSION["peds"] : '';
        // Si "peds" no está vacío y la página es "Principal", destruir la variable de sesión
    /*        if (!empty($pedsValue) && $pagina == 'Principal') {
            unset($_SESSION["peds"]);
        }
    */
        if ($cliente == null || $usuario == null || $mailUser == null) {
            header('Location: acceso');
            exit; // Terminar la ejecución del script después de redirigir
        } else {
            $fichero = 'files/count.txt';
            $savedCount = intval(file_get_contents($fichero, FALSE, NULL, 0, 10));
            $newCount = $savedCount += 1;
            file_put_contents($fichero, $newCount);
            //endregion 
            //region Cookies
            $facturar = $_SESSION["facturar"];
            //end region
        }
    } else {        
        header('Location: acceso');
        exit; // Terminar la ejecución del script después de redirigir
        
    }

    if (isset($_POST["peds"])) {
        $_SESSION["peds"] = $_POST["peds"];
        echo $_SESSION["peds"];

    }


?>
