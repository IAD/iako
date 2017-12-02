<div class="cell add">
<?php
	echo form_open('sites/region/add_do/'.$response->site_id);
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			Введите комментарий, например: верхний резиновый блок под меню
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('comment', $this->input->post('comment',true)); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			Введите размер области, например 468*60 или 0*60 (0 означает резиновый блок по данному направлению)
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('size_x', $this->input->post('size_x',true)); ?>
			*
			<?php echo form_input('size_y', $this->input->post('size_y',true)); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('site_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>