<div class="cell defoult">
	<div class="row">
		<div class="left_value">
			<?php echo anchor('adv/select/'.$item->adv_id, '<img src="/img/ico/adv.png"/>'.$item->name); ?>
		</div>
		<div class="right_value <?php if ($item->codes_count==0) echo 'red'; ?>">
			<?php echo $item->codes_count; ?>
		</div>
	</div>
</div>