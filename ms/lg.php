<?php
// Archivo: mysql_auth_api.php

header('Content-Type: application/json');
require_once 'ConectionMySQLi.php';

$userName = str_pad($_POST['userName'], 10, " ", STR_PAD_LEFT);
$userPsw  = $_POST['userPsw'];

class loginAuthentication {

    static function autenticar($userName, $userPsw) {
        // La cuenta generica 3981 ya no tiene permitido acceder al portal.
        if (trim($userName) === '3981') {
            echo json_encode(["message" => "usuarioBloqueado"]);
            return;
        }

        $objt1    = new ConectionMySQLi();
        $gestor_db = $objt1->conectar();
        
        if ($gestor_db) {

            // Detectar si es el usuario generico 3981
            $claveSinEspacios = trim($userName);

            if ($claveSinEspacios === '3981') {
                // Usuario generico: NO validar password
                $sql = "SELECT * 
                        FROM clie01 
                        WHERE CLAVE = ? 
                          AND STATUS = 'A' 
                          AND (EMAILPRED IS NOT NULL AND EMAILPRED != '')";

                $stmt = $gestor_db->prepare($sql);
                $stmt->bind_param("s", $userName);

            } else {
                // Resto de usuarios: validar CLAVE + CAMPLIB11 (password)
                $sql = "SELECT * 
                        FROM clie01 
                        WHERE CLAVE = ? 
                          AND CAMPLIB11 = ? 
                          AND STATUS = 'A' 
                          AND (EMAILPRED IS NOT NULL AND EMAILPRED != '')";

                $stmt = $gestor_db->prepare($sql);
                $stmt->bind_param("ss", $userName, $userPsw);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $row    = $result->fetch_assoc();
            $stmt->close();
            $gestor_db->close();

            if ($row) {
                echo json_encode([
                    "message"      => "usuarioAutenticado",
                    "pwdIngresada" => $userPsw,
                    "pwdBDD"       => $row["CAMPLIB11"],
                    "facturacion"  => $row["CAMPLIB8"],
                    "facts"        => $row["CAMPLIB9"],
                    "clieNom"      => $row["NOMBRE"],
                    "email"        => $row["EMAILPRED"],
                    "saldo"        => $row["SALDO"],
                    "status"       => $row["STATUS"],
                    "limcred"      => $row["LIMCRED"],
                    "lista_prec"   => isset($row["LISTA_PREC"]) ? $row["LISTA_PREC"] : null
                ]);
                return;
            }

            // Si no esta en MySQL, consultar Firebird (logica normal)
            $firebird_response = self::buscarEnFirebird($userName, $userPsw);
            echo json_encode($firebird_response);
            return;
        }

        echo json_encode(["message" => "Error de conexion a MySQL"]);
    }
    
    static function buscarEnFirebird($userName, $userPsw) {
        $urls = [
            "http://prosa.dyndns-remote.com:9090/api-Pass-Portal/firebird_auth_api.php",
            "http://vpnprosa.dyndns.tv:9090/api-Pass-Portal/firebird_auth_api.php"
        ];

        foreach ($urls as $url) {
            $postData = [
                "userName" => $userName,
                "userPsw"  => $userPsw
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            $response  = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 200) {
                $data = json_decode($response, true);
                if (isset($data["message"]) && $data["message"] == "usuarioAutenticado") {
                    self::insertarEnMySQL($data);
                }
                return $data;
            }
        }

        return ["message" => "Usuario o password incorrectos!"];
    }
    
    static function insertarEnMySQL($data) {
        $objt1    = new ConectionMySQLi();
        $mysql_db = $objt1->conectar();

        if (!$mysql_db) {
            return;
        }

        $sql_insert = "INSERT INTO clie01 
                       (CLAVE, NOMBRE, EMAILPRED, CAMPLIB11, CAMPLIB8, SALDO, LIMCRED, STATUS, CAMPLIB9, LISTA_PREC)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $userName = str_pad($_POST['userName'], 10, " ", STR_PAD_LEFT);

        $stmt_insert = $mysql_db->prepare($sql_insert);
        $stmt_insert->bind_param(
            "ssssssssss", 
            $userName,
            $data['clieNom'], 
            $data['email'], 
            $data['pwdBDD'], 
            $data['facturacion'], 
            $data['saldo'], 
            $data['limcred'], 
            $data['status'], 
            $data['facts'],
            $data['lista_prec']
        );
        $stmt_insert->execute();
        $stmt_insert->close();
        $mysql_db->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    loginAuthentication::autenticar($userName, $userPsw);
} else {
    echo json_encode(["message" => "No se recibio una peticion POST"]);
}
?>
