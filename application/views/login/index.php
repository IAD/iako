<?php
	echo form_open('/');
	echo form_label('Пароль');
	echo form_password('pwd');
	echo form_submit('login', 'Войти');
?>