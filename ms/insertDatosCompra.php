<?php
session_start();
include 'ConectionMySQLi.php';

    $obj = new ConectionMySQLi();
    $gesto = $obj->conectar();

    $queryId = "SELECT idPedido FROM datospedidos ORDER BY id DESC LIMIT 1;";
    $resultId = $gesto->query($queryId);
    $idP = 1;
    $clave = $_SESSION["userName"];

    if ($resultId->num_rows > 0) {
        $row = $resultId->fetch_assoc();
        $idP = $row['idPedido'];
        if (!empty($idP)) {
            $idP = $idP + 1;
        }
    }


    $queryL = "SELECT LISTA_PREC FROM clie01 WHERE CLAVE =" . $_SESSION["userName"] . "";
    $resultL = $gesto->query($queryL);
    $listaPrec = "";

    if ($resultL->num_rows > 0) {
        $rowL = $resultL->fetch_assoc();
        // echo "la lista de precios es: ".$rowL['LISTA_PREC'];
        $listaPrec = $rowL['LISTA_PREC'];
    }
    // echo $queryL."LA LISTA ES: ".$listaPrec;
    if($clave=='3981'){
        inserdatosCliente($idP);
    }
    insertarPedido($idP, $listaPrec);
    actualizaAcceso($idP);

    function inserdatosCliente($idP){
        global $gesto;

        $nombreSocialF = $_POST["datos"]["datosFiscales"][0];
        $rfcF = $_POST["datos"]["datosFiscales"][1];
        $mailF = $_POST["datos"]["datosFiscales"][2];
        $telF = $_POST["datos"]["datosFiscales"][3];
        $calleF = $_POST["datos"]["datosFiscales"][4];
        $numExF = $_POST["datos"]["datosFiscales"][5];
        $numInF = $_POST["datos"]["datosFiscales"][6];
        $zipF = $_POST["datos"]["datosFiscales"][7];
        $coloniaF = $_POST["datos"]["datosFiscales"][8];
        $alcaldiaF = $_POST["datos"]["datosFiscales"][9];
        $estadoF = $_POST["datos"]["datosFiscales"][10];

        if ($_POST["datos"]["datosFiscales"][11] == 'Selecciona' && $_POST["datos"]["datosFiscales"][12] == 'Selecciona' && $_POST["datos"]["datosFiscales"][13] == 'Selecciona' && $_POST["datos"]["datosFiscales"][14] == 'Selecciona') {
            $regimenfiscal = 'No Aplica';
            $comprobante = 'No Aplica';
            $metodoPago = 'No Aplica';
            $formaPago = 'No Aplica';
        } else {
            $regimenfiscal = $_POST["datos"]["datosFiscales"][11];
            $comprobante = $_POST["datos"]["datosFiscales"][12];
            $metodoPago = $_POST["datos"]["datosFiscales"][13];
            $formaPago = $_POST["datos"]["datosFiscales"][14];
        }

        $calleC = $_POST["datos"]["datosEnvio"][0];
        $numInC = $_POST["datos"]["datosEnvio"][1];
        $numEnC = $_POST["datos"]["datosEnvio"][2];
        $zipC = $_POST["datos"]["datosEnvio"][3];
        $coloniaC = $_POST["datos"]["datosEnvio"][4];
        $alcaldiaC = $_POST["datos"]["datosEnvio"][5];
        $estadoC = $_POST["datos"]["datosEnvio"][6];
        $referenciaC = $_POST["datos"]["datosEnvio"][7];

        date_default_timezone_set('America/Mexico_City');
        $query = "INSERT INTO `datos`(`idPedido`,`nombreSocialF`, `rfcF`, `correoF`, `telefonoF`, `calleF`, `numEnF`, `numIxF`, `zipF`, `coloniaF`, `alcaldiaF`, `estadoF`, `calleC`, `numEnC`, `numIxC`, `zipC`, `coloniaC`, `alcaldiaC`, `estadoC`, `referenciaC`, `regimenfiscal`, `comprobante`, `metodoPago`, `formaPago`,`fechaCrompra`) 
                VALUES ('$idP','$nombreSocialF','$rfcF','$mailF','$telF','$calleF','$numInF','$numExF','$zipF','$coloniaF','$alcaldiaF','$estadoF','$calleC','$numEnC','$numInC','$zipC','$coloniaC','$alcaldiaC','$estadoC','$referenciaC','$regimenfiscal','$comprobante','$metodoPago','$formaPago', NOW())";

        try {
            $result = $gesto->query($query);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    function insertarPedido($idP, $listaPrec)
    {
        global $gesto;
        if (isset($_SESSION["peds"])) {
            $jsonString = $_SESSION["peds"];
            $dataArray = json_decode($jsonString, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $numPiezas = 0;
                foreach ($dataArray as $item) {
                    $cv = $item['cv'];
                    $cantidad = $item['np'];
                    $precio = $item['pr'];
                    $queryI = "INSERT INTO `prodspedido`(`idProducto`, `precio`, `cantidad`, `idPedido`, `LISTA_PREC`)
                    VALUES ('$cv','$precio','$cantidad','$idP','$listaPrec')";
                    try {
                        $result = $gesto->query($queryI);
                        $numPiezas += $cantidad;
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
                echo insertardatospedidos($numPiezas, $idP);

            } else {
                echo "Error al decodificar el JSON: " . json_last_error_msg();
            }
        } else {
            echo "La variable de sesión 'peds' no está establecida.<br><br>";
        }
    }

    function insertardatospedidos($numPiezas, $idP)
    {
        global $gesto;
        $clave = $_SESSION["userName"];

        $piezas = number_format($numPiezas, 2, '.', ',');
        $fle1 = $_POST['datos']['flete'][0]; //envio
        $subtotal = $_POST['datos']['flete'][1];
        $impuestos = $_POST['datos']['flete'][2];
        $total = $_POST['datos']['flete'][3];
        $envio = $_POST['datos']['flete'][4];
        $precioTK = $_POST['datos']['datosAdicionales'][0];
        $volumenCub = $_POST['datos']['datosAdicionales'][1];
        $numCajas = $_POST['datos']['datosAdicionales'][2];

        $query = "INSERT INTO `datospedidos`(`pesoTK`, `volumenC`, `numPiezas`, `numCajas`, `subtotal`, `envio`, `impuestos`, `total`, `idPedido`, `cliente`) 
                VALUES ('$precioTK','$volumenCub','$piezas','$numCajas','$subtotal','$fle1','$impuestos','$total','$idP','$clave')";
        try {
            $result = $gesto->query($query);
            return json_encode(['estatus' => 'Exito']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        

    }
    
    function actualizaAcceso($idP){
        global $gesto;
        $token = $_SESSION["token"];
        $query = "UPDATE accesos SET idPedido='$idP' WHERE token='$token';";

        try {
            $result = $gesto->query($query);
            return json_encode(['estatus' => 'Exito']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        
    }
?>