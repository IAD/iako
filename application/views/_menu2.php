<div>
<?php 
	echo anchor('', 'Домой');
	if ($response->adv_id)
	{
		echo " / ";
		echo anchor('adv/select/'.$response->adv_id, 'Площадка'); 
	}
	if ($response->code_id)
	{
		echo " / ";
		echo anchor('advs/code/select/'.$response->code_id, 'Код'); 
	}
?>
</div>
