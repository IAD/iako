<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Code extends MY_Controller 
{
	public function __construct() 
   {
		parent::__construct();
   }

	public function _before() 
	{
		parent::_before();
		$this->response->view='main/advs-codes-companyes-regions';
		$this->response->master_view='_master';
	}
   
	public function _after() 
	{
		$regions=$this->response->regions;
		
		//if (count($regions==0)) $regions=array();
		foreach ($regions as $region)
		{
			//$this->response->regions[$key]->show_type='link';
			$region->show_type='link';
		}
		parent::_after();
	}
	
	public function index()
   {
      redirect ('code');
   }
	//+~
   public function select($code_id=NULL)
   {
		$code_id=max((int)$code_id,0);
		
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не существует';
			redirect('adv');
		}
		
		$adv_id=$code->adv_id;

		$this->response->adv_id=$adv_id;
      $this->response->advs=$this->MAdvertise->get_all_with_codes_count();
		
		$this->response->code_id=$code_id;
      $this->response->codes=$this->MCode->get_by_adv_id($adv_id);

		$this->response->regions=$this->MRegion->get_by_size($code->size_x, $code->size_y);
		
		$this->response->companyes=$this->MCompany->get_by_code_id($code_id);
   }
	//+~
   public function add($adv_id=NULL)
   {
		$adv_id=max((int)$adv_id,0);
		$adv=$this->MAdvertise->get_by_id($adv_id);
		if ($adv->is_empty())
		{
			$this->response->messages_error='Площадка не задана';
			redirect('adv');
		}
			
		//Иначе выведется форма
		$this->response->adv_id=$adv_id;
      $this->response->advs=$this->MAdvertise->get_all_with_codes_count();
		
      $this->response->codes=$this->MCode->get_by_adv_id($adv_id);
 		$this->response->code_add=true;
  }
   
   public function add_do($adv_id=NULL)
	{
		$adv_id=max((int)$adv_id,0);
		
		$adv=$this->MAdvertise->get_by_id($adv_id);
		if ($adv->is_empty())
		{
			$this->response->messages_error='Площадка не задана';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			$code=new object();
			$code->adv_id=$adv_id;
			$code->comment=$this->input->post('comment', true);
			$code->code=$this->input->post('code');
			$code->size_x=max(intval($this->input->post('size_x', true)),0);
			$code->size_y=max(intval($this->input->post('size_y', true)),0);
			
			$code_id=$this->MCode->add($code);
			$this->response->messages_ok='Код создан';
			redirect('advs/code/select/'.$code_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('advs/code/add');
	}
	
	public function delete($code_id=NULL)
   {
		$code_id=max((int)$code_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('adv');
		}
		
		$adv_id=$code->adv_id;

		$this->response->adv_id=$adv_id;
      $this->response->advs=$this->MAdvertise->get_all_with_codes_count();
		
		$this->response->code_id=$code_id;
      $this->response->codes=$this->MCode->get_by_adv_id($adv_id);
		$this->response->codes[$code_id]->show_type='delete';

		$this->response->regions=$this->MRegion->get_by_size($code->size_x, $code->size_y);
   }
   
	public function delete_do($code_id=NULL)
	{
		$code_id=max((int)$code_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			if ($this->input->post('code_del_confirm', true)!='удалить')
			{
				$this->response->messages_error='Вы неверно ввели фразу "удалить". Сконцентрируйтесь и повторите вновь.';
				redirect('advs/code/delete/'.$code_id);
			}
			
			$adv_id=$code->adv_id;
			$this->MCode->delete_by_id($code_id);
			$this->response->messages_ok='Код удалён';
			redirect('adv/select/'.$adv_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('advs/code/delete/'.$code_id);
	}
	
   public function edit($code_id=NULL)
   {
		$code_id=max((int)$code_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('adv');
		}
		
		$adv_id=$code->adv_id;

		$this->response->adv_id=$adv_id;
      $this->response->advs=$this->MAdvertise->get_all_with_codes_count();
		
		$this->response->code_id=$code_id;
      $this->response->codes=$this->MCode->get_by_adv_id($adv_id);
		$this->response->codes[$code_id]->show_type='edit';
		
		$this->response->regions=$this->MRegion->get_by_size($code->size_x, $code->size_y);
   }
	
	public function edit_do($code_id=NULL)
	{
		$code_id=max((int)$code_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			$code->comment=$this->input->post('comment', true);
			$code->code=$this->input->post('code');
			$code->size_x=max(intval($this->input->post('size_x', true)),0);
			$code->size_y=max(intval($this->input->post('size_y', true)),0);

			$this->MCode->edit($code);
			$this->response->messages_ok='Код изменён';
			redirect('advs/code/select/'.$code_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('advs/code/delete/'.$code_id);
	}
	
	public function get_html($code_id)
	{
		$code_id=max((int)$code_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			echo 'Код не задан';
		}
		else
		{
			echo "<html><head></head><body><div>";
			echo $code->code;
			echo "</div></body></html>";
		}
		exit();
	}
}

