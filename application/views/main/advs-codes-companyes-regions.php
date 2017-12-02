<?php
	//if (count($response->advs))
	//{
		echo '<div class="block sites"><div class="col_name">Рекламные площадки<br/>';
		echo anchor('adv/add', '<img src="/img/ico/adv.png"/>Добавить площадку');
		echo '</div>';
		$this->load->view('adv/list', array('items'=>$response->advs)); //, 'add'=>$response->add_site));
		echo '</div>';
	//}
	if (count($response->codes) || $response->adv_id)
	{
		echo '<div class="block codes"><div class="col_name">Рекламные коды площадок<br/>';
		echo anchor('advs/code/add/'.$response->adv_id, '<img src="/img/ico/code.png"/>Добавить рекламный код');
		echo '</div>';
		$this->load->view('code/list', array('items'=>$response->codes)); //, 'add'=>$response->add_code));
		echo '</div>';
	}
	if (count($response->companyes) || $response->code_id)
	{
		echo '<div class="block companyes"><div class="col_name">Кампании</div>';
		$this->load->view('company/list', array('items'=>$response->companyes)); //, 'add'=>$response->add_company));
		echo '</div>';
	}
	if (count($response->regions) && $response->code_id)
	{
		echo '<div class="block regions"><div class="col_name">Области сайтов</div>';
		$this->load->view('region/list', array('items'=>$response->regions)); //, 'add'=>$response->add_region, 'site_id'=>$response->region_id));
		echo '</div>';
	}
	if ($response->code_id==false && $response->adv_id==false && $response->adv_add)
	{
		echo '<div class="block adv_list"><div class="col_name">Картотека рекламодателей</div>';
		echo '<div class="adv_content" id="adv_content">';
		$this->load->view('ext_adv/list');
		echo '</div>';
		echo '</div>';
	}
	if ($response->code_id==false && $response->adv_id!=false)
	{
		echo '<div class="block adv_list"><div class="col_name">Справка</div>';
		echo '<div class="adv_content" id="adv_content">';
		$this->load->view('ext_adv/item');
		echo '</div>';
		echo '</div>';
	}
?>