<?php

session_start();

if (isset($_POST["get_userData"])) {
    $userName = $_SESSION["userName"];
    $userPsw = $_SESSION["userPsw"];
    //$cryptPassword = password_hash($userPsw, PASSWORD_DEFAULT);
    //setcookie($nombreUser, $userName, time()+86415);
    $clieNom=$_POST["clieNom"];
    $email=$_POST["email"];
    if ($userName) {
        $userData = array("userName" => $userName, "userPsw" => $userPsw,"clieNom"=> $clieNom,"email"=>$email);
        echo json_encode($userData);
    } else {
        session_unset();
    }
}else if (isset($_POST["set_userData"])) {
    if (trim((string) ($_POST["userName"] ?? '')) === '3981') {
        $_SESSION = array();
        session_destroy();
        http_response_code(403);
        echo json_encode(array('message' => 'usuarioBloqueado'));
        exit;
    }

    $_SESSION["userName"] = $_POST["userName"];
    $_SESSION["userPsw"] = $_POST["userPsw"];
    $_SESSION["clieNom"] = $_POST["clieNom"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["facturar"] = $_POST["facturacion"];
    $_SESSION["saldo"] = $_POST["saldo"];
    $_SESSION["limcred"] = $_POST["limcred"];
    $_SESSION["status"] = $_POST["status"];
    $_SESSION["facts"] = $_POST["facts"];

    $userData = array("userName" => $_SESSION["userName"], "userPsw" => $_SESSION["userPsw"],"clieNom"=> $_SESSION["clieNom"],"email"=>$_SESSION["email"], "facturar"=>$_SESSION["facturar"], "saldo"=>$_SESSION["saldo"], "limcred"=>$_SESSION["limcred"], "status"=>$_SESSION["status"], "facts"=>$_SESSION["facts"]);
    echo json_encode($userData);
}else if (isset($_POST["logout"])) {
    // Destruir todas las variables de sesión.
    $_SESSION = array();
    // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
    // Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    // Finalmente, destruir la sesión.
    if (session_destroy()) {
        $responseDestructSession = array('message' => 'Sesion Finalizada');
        echo json_encode($responseDestructSession);
    } else {
        $responseDestructSession = array('message' => 'NO se ha podido eliminar la sesion');
        echo json_encode($responseDestructSession);
    }
    }else{
        $responseDestructSession = array('message' => 'NO se reconoce la Solicitud');
    echo json_encode($responseDestructSession);
    }
