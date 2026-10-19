<?php

class ConectionMySQLi
{
    /*const host = "localhost";
    const usr = "root";
    const pwd = "";
    const db = "baseportal";*/
    const host = "localhost";
    const usr = "prosanaturalpass_passdesarrusu";
    const pwd = "armandoarmando123456";
    const db = "prosanaturalpass_portaldistribuidores";

    static function conectar()
    {
        $host = self::host;
        $usuario = self::usr;
        $contrasena = self::pwd;
        $base_de_datos = self::db;
      
        $conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        return $conn;
    }
}

?>
