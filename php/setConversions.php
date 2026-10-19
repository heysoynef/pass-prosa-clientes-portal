<?php
/*
*   Created By:     SDE. Alfredo Jimenez Miguel.
*   Company:        PASS Consultores.
*   Date:           Oct 2019
*/
if (array_key_exists('increment', $_REQUEST)) {
    $i = $_REQUEST['increment'];
    $fichero = '../files/conversion.txt';
    $savedCount = intval(file_get_contents($fichero, FALSE, NULL, 0, 10));
    $newCount = $savedCount += 1;
    // Escribe el contenido al fichero
    if (file_put_contents($fichero, $newCount)){
        echo "Conversion Correcta: ".$newCount;
    } else {
        echo "Sin actualizar registro: " . $savedCount;
    }
} else {
    echo "No se obtuvo datos";
}
