<div class="cell edit">
<?php
	echo form_open('site/edit_do/'.$item->site_id);
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('site_url', $item->url); ?>
		</div>
		<div class="right_value <?php if ($item->regions_count==0) echo 'red'; ?>">
			<?php echo $item->regions_count; ?>
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
