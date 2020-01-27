<?php
require 'vendor/autoload.php';
use Telegram\Bot\Api;
/*$response = $telegram->sendMessage([
  'chat_id' => $chatID, 
  'text' => 'Hello World'
]);
$messageId = $response->getMessageId();

$response = $telegram->getMe();
var_dump($response);
$result = $telegram -> getWebhookUpdates();
var_dump($result);
*/

class reactionUI extends PDO
{
	// Создадим конструктор ебаный Лего
	public function __construct($bootID, $data, $file)
    {
        // парсим файл подключения
        $settings = parse_ini_file($file, TRUE);
        // Создаем подключение к БД
        $dns = $settings['database']['driver'].':host=' . $settings['database']['host'].((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '').';dbname='.$settings['database']['schema'];
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
		$telegram = new Api($bootID);
		$this->saveToBase('Данные пользователя', print_r($data, true));
		$response = $telegram->sendMessage(['chat_id' => $chatID, 'text' => 'Hello World']);
		$this->saveToBase('ответ на посылку пользователю', print_r($response, true));
    }

	function saveToBase($name, $res)
    {
        $sql = "INSERT INTO log (name, text) VALUES ('$name','$res')";
        $query = $this->prepare($sql);
        $query->execute();
    }
}
?>