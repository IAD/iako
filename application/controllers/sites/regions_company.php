<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regions_company extends MY_Controller 
{
	public function __construct() 
   {
		parent::__construct();
   }

	public function _before() 
	{
		parent::_before();
		$this->response->view='main/sites-regions-companyes-codes';
		$this->response->master_view='_master';
	}
 
	public function _after() 
	{
		$codes=$this->response->codes;
		if (count($codes)==0) $codes=array();
		foreach ($codes as $key=>$code)
		{
			if ($this->response->code_id!=$key)
			{
				$this->response->codes[$key]->show_type='link';
			}
		}
		parent::_after();
	}
	
	public function index()
   {
      //не задан номер кампании
      redirect ('site');
   }
	
	public function link($code_id=NULL, $region_id=NULL)
	{
		$code_id=max((int)$code_id,0);
		$region_id=max((int)$region_id,0);
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('site');
		}
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('site');
		}
		$site_id=$region->site_id;
		
		$this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_site_id($site_id);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_size($region->size_x, $region->size_y);
		
		$this->response->companyes=$this->MCompany->get_by_region_id($region_id);
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
			redirect('site');
		}
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			$company=new object();
			$company->region_id=$region_id;
			$company->code_id=$code_id;
			$company->weight=max(intval($this->input->post('weight', true)),0);
			
			$company_id=$this->MCompany->add($company);
			$this->response->messages_ok='Кампания создана';
			redirect('sites/regions_company/select/'.$company_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('sites/regions_company/link/'.$code_id.'/'.$region_id);
	}
	
   public function select($company_id=NULL)
   {
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('site');
		}
		
		$region_id=$company->region_id;
		$code_id=$company->code_id;
		$region=$this->MRegion->get_by_id($region_id);
		
		$site_id=$region->site_id;
		
		$this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_site_id($site_id);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_size($region->size_x, $region->size_y);
		
		$this->response->company_id=$company_id;
		$this->response->companyes=$this->MCompany->get_by_region_id($region_id);
   }

	public function delete($company_id=NULL)
   {
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('site');
		}
		
		$region_id=$company->region_id;
		$code_id=$company->code_id;
		$region=$this->MRegion->get_by_id($region_id);
		
		$site_id=$region->site_id;
		
		$this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_site_id($site_id);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_size($region->size_x, $region->size_y);
		
		$this->response->company_id=$company_id;
		$this->response->companyes=$this->MCompany->get_by_region_id($region_id);
 		$this->response->companyes[$company_id]->show_type='delete';
	}
   
	public function delete_do($company_id=NULL)
	{
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			if ($this->input->post('company_del_confirm', true)!='удалить')
			{
				$this->response->messages_error='Вы неверно ввели фразу "удалить". Сконцентрируйтесь и повторите вновь.';
				redirect('sites/regions_company/delete/'.$company_id);
			}
			
			$region_id=$company->region_id;
			$this->MCompany->delete_by_id($company_id);
			$this->response->messages_ok='Кампания удалёна';
			redirect('sites/region/select/'.$region_id);
		}
		$this->response->messages_error= 'Получены странные данные';
		redirect('sites/regions_company/delete/'.$company_id);
	}
	
   public function edit($company_id=NULL)
   {
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('site');
		}
		
		$region_id=$company->region_id;
		$code_id=$company->code_id;
		$region=$this->MRegion->get_by_id($region_id);
		
		$site_id=$region->site_id;
		
		$this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_site_id($site_id);
		
		$this->response->code_id=$code_id;
		$this->response->codes=$this->MCode->get_by_size($region->size_x, $region->size_y);
		
		$this->response->company_id=$company_id;
		$this->response->companyes=$this->MCompany->get_by_region_id($region_id);
 		$this->response->companyes[$company_id]->show_type='edit';
  }
	
	public function edit_do($company_id=NULL)
	{
		$company_id=max((int)$company_id,0);
		$company=$this->MCompany->get_by_id($company_id);
		if ($company->is_empty())
		{
			$this->response->messages_error='Компания не существует';
			redirect('site');
		}

		$region_id=$company->region_id;
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('site');
		}
		$code_id=$company->code_id;
		$code=$this->MCode->get_by_id($code_id);
		if ($code->is_empty())
		{
			$this->response->messages_error='Код не задан';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			$company->region_id=$region_id;
			$company->code_id=$code_id;
			$company->weight=max(intval($this->input->post('weight', true)),0);
			
			$this->MCompany->edit($company);
			
			$this->response->messages_ok='Кампания изменена';
			redirect('sites/regions_company/select/'.$company_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('sites/regions_company/edit/'.$company_id);
	}
}

