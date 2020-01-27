<?php
require 'vendor/autoload.php';
use Telegram\Bot\Api;

class reactionUI extends PDO
{
	public $telegram;
	public $messageID;
	public $chatID;
	public $userID;
	public $userName;
	public $messageDate;
	public $message;
	public $keyboard;
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
		
		$this->keyboard = [["Последние статьи"],["Картинка"],["Гифка"]];
		// парсим файл подключения
        $settings = parse_ini_file($file, TRUE);
        // Создаем подключение к БД
        $dns = $settings['database']['driver'].':host=' . $settings['database']['host'].((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '').';dbname='.$settings['database']['schema'].';charset=utf8';
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
		
		// Обработка сообщений
		$this->saveToBase('Данные пользователя', print_r($this->message, true)); 
		$this->senderIO($this->message);
    }

	/** Telegram **/
	
	public function senderIO($msg)
	{
		switch($msg)
		{
			case "start" :
                $reply = "Добро пожаловать в бота!";
                $reply_markup = $this->telegram->replyKeyboardMarkup([ 'keyboard' => $this->keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
                $this->sendMSGRepl($reply, $reply_markup);
				break;
            case "Картинка":
                $this->sendPic("http://battlefield-t67.9oweb.kz/static/img/general/entry_img.png", "Описание. Пиздатая картинка");
                break;
            case "Гифка":
                $this->sendDoc("https://i.gifer.com/fyDA.gif", "описалово");
                break;
            case "Последние статьи":
                $reply="";
                $html=simplexml_load_file('http://netology.ru/blog/rss.xml');
                foreach ($html->channel->item as $item) {
                    $reply .= "\xE2\x9E\xA1 ".$item->title." (<a href='".$item->link."'>читать</a>)\n";
                }
                $this->telegram->sendMessage([ 'chat_id' => $this->chatID, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $reply ]);
                break;
			default:
                {
				$this->sendMSG($this->userName.' привет!!!');
				}
		}
	}

	public function sendMSG($msg)
	{
		return $this->telegram->sendMessage(['chat_id' => $this->chatID, 'text' => $msg, 'reply_markup'=>null]);
	}

    public function sendMSGRepl($msg, $reply_markup)
    {
        return $this->telegram->sendMessage(['chat_id' => $this->chatID, 'text' => $msg, 'reply_markup'=>$reply_markup]);
    }

    public function sendPic($url, $desc)
    {
        $this->telegram->sendPhoto([ 'chat_id' => $this->chatID, 'photo' => $url, 'caption' => $desc ]);
    }

    public function sendDoc($url, $desc)
    {
        $this->telegram->sendDocument([ 'chat_id' => $this->chatID, 'document' => $url, 'caption' => $desc ]);
    }
	
	/** Базы данных **/
	
	public function saveToBase($name, $res)
    {
        $sql = "INSERT INTO log (name, text) VALUES ('$name','$res')";
        $query = $this->prepare($sql);
        $query->execute();
    }
}
?>