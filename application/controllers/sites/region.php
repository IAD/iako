<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region extends MY_Controller 
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
			$this->response->codes[$key]->show_type='link';
		}
		parent::_after();
	}
	
	public function index()
   {
      //не задан номер сайта
      redirect ('site');
   }
	//+~
   public function select($region_id=NULL)
   {
		$region_id=max((int)$region_id,0);
		
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не существует';
			redirect('site');
		}
		
		$site_id=$region->site_id;
		
		$this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
				  
		$this->response->region_id=$region_id;
      $this->response->regions=$this->MRegion->get_by_site_id($site_id);
		
		$this->response->codes=$this->MCode->get_by_size($region->size_x, $region->size_y);
		$this->response->companyes=$this->MCompany->get_by_region_id($region_id);

   }
	//+~
   public function add($site_id=NULL)
   {
		$site_id=max((int)$site_id,0);
		$site=$this->MSite->get_by_id($site_id);
		if ($site->is_empty())
		{
			$this->response->messages_error='Сайт не задан';
			redirect('site');
		}
			
		//Иначе выведется форма
		$this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
				  
      $this->response->regions=$this->MRegion->get_by_site_id($site_id);
 		$this->response->region_add=true;
  }
   
   public function add_do($site_id=NULL)
	{
		$site_id=max((int)$site_id,0);
		
		$site=$this->MSite->get_by_id($site_id);
		if ($site->is_empty())
		{
			$this->response->messages_error='Сайт не задан';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			$region=new object();
			$region->site_id=$site_id;
			$region->comment=$this->input->post('comment', true);
			$region->size_x=max(intval($this->input->post('size_x', true)),0);
			$region->size_y=max(intval($this->input->post('size_y', true)),0);
			
			$region_id=$this->MRegion->add($region);
			$this->response->messages_ok='Область создана';
			redirect('sites/region/select/'.$region_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('sites/region/add');
	}
	
	public function delete($region_id=NULL)
   {
		$region_id=max((int)$region_id,0);
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
		$this->response->regions[$region_id]->show_type='delete';
		
		$this->response->codes=$this->MCode->get_by_size($region->size_x, $region->size_y);
		$this->response->companyes=$this->MCompany->get_by_region_id($region_id);
	}
   
	public function delete_do($region_id=NULL)
	{
		$region_id=max((int)$region_id,0);
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			if ($this->input->post('region_del_confirm', true)!='удалить')
			{
				$this->response->messages_error='Вы неверно ввели фразу "удалить". Сконцентрируйтесь и повторите вновь.';
				redirect('sites/region/delete/'.$region_id);
			}
			
			$site_id=$region->site_id;
			$this->MRegion->delete_by_id($region_id);
			$this->response->messages_ok='Область удалёна';
			redirect('site/select/'.$site_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('sites/region/delete/'.$region_id);
	}
	
   public function edit($region_id=NULL)
   {
		$region_id=max((int)$region_id,0);
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
		$this->response->regions[$region_id]->show_type='edit';
		
		$this->response->codes=$this->MCode->get_by_size($region->size_x, $region->size_y);
		$this->response->companyes=$this->MCompany->get_by_region_id($region_id);
   }
	
	public function edit_do($region_id=NULL)
	{
		$region_id=max((int)$region_id,0);
		$region=$this->MRegion->get_by_id($region_id);
		if ($region->is_empty())
		{
			$this->response->messages_error='Область не задана';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			$region->comment=$this->input->post('comment', true);
			$region->size_x=max(intval($this->input->post('size_x', true)),0);
			$region->size_y=max(intval($this->input->post('size_y', true)),0);

			$this->MRegion->edit($region);
			$this->response->messages_ok='Область изменёна';
			redirect('sites/region/select/'.$region_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('sites/region/delete/'.$region_id);
	}
}

