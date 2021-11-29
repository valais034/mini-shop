<?php
/**
 * Created by PhpStorm.
 * User: amirahmad
 * Date: 27/10/2017
 * Time: 05:50 PM
 */
require_once("config.php");

$Amount = countFinalPrice(); //Amount will be based on Toman - Required

$data = array(
    'MerchantID' => '0f9d808e-d7ec-11e7-8b16-005056a205be',
    'Amount' => $Amount,
    'CallbackURL' => 'http://localhost:8080/zarinpal/resources/verify.php',
    'Description' => 'خرید تست'
);


$jsonData = json_encode($data);
$ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));


$result = curl_exec($ch);
$err = curl_error($ch);
$result = json_decode($result, true);
curl_close($ch);


if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if ($result["Status"] == 100) {
        $array = ['Authority'=>$result["Authority"]];
        header('Content-Type: application/json');
        echo json_encode($array);
    } else {
        echo 'ERR: ' . $result["Status"];
    }
}
