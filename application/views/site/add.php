<div class="cell add">
<?php
	echo form_open('site/add_do');
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="row left_value">
			Введите адрес сайта, например: site.ru
		</div>
	</div>
	<div class="row">
		<div class="row left_value">
			<?php echo form_input('site_url', $this->input->post('site_url',true)); ?>
		</div>
	</div>
	<div class="row">
		<div class="row_left_value">
<?php
	echo form_submit('site_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>