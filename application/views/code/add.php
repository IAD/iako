<div class="cell add">
<?php
	echo form_open('advs/code/add_do/'.$response->adv_id);
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			Введите комментарий, например: Жёлтый блок с красным текстом
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('comment', $this->input->post('comment',true)); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			Введите код. Возможно использование php вставок.
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php 
				$data = array(
					  'name'        => 'code',
					  'id'          => '',
					  'value'       => $this->input->post('code',true),
//					  'maxlength'   => '300',
//					  'size'        => '50',
					  'style'       => 'width:100%',
					);	
				echo form_textarea($data); 
			?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			Введите размер области кода, например 468*60 или 0*60 (0 означает резиновый блок по данному направлению)
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('size_x', $this->input->post('size_x',true)); ?>
			*
			<?php echo form_input('size_y', $this->input->post('size_y',true)); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('code_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>