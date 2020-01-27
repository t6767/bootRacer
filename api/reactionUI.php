<?php
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
    }

	function saveToBase($res)
    {
        $sql = "INSERT INTO test (text) VALUES ('$res')";
        $query = $this->prepare($sql);
        $query->execute();
    }
}
?>