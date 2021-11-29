<?php
require_once("config.php");

$MerchantID = '0f9d808e-d7ec-11e7-8b16-005056a205be';


$Authority = $_GET['Authority'];

$data = array('MerchantID' => $MerchantID, 'Authority' => $Authority, 'Amount' => countFinalPrice());
$jsonData = json_encode($data);
$ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
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
curl_close($ch);
$result = json_decode($result, true);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    if ($result['Status'] == 100) {
        $query = query("UPDATE orders SET order_refid='{$result['RefID']}' order by order_id desc limit 1");
        echo 'Transation success. RefID:' . $result['RefID'];
    } else {
        echo 'Transation failed. Status:' . $result['Status'];
    }
}
?>