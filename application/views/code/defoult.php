<div class="cell defoult">
	<div class="row">
		<div class="left_value">
			<?php 
				
				echo anchor('advs/code/select/'.$item->code_id, '<img src="/img/ico/code.png"/>'.$item->comment); ?>
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
