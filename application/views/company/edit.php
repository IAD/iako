<div class="cell edit">
<?php
	echo form_open('sites/regions_company/edit_do/'.$item->company_id);
	echo form_hidden('action', '1');
?>
	<div class="row">
		<div class="left_value">
			Показ блока 
			<?php 
				if (isset($response->codes[$item->code_id]))	$code=$response->codes[$item->code_id]; else	$code=$this->MCode->get_by_id($item->code_id);
				if (isset($response->advs[$code->adv_id])) $adv=$response->advs[$code->adv_id]; else $adv=$this->MAdvertise->get_by_id($code->adv_id);
				if (isset($response->regions[$item->region_id])) $region=$response->regions[$item->region_id]; else $region=$this->MRegion->get_by_id($item->region_id);
				if (isset($response->sites[$region->site_id])) $site=$response->sites[$region->site_id]; else $site=$this->MSite->get_by_id($region->site_id);
			?>
		</div>
	</div>
	<div class="row">
		<div class="left_value.top">
			<?php echo '<img src="/img/ico/adv.png"/>'.$adv->name; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/code.png"/>'.$code->comment; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value.top">
			<?php echo '<img src="/img/ico/site.png"/>'.$site->url; ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo '<img src="/img/ico/region.png"/>'.$region->comment; ?>
		</div>
	</div>

	<div class="row">
		<div class="left_value">
			Сколько раз показывать(в ротации) 0-100
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo form_input('weight', $item->weight); ?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
<?php
	echo form_submit('region_edit', 'Сохранить изменения');
	echo form_close();
?>
		</div>
	</div>
</div>
	