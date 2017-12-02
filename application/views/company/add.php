<div class="cell add">
<?php
	echo form_open('sites/regions_company/link_do/'.$response->code_id.'/'.$response->region_id);
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			<img src="/img/ico/company.png"/>Показ блока 
			<?php 
				if (isset($response->codes[$response->code_id]))	$code=$response->codes[$response->code_id]; else	$code=$this->MCode->get_by_id($response->code_id);
				if (isset($response->advs[$response->adv_id])) $adv=$response->advs[$response->adv_id]; else $adv=$this->MAdvertise->get_by_id($code->adv_id);
				if (isset($response->regions[$response->region_id])) $region=$response->regions[$response->region_id]; else $region=$this->MRegion->get_by_id($response->region_id);
				if (isset($response->sites[$response->site_id])) $site=$response->sites[$response->site_id]; else $site=$this->MSite->get_by_id($region->site_id);
			?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/adv.png"/>'.$adv->name.'<br/>'.'<img src="/img/ico/code.png"/>'.$code->comment; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/site.png"/>'.$site->url.'<br/>'.'<img src="/img/ico/region.png"/>'.$region->comment; ?>
		</div>
	</div>
	<div class="row">
		<div class="cell_row_left_value">
			Сколько раз показывать(в ротации) 0-100
		</div>
	</div>
	<div class="row">
		<div class="cell_row_left_value">
			<?php echo form_input('weight', $this->input->post('weight',true)); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('company_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>
