<div class="cell select">
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/adv.png"/>'.$item->name; ?>
		</div>
		<div class="right_value <?php if ($item->codes_count==0) echo 'red'; ?>">
			<?php echo $item->codes_count; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value buttons">
<?php
	echo anchor('adv/edit/'.$item->adv_id, '<img src="/img/ico/edit.png"/>'.'E');
	echo anchor('adv/delete/'.$item->adv_id, '<img src="/img/ico/del.png"/>'.'D');
?>
		</div>
	</div>
</div>

