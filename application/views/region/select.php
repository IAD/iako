<div class="cell select">
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/region.png"/>'.$item->comment; ?>
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
		<div class="cell_row_left_value">
			Разместите следующий код вызова рекламного блока на вашем сайте:<br/><br/>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			PHP
			<textarea readonly="yes" cols="90" rows="5"><?php echo '<?php @include_once("'.$_SERVER["DOCUMENT_ROOT"].'/include/'.$item->region_id.'.php"); ?>'; ?></textarea>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			Java Script
			<textarea readonly="yes" cols="90" rows="5"><?php echo '<script language="JavaScript" src="http://'.$_SERVER['SERVER_NAME'].'/include/region.php/?id='.$item->region_id.'"></script>'; ?></textarea>
		</div>
	</div>
	<?php
		if ($response->site_id)
		{
	?>

	<div class="row">
		<div class="left_value buttons">
<?php
	echo anchor('sites/region/edit/'.$item->region_id, '<img src="/img/ico/edit.png"/>'.'E');
	echo anchor('sites/region/delete/'.$item->region_id, '<img src="/img/ico/del.png"/>'.'D');
?>
		</div>
	</div>
	<?php
		}
	?>
</div>
