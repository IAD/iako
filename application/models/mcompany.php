<?php

class MCompany extends CI_Model
{
	var $table='companyes';
	var $ret_data_type='t_company';
	
   function __construct()
   {
      parent::__construct();
   }
	
	/**
	 * @return t_company[]
	 */
	function get_all()
	{
      $items=array();
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['company_id']]=new $this->ret_data_type ($item);
		}
		
		return ($items);
	}
	
	/**
	 * @return t_company[]
	 */
	function get_by_region_id($region_id)
	{
		$items=array();
		$this->db->where('region_id', $region_id);
//		$this->db->order_by('region_id');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['company_id']]=new $this->ret_data_type ($item);
		}
		return ($items);
		
	}
	
	/**
	 * @return t_company[]
	 */
	function get_by_code_id($code_id)
	{
		$items=array();
		$this->db->where('code_id', $code_id);
//		$this->db->order_by('region_id');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['company_id']]=new $this->ret_data_type ($item);
		}
		return ($items);
		
	}
	
	/**
	 * @return t_company
	 */
	function get_by_id($id)
	{
		$item=new $this->ret_data_type();
		$this->db->where('company_id', $id);
		$query=$this->db->get($this->table);
		foreach ($query->result_array() as $item)
		{
			return(new $this->ret_data_type ($item));
		}
		return ($item);
	}
	
	/**
	 * @return int
	 */
	function add($item)
	{
		$this->db->set('region_id',$item->region_id);
		$this->db->set('code_id',$item->code_id);
		$this->db->set('weight',$item->weight);
		$this->db->insert($this->table);
		//Проинформируем регион о изменении кампании
		$this->MRegion->change_event();
		return ($this->db->insert_id());
	}
	
	function delete_by_id($id)
	{
		$this->db->where('company_id', $id);
		$this->db->delete($this->table);
		$this->MRegion->change_event();
	}
	
	function delete_by_region_id($region_id)
	{
		$this->db->where('region_id', $region_id);
		$this->db->delete($this->table);
		$this->MRegion->change_event();
	}
	
	function delete_by_code_id($code_id)
	{
		$this->db->where('code_id', $code_id);
		$this->db->delete($this->table);
		$this->MRegion->change_event();
	}
	
	function edit($item)
	{
		$this->db->where('company_id', $item->company_id);
		$this->db->set('region_id',$item->region_id);
		$this->db->set('code_id',$item->code_id);
		$this->db->set('weight',$item->weight);
		$this->db->update($this->table);
		$this->MRegion->change_event();
	}	
}


/**
* @property int $company_id
* @property int $region_id
* @property int $code_id
* @property int $weight
*/

class t_company extends object
{
	private $_code;
	private $_code_loaded=false;
	private $_region;
	private $_region_loaded=false;

	/**
	 * @return t_code
	 */
	public function code()
	{
		$this->load_code();
		return $this->_code;
	}
	
	public function load_code()
	{
		//Если не загружены, загрузим. Перезагрузки нет
		if ($this->_code_loaded==false)
		{
			$CI= & get_instance();	/* @var $CI CI_Model */
			$code=$CI->MCode->get_by_company_id($this->company_id);
			$this->set_code($code);
		}
	}
	
	public function set_code($code)
	{
		$this->_code=$code;
		$this->_code_loaded=true;
	}
	
	/**
	 * @return t_region
	 */
	public function region()
	{
		$this->load_region();
		return $this->_region;
	}
	
	public function load_region()
	{
		//Если не загружены, загрузим. Перезагрузки нет
		if ($this->_region_loaded==false)
		{
			$CI= & get_instance();	/* @var $CI CI_Model */
			$region=$CI->MRegion->get_by_company_id($this->company_id);
			$this->set_region($region);
		}
	}
	
	public function set_region($region)
	{
		$this->_region=$region;
		$this->_region_loaded=true;
	}
	
	
}

?>
