<?php
//Сообщения о успехах
if ($this->session->flashdata('messages_ok'))
	{
		foreach ($this->session->flashdata('messages_ok') as $message)
		{
			echo "<div class='message_ok'>";
			echo $message."\n";
			echo "</div>";
		}
	}
	
//неудачи
if ($this->session->flashdata('messages_error'))
	{
		foreach ($this->session->flashdata('messages_error') as $message)
		{
			echo "<div class='message_error'>";
			echo $message."\n";
			echo "</div>";
		}
	}
		
?>		
