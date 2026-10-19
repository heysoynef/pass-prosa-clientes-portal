<?php
    session_start();

    if (isset($_POST["get_userData"])) {
        // Comprobamos si las variables de sesión están definidas antes de usarlas
        if (isset($_SESSION["userName"]) && isset($_SESSION["userPsw"])) {
            $userName = $_SESSION["userName"];
            $userPsw = $_SESSION["userPsw"];
            //$cryptPassword = password_hash($userPsw, PASSWORD_DEFAULT);
            //setcookie($nombreUser, $userName, time()+86415);
            $clieNom = isset($_POST["clieNom"]) ? $_POST["clieNom"] : "";
            $email = isset($_POST["email"]) ? $_POST["email"] : "";

            // Si $userName está definido, devolvemos los datos del usuario
            if ($userName) {
                $userData = array(
                    "userName" => $userName,
                    "userPsw" => $userPsw,
                    "clieNom" => $clieNom,
                    "email" => $email
                );
                echo json_encode($userData);
                exit(); // Detenemos la ejecución del script después de enviar la respuesta JSON
            }
        }
        // Si no hay datos de usuario, limpiamos la sesión
        session_unset();
        session_destroy();
    } elseif (isset($_POST["set_userData"])) {
        // Establecemos los datos de usuario en la sesión
        $_SESSION["userName"] = $_POST["userName"];
        $_SESSION["userPsw"] = $_POST["userPsw"];
        $_SESSION["clieNom"] = $_POST["clieNom"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["facturar"] = $_POST["facturacion"];
        $_SESSION["saldo"] = $_POST["saldo"];
        $_SESSION["limcred"] = $_POST["limcred"];
        $_SESSION["status"] = $_POST["status"];
        $_SESSION["facts"] = $_POST["facts"];

        // Devolvemos los datos de usuario actualizados
        $userData = array(
            "userName" => $_SESSION["userName"],
            "userPsw" => $_SESSION["userPsw"],
            "clieNom" => $_SESSION["clieNom"],
            "email" => $_SESSION["email"],
            "facturar" => $_SESSION["facturar"],
            "saldo" => $_SESSION["saldo"],
            "limcred" => $_SESSION["limcred"],
            "status" => $_SESSION["status"],
            "facts" => $_SESSION["facts"]
        );
        echo json_encode($userData);
        exit(); // Detenemos la ejecución del script después de enviar la respuesta JSON
    } elseif (isset($_POST["logout"])) {
        // Elimina todos los datos de la sesión
        session_unset();

        // Destruye la sesión
        session_destroy();
    }
?>
