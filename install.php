<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru-RU">
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	  <title></title>
	  <link rel="stylesheet" type="text/css" href="/css/style.css" />
	</head>
	<body>		
<h1>Спасибо за выбор iako</h1><br/>
<?php 
	//загрузка 	настроек
	include	($_SERVER['DOCUMENT_ROOT'].'/config.php');
	$ok=true;
	
	//1. Проверка записи в /include/
	echo "1. Проверка записи в /include/<br/>";
	$dir=$_SERVER['DOCUMENT_ROOT'].'/include/';
	if (is_writable($dir))
	{
		echo "ok<br/>";
	}
	else
	{
		echo "Выполните: sudo chmod -R 766 ".$dir.'<br/>';
		echo "Или права rwx/rw/rw на ".$dir.'<br/>';
		$ok=false;
	}
	
	if ($ok)
	{
		//2. Подключение к базе
		echo "2. Проверка подключения к СУБД Mysql, существование базы данных<br/>";
		$host=$db['default']['hostname'];
		$user=$db['default']['username'];
		$pwd=$db['default']['password'];
		$dbname=$db['default']['database'];

		try 
		{
			$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
			echo "ok<br/>"; // проверка соединения
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			$ok=false;
		}
	}
/*		
		if (!$db)
		{
			echo "Не доступен сервер MySQL. Проверьте, правильный ли адрес, логин и пароль в файле config.php<br/>";  
			$ok=false;
		}
		else
		{
			echo "Подключился<br/>";
		}

		if (mysql_select_db($dbname,$db))
		{
			echo "База существует<br/>";
		}
		else
		{
			echo "База ".$dbname.' не существует. Создайте.<br/>';
			$ok=false;
		}
	}
*/	
	if ($ok)
	{
	//3. Проверка таблиц, создание
	echo "3. Проверка существования таблиц, корректности структуры таблиц<br/>";
$sql='CREATE TABLE IF NOT EXISTS `advertisers` (
  `adv_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `codes` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `adv_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `code` text NOT NULL,
  `size_x` int(11) NOT NULL,
  `size_y` int(11) NOT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `companyes` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL,
  `code_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

CREATE TABLE IF NOT EXISTS `regions` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `code_id_defoult` int(11) DEFAULT NULL,
  `size_x` int(11) NOT NULL,
  `size_y` int(11) NOT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
';
		try 
		{
			$result = $db->query($sql);
			echo 'ok<br/>';
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			$ok=false;
		}
	}
	if ($ok)
	{
		echo 'Похоже всё ок. Удалите install.php, на всякий случай, и можете работать >> ';
		echo '<a href="/">'.$_SERVER["HTTP_HOST"].'</a>';
	}
	
?>
	</body>
</html>	
