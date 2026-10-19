<?php
/*
*   Created By:     EQUIPO DE DESARROLLO 
*   Company:        PASS Consultores.
*   Date:           Oct 2019
*   Last Modification:  Nov 15 2019
*/

/*El siguiente código tiene como funcionalidad hacer las consultas que se llevarán  a cabo en el proyecto*/
session_start();
require_once './fireBirdConn.php';
require_once './auxiliares_inve_sae.php';

class inventarioSAE
{
    static function getProductos()
    {
        $obj1 = new ConectionFirebird();
        $objAux = new funcionesAuxiliares();
        $gestor_db = $obj1->conectar();
        $listP = array();
        $serverResponse = array();
        if ($gestor_db) {
            $userName = $_SESSION["userName"];
            //$userName = "4";
            $userName = str_pad($userName, 10, " ", STR_PAD_LEFT);
            $sql = "SELECT LISTA_PREC FROM CLIE01 WHERE CLAVE = '$userName'";
            $transaction = ibase_query($gestor_db, $sql) or die(ibase_errmsg());
            $num_rows = 0;
            while ($row[$num_rows] = ibase_fetch_assoc($transaction)) {
                $num_rows++;
            }
            
            if ($row[0]["LISTA_PREC"]) {
                $listPrec = $row[0]["LISTA_PREC"];
                //$numAlm = $row[0]["CAMPLIB2"];
                //Consulta para obtener el multi almacen
                //$almAd = " (SELECT EXIST FROM MULT01 WHERE CVE_ALM = " . $numAlm . " AND CVE_ART = M.CVE_ART) AS AD, ";
                //$orAlm = " OR M.CVE_ALM = " . $numAlm;
            } else {
                $listPrec = 1;
                //$almAd = "";
                //$orAlm = "";
                //$arrayResponse = array("datosRecuperados" => "Lista Nula Valor por Default: $listPrec");FIRST 100
            }

            $listPrec = $row[0]["LISTA_PREC"];




            
            $sql1 = "SELECT DISTINCT I.CVE_ART, I.DESCR, I.LIN_PROD, I.COSTO_PROM, I.CVE_IMAGEN, I.PESO, I.VOLUMEN, PXP.PRECIO, I.UNI_ALT, I.UNI_EMP, 
            (SELECT EXIST FROM MULT01 WHERE CVE_ALM = 2 AND CVE_ART = M.CVE_ART) AS A4
            FROM MULT01 M
            LEFT JOIN INVE01 I ON I.CVE_ART = M.CVE_ART
            LEFT JOIN PRECIO_X_PROD01 PXP ON PXP.CVE_PRECIO = ".$listPrec."  AND PXP.CVE_ART = M.CVE_ART
            WHERE CVE_IMAGEN IS NOT NULL AND CVE_IMAGEN!=' ' AND (M.CVE_ALM = 2) AND (I.CVE_PRODSERV IS NOT NULL) AND M.EXIST>0
            AND (I.CVE_UNIDAD IS NOT NULL) ORDER BY I.CVE_ART";


       


            $transaction1 = ibase_query($gestor_db, $sql1) or die(ibase_errmsg());
            $num_rows1 = 0;
            /*$serverResponse = ibase_fetch_assoc($transaction1);
            CVE_ART
            DESCR
            LIN_PROD
            COSTO_PROM
            CVE_IMAGEN
            PESO_unitario
            VOLUMEN_unitario
            PRECIO_unitario
            UNI_ALT
            Piezas_por_UNI_EMP

            echo json_encode($serverResponse);*/
            while ($serverResponse[$num_rows1] = ibase_fetch_assoc($transaction1)) {
                $num_rows1++;
            }
            if ($num_rows1 > 0) {
                $listP = $objAux->utf8ize($serverResponse);
                echo json_encode($listP, JSON_FORCE_OBJECT);
                ibase_free_result($transaction);
                ibase_free_result($transaction1);
                ibase_close($gestor_db);
            } else {
                $serverResponse['message'] = '0 results';
            }
        } else {
            $serverResponse['message'] = "Connection failed";
            echo json_encode($serverResponse);
        }
    }

    static function getCategories($criterio)
    {
        $serverResponse2 = array();
        if ($criterio) {
            $obj2 = new ConectionFirebird();
            $objAux2 = new funcionesAuxiliares();
            $gestor_db2 = $obj2->conectar();
            $listP2 = array();
            if ($gestor_db2) {
                $userName2 = $_SESSION["userName"];
                //$userName = "4";
                $userName2 = str_pad($userName2, 10, " ", STR_PAD_LEFT);
                $sql2 = "SELECT LISTA_PREC FROM CLIE01 WHERE CLAVE = '$userName2'";
                $transaction = ibase_query($gestor_db2, $sql2) or die(ibase_errmsg());
                $num_rows = 0;
                while ($row[$num_rows] = ibase_fetch_assoc($transaction)) {
                    $num_rows++;
                }
                if ($row[0]["LISTA_PREC"]) {
                    $listPrec = $row[0]["LISTA_PREC"];
                    //$numAlm = $row[0]["CAMPLIB2"];
                    //Consulta para obtener el multi almacen
                    //$almAd = " (SELECT EXIST FROM MULT01 WHERE CVE_ALM = " . $numAlm . " AND CVE_ART = M.CVE_ART) AS AD, ";
                    //$orAlm = " OR M.CVE_ALM = " . $numAlm;
                } else {
                    $listPrec = 1;
                   // $almAd = "";
                    //$orAlm = "";
                    //$arrayResponse = array("datosRecuperados" => "Lista Nula Valor por Default: $listPrec");FIRST 100
                }
                
            $sql3 = "SELECT DISTINCT I.CVE_ART, I.DESCR, I.LIN_PROD, I.COSTO_PROM, I.CVE_IMAGEN, I.PESO, I.VOLUMEN, PXP.PRECIO, I.UNI_ALT, I.UNI_EMP,SEGM.CAMPLIB12, 
            (SELECT EXIST FROM MULT01 WHERE CVE_ALM = 1 AND CVE_ART = M.CVE_ART) AS A2,
            (SELECT EXIST FROM MULT01 WHERE CVE_ALM = 2 AND CVE_ART = M.CVE_ART) AS A4
            FROM MULT01 M
            LEFT JOIN INVE01 I ON I.CVE_ART = M.CVE_ART
            LEFT JOIN PRECIO_X_PROD01 PXP ON PXP.CVE_PRECIO = ".$listPrec." AND PXP.CVE_ART = M.CVE_ART
            LEFT JOIN INVE_CLIB01 SEGM ON I.CVE_ART = SEGM.CVE_PROD  
            WHERE CVE_IMAGEN IS NOT NULL AND CVE_IMAGEN!=' ' AND ( M.CVE_ALM = 1  OR M.CVE_ALM = 2) AND (I.CVE_PRODSERV IS NOT NULL) 
            AND (I.CVE_UNIDAD IS NOT NULL) 
            AND (SEGM.CAMPLIB12 = '$criterio')
            ORDER BY I.CVE_ART";
                $transaction2 = ibase_query($gestor_db2, $sql3) or die(ibase_errmsg());
                $num_rows1 = 0;
                /*$serverResponse = ibase_fetch_assoc($transaction1);
            CVE_ART
            DESCR
            LIN_PROD
            COSTO_PROM
            CVE_IMAGEN
            PESO_unitario
            VOLUMEN_unitario
            PRECIO_unitario
            UNI_ALT
            Piezas_por_UNI_EMP

            echo json_encode($serverResponse);*/
                while ($serverResponse2[$num_rows1] = ibase_fetch_assoc($transaction2)) {
                    $num_rows1++;
                }
                if ($num_rows1 > 0) {
                    $listP = $objAux2->utf8ize($serverResponse2);
                    echo json_encode($listP, JSON_FORCE_OBJECT);
                    ibase_free_result($transaction);
                    ibase_free_result($transaction2);
                    ibase_close($gestor_db2);
                } else {
                    $serverResponse2['message'] = '0 results';
                }
            } else {
                $serverResponse2['message'] = "Connection failed";
                echo json_encode($serverResponse2);
            }
        } else {
            $serverResponse2['message'] = "Error";
            echo json_encode($serverResponse2);
        }
    }
}

function utf8_encode_array($array)
{
    return array_map('utf8_encode', $array);
}

function utf8ize($d)
{
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string($d)) {
        return utf8_encode($d);
    }
    return $d;
}

/*
Se realizaron modificaciones para conectar y obtener registros, sin embargo, al modularizar, las funciones auxiliares:
    utf8_encode_array, utf8ize no estaban al alcance de la función Main: "GetProductos", por lo que se sacaron de
    la clase.
*************************************
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    //if (isset($_POST["get_existencias"])) {
        $mainObj = new inventarioSAE();
        echo ($mainObj->getProductos());
    /*} else {
        $serverResponse = array('message' => 'No se reconoce el tipo de solicitud');
        echo json_encode($serverResponse);
    }***
} else {
    $serverResponse = array('message' => 'No se recibio GET peticion');
    echo json_encode($serverResponse);
}
*/

if (array_key_exists("funcion",$_REQUEST)){
    $mainObj = new inventarioSAE();
    if(!strcasecmp($_REQUEST['funcion'], 'buscarTodos')){
        echo ($mainObj->getProductos());
    }else if(!strcasecmp($_REQUEST['funcion'], 'buscarPorCategoria')){
        echo ($mainObj->getCategories($_REQUEST['criterio']));
    }else{
        $serverResponse = array('message' => 'Error');
        echo json_encode($serverResponse);
    }
    /*funcion : 'buscarPorCategoria',
    criterio : 'Polvos',*/
}

