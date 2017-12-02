<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adv extends MY_Controller 
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
   
	public function index()
   {
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
   }

   public function select($adv_id=NULL)
   {
		$adv_id=max((int)$adv_id,0);
		$adv=$this->MAdvertise->get_by_id($adv_id);
		if ($adv->is_empty())
		{
			$this->response->messages_error='Рекламная площадка не существует';
			redirect('adv');
		}
		
      $this->response->adv_id=$adv_id;
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
      
		$this->response->codes=$this->MCode->get_by_adv_id($adv_id);
   }
   
   public function add()
   {
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
		$this->response->adv_add=true;
   }
 
	public function add_do()
	{
		if ($this->input->post('action',true))
		{
			$adv=new object();
			$adv->name=$this->input->post('adv_name', true);
			if ($adv->name)
			{
				$adv_id=$this->MAdvertise->add($adv);
				$this->response->messages_ok='Рекламная площадка создана';
				redirect('adv/select/'.$adv_id);
			}
			$this->response->messages_error='Не заполнено название';
		}
		$this->response->messages_error='Получены странные данные';
		redirect('adv/add/');
	}

   public function delete($adv_id=NULL)
   {
		$adv_id=max((int)$adv_id,0);
		$adv=$this->MAdvertise->get_by_id($adv_id);
		if ($adv->is_empty())
		{
			$this->response->messages_error='Рекламная площадка не существует';
			redirect('adv');
		}
		
      $this->response->adv_id=$adv_id;
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
		$this->response->advs[$adv_id]->show_type='delete';
      
		$this->response->codes=$this->MCode->get_by_adv_id($adv_id);
   }
   
	public function delete_do($adv_id=NULL)
	{
		$adv_id=max((int)$adv_id,0);
		$adv=$this->MAdvertise->get_by_id($adv_id);
		if ($adv->is_empty())
		{
			$this->response->messages_error='Рекламная площадка не существует';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			if ($this->input->post('adv_del_confirm', true)!='удалить')
			{
				$this->response->messages_error='Вы неверно ввели фразу "удалить". Сконцентрируйтесь и повторите вновь.';
				redirect('adv/delete/'.$adv_id);
			}
			
			$this->MAdvertise->delete_by_id($adv_id);
			$this->response->messages_ok='Площадка удалёна';
			redirect('adv');
		}
		$this->response->messages_error='Получены странные данные';
		redirect('adv/delete/'.$adv_id);
	}

   public function edit($adv_id)
   {
		$adv_id=max((int)$adv_id,0);
		$adv=$this->MAdvertise->get_by_id($adv_id);
		if ($adv->is_empty())
		{
			$this->response->messages_error='Рекламная площадка не существует';
			redirect('adv');
		}
		
      $this->response->adv_id=$adv_id;
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
		$this->response->advs[$adv_id]->show_type='edit';
      
		$this->response->codes=$this->MCode->get_by_adv_id($adv_id);
   }
 
	public function edit_do($adv_id=NULL)
	{
		$adv_id=max((int)$adv_id,0);
		$adv=$this->MAdvertise->get_by_id($adv_id);
		if ($adv->is_empty())
		{
			$this->response->messages_error='Рекламная площадка не существует';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			$adv->name=$this->input->post('adv_name', true);
			if ($adv->name)
			{
				$this->MAdvertise->edit($adv);
				$this->response->messages_ok='Изменения сохранены';
				redirect('adv/select/'.$adv_id);
			}
			$this->response->messages_error='Введите название площадки. Например: adsense.google.com';
			redirect('adv/edit/'.$adv_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('adv/add/');
	}
}

