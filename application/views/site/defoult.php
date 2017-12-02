<div class="cell defoult">
	<div class="row">
		<div class="left_value">
			<?php echo anchor('site/select/'.$item->site_id, '<img src="/img/ico/site.png"/>'.$item->url); ?>
		</div>
		<div class="right_value <?php if($item->regions_count==0) echo 'red'; ?>">
			<?php echo $item->regions_count; ?>
		</div>
	</div>
</div>