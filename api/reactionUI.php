<?php
require 'vendor/autoload.php';
use Telegram\Bot\Api;
$telegram = new Api('417445048:AAFx37CoDNNItBN0NHL3xj5TaBXNSNXqzgM');
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
	public function __construct($file = 'my_setting.ini')
    {
        // парсим файл подключения
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable11 to open ' . $file . '.');
        // Создаем подключение к БД
        $dns = $settings['database']['driver'].':host=' . $settings['database']['host'].((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '').';dbname='.$settings['database']['schema'];
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
		$this->saveToBase("77777777777777777");
    }

	function saveToBase($res)
    {
        $sql = "INSERT INTO log (text) VALUES ('$res')";
        $query = $this->prepare($sql);
        $query->execute();
    }
}
?>