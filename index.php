<?php
$postData = file_get_contents('php://input');
$data = json_decode($postData, true);
var_dump($postData);
require_once("api/reactionUI.php");
$reactionUI = new reactionUI('417445048:AAFx37CoDNNItBN0NHL3xj5TaBXNSNXqzgM', $data,'my_setting.ini');
?>