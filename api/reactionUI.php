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
	public $telegram;
	public $messageID;
	public $chatID;
	public $userID;
	public $userName;
	public $messageDate;
	public $message;
	// Создадим конструктор ебаный Лего
	public function __construct($bootID, $data, $file)
    {
		// Блок переменных объявляем их глобальными
		$this->messageID=$data['message']['message_id'];
		$this->userID=$data['message']['from']['id'];
		$this->userName=$data['message']['from']['first_name'];
		$this->messageDate=date("Y-m-d H:i:s", $data['message']['date']);
		$this->message=$data['message']['text'];
		$this->chatID=$data['message']['chat']['id'];
        $this->telegram = new Api($bootID);
		
		// парсим файл подключения
        $settings = parse_ini_file($file, TRUE);
        // Создаем подключение к БД
        $dns = $settings['database']['driver'].':host=' . $settings['database']['host'].((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '').';dbname='.$settings['database']['schema'].';charset=utf8';
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
		
		// Обработка
		$this->sendMSG($this->userName.'привет!!!');
		$this->saveToBase('Данные пользователя', print_r($data, true));
    }

	public function sendMSG($msg)
	{
		return $this->telegram->sendMessage(['chat_id' => $this->chatID, 'text' => $msg]);
	}
	public function saveToBase($name, $res)
    {
        $sql = "INSERT INTO log (name, text) VALUES ('$name','$res')";
        $query = $this->prepare($sql);
        $query->execute();
    }
}
?>