<div class="cell delete">
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/code.png"/>'.$item->comment; ?>
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
	<div class="row">
		<div class="left_value">
<?php
	echo form_open('advs/code/delete_do/'.$item->code_id);
	echo form_hidden('action', '1');
	echo "Напишите: удалить".form_input('code_del_confirm','');
?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('code_delete', 'Удалить код');
	echo form_close();
?>
		</div>
	</div>
</div>