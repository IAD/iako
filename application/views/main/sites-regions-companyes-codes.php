<?php
		echo '<div class="block sites">';
		echo '<div class="col_name">Сайты<br/>';
		echo anchor('site/add', '<img src="/img/ico/site.png"/>Добавить сайт');
		echo '</div>';
		
		$this->load->view('site/list', array('items'=>$response->sites)); //, 'add'=>$response->add_site));
		echo '</div>';
	//}
	if (count($response->regions) || $response->site_id)
	{
		echo '<div class="block regions"><div class="col_name">Области сайта<br/>';
		echo anchor('sites/region/add/'.$response->site_id, '<img src="/img/ico/region.png"/>Добавить область сайта');
		echo '</div>';
		$this->load->view('region/list', array('items'=>$response->regions)); //, 'add'=>$response->add_region, 'site_id'=>$response->region_id));
		echo '</div>';
	}
	if (count($response->companyes) || $response->region_id)
	{
		echo '<div class="block companyes"><div class="col_name">Кампании</div>';
		$this->load->view('company/list', array('items'=>$response->companyes)); //, 'add'=>$response->add_company));
		echo '</div>';
	}
	if (count($response->codes) || $response->region_id)
	{
		echo '<div class="block codes"><div class="col_name">Рекламные коды площадок<br/>';
		echo (count($response->codes))?"":"<b>Нет подходящих рекламных кодов</b>";
		echo '</div>';
		$this->load->view('code/list', array('items'=>$response->codes)); //, 'add'=>$response->add_code));
		echo '</div>';		
	}
?>