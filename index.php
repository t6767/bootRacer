<?php
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
require_once("api/reactionUI.php");
$reactionUI = new reactionUI();
?>