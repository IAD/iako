<div class="cell select">
	<div class="row">
		<div class="left_value">
			<?php
				//$item->advertise()->name.'<br/>'.
				echo '<img src="/img/ico/code.png"/>'.$item->comment; 
				?>
		</div>
		<div class="right_value">
				<a href="#" onclick='window.open("http://<?php echo $_SERVER['SERVER_NAME']; ?>/advs/code/get_html/<?php echo $item->code_id; ?>", "<?php echo $item->comment; ?>", "width=500, height=200")'>Просмотр</a>
			<?//php echo $item->companyes_count; ?>
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
	<?php
		if ($response->adv_id)
		{
	?>
	<div class="row">
		<div class="left_value buttons">
<?php
	echo anchor('advs/code/edit/'.$item->code_id, '<img src="/img/ico/edit.png"/>'.'E');
	echo anchor('advs/code/delete/'.$item->code_id, '<img src="/img/ico/del.png"/>'.'D');
?>
		</div>
	</div>
	<?php
		}
	?>
</div>
