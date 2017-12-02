<div class="cell add">
<?php
	echo form_open('adv/add_do');
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			Введите название площадки, например: adsence.google.com
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php 
				$data = array(
					  'name'        => 'adv_name',
					  'id'          => 'adv_name',
					  'value'       => $this->input->post('adv_name',true),
					 // 'maxlength'   => '100%',
					  'style'       => 'width:100%',
					);	
				echo form_input($data); 
			?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('adv_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>