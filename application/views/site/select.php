<div class="cell select">
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/site.png"/>'.$item->url; ?>
		</div>
		<div class="right_value <?php if($item->regions_count==0) echo 'red'; ?>">
			<?php echo $item->regions_count; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value buttons">
<?php
	echo anchor('site/edit/'.$item->site_id, '<img src="/img/ico/edit.png"/>'.'E');
	echo anchor('site/delete/'.$item->site_id, '<img src="/img/ico/del.png"/>'.'D');
?>
		</div>
	</div>
</div>

