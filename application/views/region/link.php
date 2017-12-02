<div class="cell link">
	<div class="row">
		<div class="left_value">
			<?php 
			if ($response->site_id) 
			{
				echo anchor('sites/regions_company/link/'.$item->code_id.'/'.$response->region_id, '<img src="/img/ico/site.png"/>'.$item->advertise()->name);
				echo '<br/>';
				echo anchor('sites/regions_company/link/'.$item->code_id.'/'.$response->region_id, '<img src="/img/ico/region.png"/>'.$item->comment);
			}
			?>
			<?php 
			if ($response->adv_id)
			{
				echo anchor('advs/codes_company/link/'.$item->region_id.'/'.$response->code_id, '<img src="/img/ico/adv.png"/>'.$item->site()->url); 
				echo '<br/>';
				echo anchor('advs/codes_company/link/'.$item->region_id.'/'.$response->code_id, '<img src="/img/ico/code.png"/>'.$item->comment); 
			}
			?>
		</div>
		<div class="right_value <?php if ($item->companyes_count==0) echo 'red'; ?>">
			<?php echo $item->companyes_count; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php 
			echo "Размер (длина*высота): ";
			if ($item->size_x) echo $item->size_x; else echo "&infin;";
			echo "*";
			if ($item->size_y) echo $item->size_y; else echo "&infin;";
			?>
		</div>
	</div>
</div>
