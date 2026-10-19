<?php
// Archivo: lg.php

header('Content-Type: application/json; charset=utf-8');
require_once 'ConectionMySQLi.php';

// =====================
//  Datos de entrada
// =====================
$userNameOriginal = $_POST['userName'] ?? '';
$userPsw          = $_POST['userPsw']  ?? '';

// =====================
//  Validar método
// =====================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["message" => "No se recibió una petición POST"], JSON_UNESCAPED_UNICODE);
    exit;
}

// =====================
//  Validar parámetros
// =====================
if ($userNameOriginal === '' || $userPsw === '') {
    echo json_encode(["message" => "Faltan parámetros"], JSON_UNESCAPED_UNICODE);
    exit;
}

// Solo números (opcional pero recomendable para evitar basura)
if (!ctype_digit($userNameOriginal) || !ctype_digit($userPsw)) {
    echo json_encode(["message" => "Usuario o contraseña incorrecta!"], JSON_UNESCAPED_UNICODE);
    exit;
}

// =====================
//  Usuario genérico
// =====================
$genericUser = '3981';
$genericPass = '000000';

// Si es el usuario genérico, manejamos todo aquí sin ir a MySQL/Firebird
if (trim($userNameOriginal) === $genericUser) {

    // Si la contraseña es incorrecta, ni siquiera tocamos BD
    if ($userPsw !== $genericPass) {
        echo json_encode(["message" => "Usuario o contraseña incorrecta!"], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Si la contraseña es correcta, regresamos un perfil genérico
    echo json_encode([
        "message"      => "usuarioAutenticado",
        "pwdIngresada" => $userPsw,
        "pwdBDD"       => $genericPass,
        "facturacion"  => "SI",                        // Ajusta según tu lógica
        "facts"        => "PORTAL PUBLICO MAYORISTA",  // Texto que quieras mostrar
        "clieNom"      => "CLIENTE PUBLICO MAYORISTA",
        "email"        => "",
        "saldo"        => 0,
        "status"       => "A",
        "limcred"      => 0,
        "lista_prec"   => 33                          // Lista de precios por defecto
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// =====================
//  Resto de usuarios
// =====================
$userName = str_pad($userNameOriginal, 10, " ", STR_PAD_LEFT);

class loginAuthentication
{
    /**
     * 1) Buscar en MySQL
     * 2) Si no existe, consultar a Firebird vía API y, si autentica, insertar en MySQL
     */
    public static function autenticar($userName, $userPsw, $userNameOriginal)
    {
        $objt1     = new ConectionMySQLi();
        $gestor_db = $objt1->conectar();

        if (!$gestor_db) {
            echo json_encode(["message" => "Error de conexión a MySQL"], JSON_UNESCAPED_UNICODE);
            return;
        }

        // 1) Intentar en MySQL
        $sql = "SELECT * 
                FROM clie01 
                WHERE CLAVE = ? 
                  AND CAMPLIB11 = ? 
                  AND STATUS = 'A' 
                  AND (EMAILPRED IS NOT NULL AND EMAILPRED != '')";

        $stmt = $gestor_db->prepare($sql);
        if (!$stmt) {
            echo json_encode(["message" => "Error al preparar la consulta MySQL"], JSON_UNESCAPED_UNICODE);
            $gestor_db->close();
            return;
        }

        $stmt->bind_param("ss", $userName, $userPsw);
        $stmt->execute();
        $result = $stmt->get_result();
        $row    = $result->fetch_assoc();
        $stmt->close();
        $gestor_db->close();

        if ($row) {
            // Usuario encontrado en MySQL
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
                "lista_prec"   => $row["LISTA_PREC"] ?? null
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        // 2) Si no está en MySQL, consultar Firebird vía API
        $firebird_response = self::buscarEnFirebird($userName, $userPsw, $userNameOriginal);
        echo json_encode($firebird_response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Llama al API de Firebird en los dos endpoints configurados.
     */
    public static function buscarEnFirebird($userName, $userPsw, $userNameOriginal)
    {
        $urls = [
            "http://prosa.dyndns-remote.com:9090/api-Pass-Portal/firebird_auth_api.php",
            "http://vpnprosa.dyndns.tv:9090/api-Pass-Portal/firebird_auth_api.php"
        ];

        foreach ($urls as $url) {
            $postData = [
                // Enviamos el userName ORIGINAL para que el API se encargue del padding
                "userName" => $userNameOriginal,
                "userPsw"  => $userPsw
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $response  = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_err  = curl_error($ch);
            curl_close($ch);

            if ($http_code == 200 && $response !== false) {
                $data = json_decode($response, true);

                if (!is_array($data) || !isset($data["message"])) {
                    // Respuesta no válida del API
                    return [
                        "message" => "Error al interpretar respuesta de Firebird",
                        "raw"     => $response
                    ];
                }

                if ($data["message"] === "usuarioAutenticado") {
                    // Insertar en MySQL sólo si autenticó correctamente
                    self::insertarEnMySQL($data, $userName);
                }

                return $data;
            }
        }

        // Si ningún endpoint respondió bien o no autenticó
        return ["message" => "Usuario o contraseña incorrecta!"];
    }

    /**
     * Inserta el cliente en MySQL con los datos regresados por Firebird.
     */
    public static function insertarEnMySQL($data, $userName)
    {
        $objt1    = new ConectionMySQLi();
        $mysql_db = $objt1->conectar();

        if (!$mysql_db) {
            // No reventamos el flujo; sólo no insertamos
            return;
        }

        $sql_insert = "INSERT INTO clie01 
                       (CLAVE, NOMBRE, EMAILPRED, CAMPLIB11, CAMPLIB8, SALDO, LIMCRED, STATUS, CAMPLIB9, LISTA_PREC)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_insert = $mysql_db->prepare($sql_insert);
        if (!$stmt_insert) {
            $mysql_db->close();
            return;
        }

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

// =====================
//  Ejecutar autenticación
// =====================
loginAuthentication::autenticar($userName, $userPsw, $userNameOriginal);
