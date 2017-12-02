<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Codes_company extends MY_Controller 
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
      //не задан номер кампании
      redirect ('site');
   }
	
	public function link($region_id=NULL, $code_id=NULL)
	{
		$code_id=max((int)$code_id,0);
		$region_id=max((int)$region_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('adv');
		}
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('adv');
		}
		
		$adv_id=$code->adv_id;
		
		$this->response->adv_id=$adv_id;
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_size($region->size_x, $region->size_y);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_adv_id($adv_id);
		
		$this->response->companyes=$this->MCompany->get_by_code_id($code_id);
 		$this->response->company_add=true;
	}

   public function link_do($code_id=NULL, $region_id=NULL)
	{
		$code_id=max((int)$code_id,0);
		$region_id=max((int)$region_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('adv');
		}
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			$company=new object();
			$company->region_id=$region_id;
			$company->code_id=$code_id;
			$company->weight=max(intval($this->input->post('weight', true)),0);
			
			$company_id=$this->MCompany->add($company);
			$this->response->messages_ok='Кампания создана';
			redirect('adv/codes_company/select/'.$company_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('adv/codes_company/link/'.$code_id.'/'.$region_id);
	}
	
   public function select($company_id=NULL)
   {
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('adv');
		}
		
		$region_id=$company->region_id;
		$code_id=$company->code_id;
		$region=$this->MRegion->get_by_id($region_id);
		$code=$this->MCode->get_by_id($code_id);
		
		$adv_id=$code->adv_id;
		
		$this->response->adv_id=$adv_id;
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_size($region->size_x, $region->size_y);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_adv_id($adv_id);
		
		$this->response->companyes=$this->MCompany->get_by_code_id($code_id);
 		//$this->response->company_add=true;
   }

	public function delete($company_id=NULL)
   {
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('adv');
		}
		
		$region_id=$company->region_id;
		$code_id=$company->code_id;
		$region=$this->MRegion->get_by_id($region_id);
		$code=$this->MCode->get_by_id($code_id);
		
		$adv_id=$code->adv_id;
		
		$this->response->adv_id=$adv_id;
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_size($region->size_x, $region->size_y);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_adv_id($adv_id);
		
		$this->response->companyes=$this->MCompany->get_by_code_id($code_id);
 		$this->response->companyes[$company_id]->show_type='delete';
	}
   
	public function delete_do($company_id=NULL)
	{
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			if ($this->input->post('company_del_confirm', true)!='удалить')
			{
				$this->response->messages_error='Вы неверно ввели фразу "удалить". Сконцентрируйтесь и повторите вновь.';
				redirect('adv/codes_company/delete/'.$company_id);
			}
			
			$region_id=$company->region_id;
			$this->MCompany->delete_by_id($company_id);
			$this->response->messages_ok='Кампания удалёна';
			redirect('sites/region/select/'.$region_id);
		}
		$this->response->messages_error= 'Получены странные данные';
		redirect('adv/codes_company/delete/'.$company_id);
	}
	
   public function edit($company_id=NULL)
   {
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('adv');
		}
		
		$region_id=$company->region_id;
		$code_id=$company->code_id;
		$region=$this->MRegion->get_by_id($region_id);
		$code=$this->MCode->get_by_id($code_id);
		
		$adv_id=$code->adv_id;
		
		$this->response->adv_id=$adv_id;
		$this->response->advs=$this->MAdvertise->get_all_with_codes_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_size($region->size_x, $region->size_y);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_adv_id($adv_id);
		
		$this->response->companyes=$this->MCompany->get_by_code_id($code_id);
  		$this->response->companyes[$company_id]->show_type='edit';
  }
	
	public function edit_do($company_id=NULL)
	{
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		//var_dump($company);
		//echo "em>".$company->is_empty();
		//return;
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('adv');
		}

		$region_id=$company->region_id;
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('adv');
		}
		$code_id=$company->code_id;
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('adv');
		}
		
		if ($this->input->post('action',true))
		{
			$company->region_id=$region_id;
			$company->code_id=$code_id;
			$company->weight=max(intval($this->input->post('weight', true)),0);
			
			$this->MCompany->edit($company);
			
			$this->response->messages_ok='Кампания изменена';
			redirect('adv/codes_company/select/'.$company_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('adv/codes_company/edit/'.$company_id);
	}
}

