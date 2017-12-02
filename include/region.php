<?php
	//Выдать блок рекламы
	//Проверим, запрошен ли блок
	if (isset($_GET['id']))
	{
		//Получим id, профильтруем на инъекцию
		$id=max((int)$_GET['id'],0);
		//id получен?
		if ($id>0)
		{
			//Файл существует
			$file='./'.$id.'.php';
			if (@file_exists($file) )
			{
				//Получим, что выводит код для php вызова
				ob_start();
				include_once ($file);
				$out=ob_get_contents();
				ob_end_clean();

				//Закодируем 
				$code=rawurlencode($out);
				
				//Отправим в браузер
				echo 'document.write(decodeURIComponent("'.$code.'"))';
			}
		}
	}
?>


