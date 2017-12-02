<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    function __construct()
    {
        parent::__construct();
    }
	
	public function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			//До выполнения команды
			$this->_before();
			//Выполнение команды
			call_user_func_array(array($this, $method), $params);
			//$this->{$method}($params);
			//После выполнения команды
			$this->_after();
		}
		else
		{
			$this->_method_not_found();
		}
	}	
	
	protected function _before()
	{
		//Общие для всех
		//$this->output->enable_profiler(TRUE);
		session_start(); 
		
		//Проверим авторизацию
		if ($this->MAuth->auth()==false && $this->router->fetch_class()!='login')
		{
			redirect('login');
		}
		
		//дефолтовая view
		$this->response->view=$this->router->fetch_directory().'/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
		//$this->response->master_view=$this->router->fetch_directory().$this->router->fetch_class().'/_master';
		$this->response->master_view='_master';
		
		$this->response->menu[]=array('url'=>'', 'text'=>'Домой');
		$this->response->menu[]=array('url'=>'site', 'text'=>'Сайты');
		$this->response->menu[]=array('url'=>'adv', 'text'=>'Рекламодатели');
	}
	
	protected function _after()
	{
		$data=array();
		$data['response']=$this->response;
		$this->load->vars($data);
		$this->load->view($this->response->master_view);
	}
	
	protected function _method_not_found()
	{
		show_404();
	}
	
	
}

?>