<?php
/*El siguiente código tiene como funcionalidad hacer las consultas que se llevarán  a cabo en el proyecto

*/ 
session_start();
include('conexion.php');

//echo " prueba del servidor ";
//echo $_SERVER['REQUEST_METHOD']."\n";

if($_SERVER['REQUEST_METHOD']=="POST") {
//echo "prueba de la conexión \n";
//echo $conn."\n";
    if ($conn) {
        $userName = $_SESSION["userName"];
        
        
        $userName = str_pad($userName,10," ",STR_PAD_LEFT); //--Agrega espacios en blanco a la izquierda del número
    
      
        $sql = "SELECT FECHA_DOC, CVE_DOC, NUM_ALMA FROM SAE.FACTF01 WHERE FECHA_DOC='2019-07-24 00:00:00.000' ";
        $transaction = sqlsrv_query($conn , $sql);
        $pedidos = arrayResult($transaction);
       /*Si no encuentra una lista, toma por default la lista 1*/ 
        if ($pedidos[0]['CVE_DOC'] == NULL) {
            $pedidos=1;
        } 
        else {
            $listPrec = $listP[0]['LISTA_PREC'];
        }
       

       

        $gestor_sent=sqlsrv_query($conn,$sql);

        $num_rows = 0;
        while ($rows[$num_rows]=sqlsrv_fetch_array($gestor_sent, SQLSRV_FETCH_ASSOC)){
            $num_rows++;
        }
        
        if ($num_rows > 0) {
            echo json_encode(utf8ize($rows));
        } else {
            echo "0 results";
        }

        //ibase_free_result($gestor_sent);
        //ibase_close($conn);
        
    } else {
        echo "Connection failed";
    }
}

function arrayResult($transaction) {
    $num_rows = 0;
    while ($rows[$num_rows] = sqlsrv_fetch_array($transaction,SQLSRV_FETCH_ASSOC)) {
        $num_rows++;
    }
    return $rows;
}

function utf8_encode_array($array) {
    return array_map('utf8_encode', $array);
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}

?>