<?php
include '../ms/ConectionMySQLi.php';

$obj = new ConectionMySQLi();
$gesto = $obj->conectar();

$idPedido = $_POST['id'];

$query = "SELECT idPedido FROM `datospedidos` WHERE idPedido = '$idPedido'";
$result = $gesto->query($query);

if ($result->num_rows > 0) {
    consultas($idPedido);
} else {
    echo json_encode(['status' => 'error']);
}

function consultas($idPedido)
{
    global $gesto;

    // Consulta para obtener datos fiscales y de envío
    $queryDPers = "SELECT * FROM `datos` WHERE idPedido = '$idPedido'";
    $resutlDPers = $gesto->query($queryDPers);
    $rowDp = $resutlDPers->fetch_assoc();

    $datosFiscales = array(
        $rowDp['nombreSocialF'], $rowDp['rfcF'], $rowDp['correoF'], $rowDp['telefonoF'],
        $rowDp['calleF'], $rowDp['numEnF'], $rowDp['numIxF'], $rowDp['zipF'], $rowDp['coloniaF'],
        $rowDp['alcaldiaF'], $rowDp['estadoF'], $rowDp['regimenfiscal'], $rowDp['comprobante'], $rowDp['metodoPago'],
        $rowDp['formaPago']
    );

    $datosEnvio = array(
        $rowDp['calleC'], $rowDp['numIxC'], $rowDp['numEnC'], $rowDp['zipC'], $rowDp['coloniaC'],
        $rowDp['alcaldiaC'], $rowDp['estadoC'], $rowDp['referenciaC']
    );

    // Consulta para obtener detalles de productos
    $query = "SELECT * FROM prodspedido p
              INNER JOIN datos d ON d.idPedido = p.idP
              WHERE d.idPedido = '$idPedido'";
    $result = $gesto->query($query);
    $totalT = 0;
    $prods = array();

    while ($row = $result->fetch_assoc()) {
        $precio = $row['precio'];
        $cantidad = $row['cantidad'];
        $idProducto = $row['idProducto'];
        $correo = $rowDp['correoF'];
        $clave = $row['CLAVE'];
        $totalT += $precio * $cantidad;
        $total1 = $precio * $cantidad;

        // Consulta para obtener nombre del producto
        $queryProd = "SELECT DESCR FROM `productos` WHERE `CVE_ART` = '$idProducto'";
        $resultProd = $gesto->query($queryProd);
        $nombreProd = '';

        if ($resultProd->num_rows > 0) {
            $rowProd = $resultProd->fetch_assoc();
            $nombreProd = $rowProd['DESCR'];
        }

        $prods[] = array(
            'cv' => $idProducto,
            'de' => $nombreProd,
            'pr' => $precio,
            'np' => $cantidad,
            'email' => $correo,
            'total' => number_format($total1, 2, '.', ',')
        );
    }

    // Consulta para obtener datos del cliente
    $queryCLie = "SELECT * FROM `clie01` WHERE CLAVE = '$clave'";
    $resultClie = $gesto->query($queryCLie);
    $rowClie = $resultClie->fetch_assoc();

    $cliente = array(
        $rowClie['CLAVE'], $rowClie['NOMBRE'], $rowClie['CAMPLIB9'], $rowClie['SALDO'], $rowClie['LIMCRED']
    );

    // Consulta para obtener detalles del producto
    $queryDp = "SELECT * FROM `datospedidos` WHERE idPedido = '$idPedido'";
    $resultDp = $gesto->query($queryDp);
    $rowDprod = $resultDp->fetch_assoc();

    $flete = array(
        $rowDprod['envio'], $rowDprod['subtotal'], $rowDprod['impuestos'], $rowDprod['total'], $rowDprod['envio']
    );

    $datosAdicionales =  array(
        $rowDprod['pesoTK'], $rowDprod['volumenC'], $rowDprod['numCajas'], $rowDprod['numPiezas'], $rowDprod['impuestos'],
        $rowDprod['envio'], $rowDprod['total']
    );

    // Construcción del arreglo de datos
    $datos = array('datosFiscales' => $datosFiscales, 'datosEnvio' => $datosEnvio, 'prods' => $prods, 'datosAdicionales' => $datosAdicionales, 'flete' => $flete, 'cliente' => $cliente);
    echo json_encode($datos, JSON_PRETTY_PRINT);
}
?>
