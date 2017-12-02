<div class="cell delete">
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/adv.png"/>'.$item->name; ?>
		</div>
		<div class="right_value <?php if ($item->codes_count==0) echo 'red'; ?>">
			<?php echo $item->codes_count; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_open('adv/delete_do/'.$item->adv_id);
	echo form_hidden('action', '1');
	echo "Напишите: удалить".form_input('adv_del_confirm','');
?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('site_edit', 'Удалить сайт');
	echo form_close();
?>
		</div>
	</div>
</div>