<?php
$postData = file_get_contents('php://input');
$postData = file_get_contents('php://input');
$data = json_decode($postData, true);
// Блок переменных массив делим в переменные
$idmsg=$data['message']['message_id'];
$uid=$data['message']['from']['id'];
$unm=$data['message']['from']['first_name'];
$dt=date("Y-m-d H:i:s", $data['message']['date']);
$ms=$data['message']['text'];
$chatID=$data['message']['chat']['id'];
var_dump($postData);
require 'vendor/autoload.php';
use Telegram\Bot\Api;
$telegram = new Api('417445048:AAFx37CoDNNItBN0NHL3xj5TaBXNSNXqzgM');
/*
$response = $telegram->sendMessage([
  'chat_id' => $chatID, 
  'text' => 'Hello World'
]);
*/
$messageId = $response->getMessageId();
$response = $telegram->getMe();
var_dump($response);
?>