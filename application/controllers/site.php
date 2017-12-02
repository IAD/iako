<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MY_Controller 
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
	
   public function index()
   {
		$this->response->sites=$this->MSite->get_all_with_regions_count();
   }

   public function select($site_id=NULL)
   {
		$site_id=max((int)$site_id,0);
		$site=$this->MSite->get_by_id($site_id);
		if ($site->is_empty())
		{
			$this->response->messages_error='Сайт не существует';
			redirect('site');
		}
		
      $this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();

		$this->response->regions=$this->MRegion->get_by_site_id($site_id);
   }
   
   public function add()
   {
		$this->response->sites=$this->MSite->get_all_with_regions_count();
		$this->response->site_add=true;
   }
 
	public function add_do()
	{
		if ($this->input->post('action',true))
		{
			$site=new object();
			$site->url=$this->input->post('site_url', true);
			if ($site->url)
			{
				$site_id=$this->MSite->add($site);
				$this->response->messages_ok='Сайт создан.';
				redirect('site/select/'.$site_id);
			}
			$this->response->messages_error='Сайт не создан, не все поля заполнены.';
		}
		$this->response->messages_error='Получены странные данные';
		redirect('site/add/');
	}

   public function delete($site_id=NULL)
   {
		$site_id=max((int)$site_id,0);
		$site=$this->MSite->get_by_id($site_id);
		if ($site->is_empty())
		{
			$this->response->messages_error='Сайт не существует';
			redirect('site');
		}
		
		
      $this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
		$this->response->sites[$site_id]->show_type='delete';
		
		$this->response->regions=$this->MRegion->get_by_site_id($site_id);
   }
   
	public function delete_do($site_id=NULL)
	{
		$site_id=max((int)$site_id,0);
		$site=$this->MSite->get_by_id($site_id);
		if ($site->is_empty())
		{
			$this->response->messages_error='Сайт не существует';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			if ($this->input->post('site_del_confirm', true)!='удалить')
			{
				$this->response->messages_error='Вы неверно ввели фразу "удалить". Сконцентрируйтесь и повторите вновь.';
				redirect('site/delete/'.$site_id);
			}
			
			$this->MSite->delete_by_id($site_id);
			$this->response->messages_ok='Сайт удалён.';
			redirect('site');
		}
		$this->response->messages_error='Получены странные данные';
		redirect('site/add/');
	}

   public function edit($site_id)
   {
		$site_id=max((int)$site_id,0);
		$site=$this->MSite->get_by_id($site_id);
		if ($site->is_empty())
		{
			$this->response->messages_error='Сайт не существует';
			redirect('site');
		}
		$sites=$this->MSite->get_all_with_regions_count();
		$sites[$site_id]->show_type='edit';
	
      $this->response->site_id=$site_id;
		$this->response->sites=$this->MSite->get_all_with_regions_count();
		$this->response->sites[$site_id]->show_type='edit';
				  
		$this->response->regions=$this->MRegion->get_by_site_id($site_id);
   }
 
	public function edit_do($site_id=NULL)
	{
		$site_id=max((int)$site_id,0);
		$site=$this->MSite->get_by_id($site_id);
		if ($site->is_empty())
		{
			$this->response->messages_error='Сайт не существует';
			redirect('site');
		}
		
		if ($this->input->post('action',true))
		{
			$site->url=$this->input->post('site_url', true);
			if ($site->url)
			{
				$this->MSite->edit($site);
				$this->response->messages_ok='Изменения сохранены';
				redirect('site/select/'.$site_id);
			}
			$this->response->messages_error='Введите url Вашего сайта. Например: site.ru';
			redirect('site/edit/'.$site_id);
		}
		$this->response->messages_error='Получены странные данные';
		redirect('site/add/');
	}
}

