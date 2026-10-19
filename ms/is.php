<?php
session_start();
require_once './ConectionMySQLi.php';

// Reutilizar la conexión a la base de datos
$conexion = ConectionMySQLi::conectar();
$conexion->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $userName = $_SESSION["userName"];
        $listPrec = obtenerListaPrec($conexion, $userName);

        if (isset($_POST["g_e"])) {
            $di = $_POST["di"];
            $resultados = obtenerResultados($conexion, $di, $listPrec);
            
            if ($resultados) {
                echo json_encode($resultados); // Convertimos el array a JSON y lo imprimimos
            } else {
                echo "0 results"; // Si no hay resultados, mostramos un mensaje
            }
        }
    } catch (Exception $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}

function obtenerListaPrec($conexion, $userName) {
    // Ajustamos a 10 caracteres con espacios a la izquierda
    $userName = str_pad($userName, 10, " ", STR_PAD_LEFT);

    $sql = "SELECT * FROM clie01 WHERE CLAVE ='$userName';";
    $statement = $conexion->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Devuelve el valor de LISTA_PREC si está definido, sino 1
        return $row["LISTA_PREC"] ? $row["LISTA_PREC"] : 33;
    } else {
        return 33;
    }
}

function obtenerResultados($conexion, $di, $listPrec) {
    switch ($di) {
        case "todos":
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,          
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,     
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NULL";
            break;

        case "Cosméticos":
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE LEFT(p.CAMPLIB12, 4) = 'Cosm'
                      AND l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NULL";
            break;

        // case "promociones":
        //     $sql = "SELECT 
        //                 p.CVE_ART,
        //                 p.DESCR,
        //                 p.LIN_PROD,
        //                 l.precio AS COSTO_PROM,
        //                 p.CVE_IMAGEN,
        //                 p.PESO,
        //                 p.VOLUMEN,
        //                 l.PRECIO,                        
        //                 p.UNI_ALT,
        //                 p.UNI_EMP,
        //                 l.lista_prec AS CVE_PRECIO,
        //                 p.CAMPLIB11,
        //                 p.CAMPLIB12,
        //                 p.EXIST
        //             FROM productos p
        //             JOIN lista_prec l
        //                 ON p.CVE_ART = l.sku
        //             WHERE LEFT(p.CAMPLIB12, 4) = 'prom'
        //               AND l.lista_prec = '$listPrec'
        //               AND p.CAMPLIB11 IS NULL";
        //     break;

        case "Suplementos Líquidos":
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE LEFT(p.CAMPLIB12, 3) = 'Sup'
                      AND l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NULL";
            break;

        case "Cápsulas":
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE LEFT(p.CAMPLIB12, 1) = 'C'
                      AND LEFT(p.CAMPLIB12, 3) NOT IN ('Cos', 'Cui')
                      AND l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NULL";
            break;

        case "Cuidado de la Piel":
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE p.CAMPLIB12 = 'Cuidado de la Piel'
                      AND l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NULL";
            break;

        case "Jarabes":
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE p.CAMPLIB12 = 'Jarabes'
                      AND l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NULL";
            break;

        case "Polvos":
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE p.CAMPLIB12 = 'Polvos'
                      AND l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NULL";
            break;

        default:
            $sql = "SELECT 
                        p.CVE_ART,
                        p.DESCR,
                        p.LIN_PROD,
                        l.precio AS COSTO_PROM,
                        p.CVE_IMAGEN,
                        p.PESO,
                        p.VOLUMEN,
                        l.PRECIO,                        
                        p.UNI_ALT,
                        p.UNI_EMP,
                        l.lista_prec AS CVE_PRECIO,
                        p.CAMPLIB11,
                        p.CAMPLIB12,
                        p.EXIST
                    FROM productos p
                    LEFT JOIN lista_prec l
                        ON p.CVE_ART = l.sku
                    WHERE l.lista_prec = '$listPrec'
                      AND p.CAMPLIB11 IS NOT NULL";
            break;
    }

    $gestor_sent = $conexion->prepare($sql);
    $gestor_sent->execute();
    $resultados = $gestor_sent->get_result(); // Obtenemos todas las filas de resultados

    return $resultados->num_rows > 0 ? arrayResult($resultados) : null;
}

function arrayResult($transaction) {
    $rows = array();
    while ($row = $transaction->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string($d)) {
        return utf8_encode($d);
    }
    return $d;
}
?>
