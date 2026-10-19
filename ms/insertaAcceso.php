<?php
session_start();
    include 'ConectionMySQLi.php';

    $obj = new ConectionMySQLi();
    $gesto = $obj->conectar();


    $userName = $_SESSION["userName"];
    $userName = str_pad($userName, 10, " ", STR_PAD_LEFT);
    if($userName!='' && $userName>1){
        insertaAcceso($userName);
    }


    function insertaAcceso($userName) {
        global $gesto;
    
        date_default_timezone_set('America/Mexico_City');
    
        // Generar un token basado en la fecha, hora y nombre de usuario
        $fechaHora = date('YmdHis'); // Formato: YYYYMMDDHHMMSS
        $token = md5($userName . $fechaHora); // Generar un hash único
        $_SESSION["token"]=$token;
    
        // Preparar la consulta SQL
        $query = "INSERT INTO `accesos` (`claveUsuario`, `fechayhora`, `idPedido`, `token`) 
                  VALUES ('$userName', NOW(), 'NO', '$token')";
    
        try {
            // Ejecutar la consulta
            $result = $gesto->query($query);
            return json_encode("Éxito");
    
        } catch (Exception $e) {
            // Capturar y mostrar cualquier error
            echo $e->getMessage();
        }
    }





    

?>
