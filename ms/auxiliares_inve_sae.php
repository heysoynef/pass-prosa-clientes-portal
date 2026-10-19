<?php

class funcionesAuxiliares {
    function arrayResult($transaction) {
        $rows = array();
        while ($row = $transaction->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
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
}

?>
