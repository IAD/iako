<div class="cell edit">
<?php
	echo form_open('adv/edit_do/'.$item->adv_id);
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('adv_name', $item->name); ?>
		</div>
		<div class="right_value <?php if ($item->codes_count==0) echo 'red'; ?>">
			<?php echo $item->codes_count; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('adv_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>
