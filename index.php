<?php
var_dump($_GET);
$postData = file_get_contents('php://input');
var_dump($postData);
require 'vendor/autoload.php';
use Telegram\Bot\Api;
$telegram = new Api('1011237128:AAH5GA5D1yP09M-hgWbc-3fD11RP9vTXgMw');
$response = $telegram->getMe();
var_dump($response);
?>