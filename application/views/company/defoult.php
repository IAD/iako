<div class="cell defoult">
	<div class="row">
		<div class="left_value">
			<?php 
				echo anchor('sites/regions_company/select/'.$item->company_id, '<img src="/img/ico/company.png"/>'.'Выбрать');
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
		<div class="left_value.top">
			<?php 
				$size_x=$code->size_x;
				$size_y=$code->size_y;
				if ($size_x) echo $size_x;	else echo "&infin;";
				echo "*";
				if ($size_y) echo $size_y; else echo "&infin;";
			?>
		</div>
	</div>
	<div class="row">
		<div class="left_value">
			<?php echo 'Доля показов: '.$item->weight; ?>
		</div>
	</div>
</div>
