<div class="cell edit">
<?php
	echo form_open('advs/code/edit_do/'.$response->code_id);
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			Введите комментарий, например: Жёлтый блок с красным текстом
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('comment', $item->comment); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			Введите код. Возможно использование php вставок.
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<textarea name='code' cols="90" rows="5"><?php echo $item->code; ?></textarea>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			Введите размер области, например 468*60 или 0*60 (0 означает резиновый блок по данному направлению)
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('size_x', $item->size_x); ?>
			*
			<?php echo form_input('size_y', $item->size_y); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('code_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>