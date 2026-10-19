<?php
$ch = curl_init('http://187.251.153.137:9090/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$err = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP code: $httpCode\n";
echo "Error: $err\n";
echo "Response: $response\n";
?>
