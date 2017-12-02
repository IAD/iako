<div class="cell delete">
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/site.png"/>'.$item->url; ?>
		</div>
		<div class="right_value <?php if($item->regions_count==0) echo 'red'; ?>">
			<?php echo $item->regions_count; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_open('site/delete_do/'.$item->site_id);
	echo form_hidden('action', '1');
	echo "Напишите: удалить".form_input('site_del_confirm','');
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