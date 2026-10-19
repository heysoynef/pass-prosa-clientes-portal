<?php
// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../ms/ConectionMySQLi.php';

header('Content-Type: application/json; charset=utf-8');

$idPedido = 2906;
if (isset($_POST['idPedido'])) {
    $idPedido = (int) $_POST['idPedido'];
} elseif (isset($_GET['idPedido'])) {
    $idPedido = (int) $_GET['idPedido'];
}

if ($idPedido <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Debes enviar un idPedido valido.']);
    exit;
}

$datos = obtenerDatosPedido($idPedido);

if ($datos === null) {
    echo json_encode(['status' => 'error', 'message' => 'No se encontraron datos para el idPedido proporcionado.']);
    exit;
}

$_POST['datos'] = $datos;

ob_start();
require __DIR__ . '/reenviarCorreo.php';
$respuesta = trim(ob_get_clean());

echo json_encode([
    'status' => $respuesta === 'Exito' ? 'ok' : 'error',
    'message' => $respuesta,
    'idPedido' => $idPedido
]);

function obtenerDatosPedido($idPedido)
{
    $gesto = ConectionMySQLi::conectar();
    $idPedido = (int) $idPedido;

    $rowDatos = [];
    $queryDatos = "SELECT * FROM `datos` WHERE idPedido = {$idPedido}";
    $resultDatos = $gesto->query($queryDatos);
    if ($resultDatos && $resultDatos->num_rows > 0) {
        $tmpDatos = $resultDatos->fetch_assoc();
        if (is_array($tmpDatos)) {
            $rowDatos = $tmpDatos;
        }
    }

    $queryPedido = "SELECT * FROM `datospedidos` WHERE idPedido = {$idPedido}";
    $resultPedido = $gesto->query($queryPedido);
    if (!$resultPedido || $resultPedido->num_rows === 0) {
        return null;
    }

    $rowPedido = $resultPedido->fetch_assoc();
    if (!is_array($rowPedido)) {
        return null;
    }

    $cliente = obtenerClientePedido($gesto, $rowPedido);
    $correo = isset($rowDatos['correoF']) ? (string) $rowDatos['correoF'] : '';

    $prods = obtenerProductosPedido($gesto, $idPedido, $correo);
    if (empty($prods)) {
        return null;
    }

    $datosFiscales = [
        valorFila($rowDatos, 'nombreSocialF'),
        valorFila($rowDatos, 'rfcF'),
        valorFila($rowDatos, 'correoF'),
        valorFila($rowDatos, 'telefonoF'),
        valorFila($rowDatos, 'calleF'),
        valorFila($rowDatos, 'numEnF'),
        valorFila($rowDatos, 'numIxF'),
        valorFila($rowDatos, 'zipF'),
        valorFila($rowDatos, 'coloniaF'),
        valorFila($rowDatos, 'alcaldiaF'),
        valorFila($rowDatos, 'estadoF'),
        valorFila($rowDatos, 'regimenfiscal'),
        valorFila($rowDatos, 'comprobante'),
        valorFila($rowDatos, 'metodoPago'),
        valorFila($rowDatos, 'formaPago'),
    ];

    $datosEnvio = [
        valorFila($rowDatos, 'calleC'),
        valorFila($rowDatos, 'numIxC'),
        valorFila($rowDatos, 'numEnC'),
        valorFila($rowDatos, 'zipC'),
        valorFila($rowDatos, 'coloniaC'),
        valorFila($rowDatos, 'alcaldiaC'),
        valorFila($rowDatos, 'estadoC'),
        valorFila($rowDatos, 'referenciaC'),
    ];

    $flete = [
        $rowPedido['envio'],
        $rowPedido['subtotal'],
        $rowPedido['impuestos'],
        $rowPedido['total'],
        $rowPedido['envio'],
    ];

    $datosAdicionales = [
        $rowPedido['pesoTK'],
        $rowPedido['volumenC'],
        $rowPedido['numCajas'],
        $rowPedido['numPiezas'],
        $rowPedido['impuestos'],
        $rowPedido['envio'],
        $rowPedido['total'],
    ];

    return [
        'datosFiscales' => $datosFiscales,
        'datosEnvio' => $datosEnvio,
        'prods' => $prods,
        'datosAdicionales' => $datosAdicionales,
        'flete' => $flete,
        'cliente' => $cliente,
    ];
}

function obtenerProductosPedido($gesto, $idPedido, $correo)
{
    $idPedido = (int) $idPedido;
    $result = $gesto->query(
        "SELECT p.idProducto, p.precio, p.cantidad FROM prodspedido p WHERE p.idPedido = {$idPedido}"
    );

    if (!$result || $result->num_rows === 0) {
        return [];
    }

    $prods = [];
    while ($row = $result->fetch_assoc()) {
        $sku = $gesto->real_escape_string($row['idProducto']);
        $nombre = '';
        $resultProd = $gesto->query("SELECT DESCR FROM `productos` WHERE `CVE_ART` = '{$sku}'");
        if ($resultProd && $resultProd->num_rows > 0) {
            $rowProd = $resultProd->fetch_assoc();
            $nombre = $rowProd['DESCR'];
        }

        $precio = (float) $row['precio'];
        $cantidad = (float) $row['cantidad'];

        $prods[] = [
            'cv' => $row['idProducto'],
            'de' => $nombre,
            'pr' => $precio,
            'np' => $cantidad,
            'email' => $correo,
            'total' => number_format($precio * $cantidad, 2, '.', ','),
        ];
    }

    return $prods;
}

function valorFila(array $fila, $llave, $default = '')
{
    return isset($fila[$llave]) ? $fila[$llave] : $default;
}

function obtenerClientePedido($gesto, array $rowPedido)
{
    $clienteClave = isset($rowPedido['cliente']) ? trim((string) $rowPedido['cliente']) : '';

    if ($clienteClave === '') {
        return ['', '', '', 0, 0];
    }

    $clienteEscapado = $gesto->real_escape_string($clienteClave);
    $queryCliente = "SELECT CLAVE, NOMBRE, CAMPLIB9, SALDO, LIMCRED FROM `clie01` WHERE CLAVE = '{$clienteEscapado}'";
    $resultCliente = $gesto->query($queryCliente);

    if (!$resultCliente || $resultCliente->num_rows === 0) {
        return [$clienteClave, $rowPedido['cliente'], '', 0, 0];
    }

    $rowCliente = $resultCliente->fetch_assoc();

    return [
        $rowCliente['CLAVE'],
        $rowCliente['NOMBRE'],
        $rowCliente['CAMPLIB9'],
        $rowCliente['SALDO'],
        $rowCliente['LIMCRED'],
    ];
}
