<?php
/*
*   Created By:     SDE. Alfredo Jimenez Miguel.
*   Company:        PASS Consultores.
*   Date:           Oct 2019
*/
date_default_timezone_set('America/Mexico_City');
 class reqCredentials{
     static function sendRequestCredentials($clieName, $clieMail){
        $srvResp = array();
        $name = "Solicitando nuevas claves de Acceso";
        $from_email ="desarrollo2@pass.com.mx";
        $subject = utf8_decode('Cliente solicita nuevas claves de Acceso');
        $bodyText = "Cliente: $clieName ha solicitado restablecimiento de cuenta, enviar datos al correo: $clieMail";
        require 'PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->CharSet="utf-8";
        $mail->IsSMTP();
        $mail->Host = "mail.pass.com.mx";
        $mail->SMTPAuth = true;
        $mail->Username = 'pruebas@pass.com.mx';
        $mail->Password = 'G%Qy}AFSk{AA';
        //$mail->SMTPSecure = 'tls';
        $mail->Port = 26;
        $mail->setFrom($from_email, $name);
        //$mail->addAddress($_POST["email"]); destino del mail al correo del cliente logeado
        $mail->addAddress('desarrollo@pass.com.mx'); // destino de pruebas agregar argumento en la llamada a la clase y parámetro a la función
        //$mail->addAddress('desarrollo@pass.com.mx'); //// Copia destino de pruebas
        $mail->Subject = $subject;
        $mail->Body = $bodyText;
        $mail->IsHTML(true);

        if ($mail->send()) {
            $srvResp['message'] = "Message sent!";
            echo json_encode($srvResp, JSON_FORCE_OBJECT);
        } else {
            $srvResp['message'] =  "Mailer Error: ".$mail->ErrorInfo;
            echo json_encode($srvResp, JSON_FORCE_OBJECT);
        }        
     }
 }

 //,cmpMailRecCred
 if (array_key_exists("userNameRecCred",$_REQUEST)){
    $objtMail = new reqCredentials();
    //$response = array('usuario'=>$_REQUEST["userNameRecCred"], 'Email'=>$_REQUEST["userMailRecCred"]);
    $serverResponse = $objtMail->sendRequestCredentials($_REQUEST["userNameRecCred"], $_REQUEST["userMailRecCred"]);
    echo $serverResponse;
 }

 /*if(session_start()){
    
    $numCte = $_SESSION["userName"];
    $nameCte = $_SESSION["clieNom"];
    $serverResponse = $objtMail->sendRequestCredentials($numCte, $nameCte);
    echo ($serverResponse);
 }*/else{
    $response = array('message'=>'NO se han podido recuperar los datos de Sesion');
    echo $response;
 }
