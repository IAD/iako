<?php
class MAdvertise extends CI_Model
{
	var $table='advertisers';
	var $ret_data_type='t_adv';
	
   function __construct()
   {
      parent::__construct();
   }
	
	/**
	 * @return t_adv[]
	 */
	function get_all()
	{
		$items=array();
		$this->db->order_by('name');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['adv_id']]=new t_adv ($item);
		}
		return ($items);
	}
	
	/**
	 * @return t_adv[]
	 */
	function get_all_with_codes_count()
	{
		$sql='SELECT advertisers.* , count( codes.code_id ) AS codes_count FROM advertisers LEFT JOIN codes ON advertisers.adv_id = codes.adv_id GROUP BY advertisers.adv_id ORDER BY name';
		$items=array();
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['adv_id']]=new t_adv ($item);
		}
		return ($items);

	}

	/**
	 * @return t_adv
	 */
	function get_by_code_id($code_id)
	{
		$sql='SELECT advertisers . * FROM advertisers LEFT JOIN codes ON codes.adv_id = advertisers.adv_id where codes.code_id='.(int)$code_id.' GROUP BY codes.code_id';
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			return(new t_adv ($item));
		}
		return (new t_adv());
	}

	/**
	 * @return t_adv
	 */
	function get_by_id($id)
	{
		$item=new t_adv();
		$this->db->where('adv_id', $id);
		$query=$this->db->get($this->table);
		foreach ($query->result_array() as $item)
		{
			return(new t_adv ($item));
		}
		return ($item);
	}
	
	function add($item)
	{
		$this->db->set('name',$item->name);
		$this->db->insert($this->table);
		return ($this->db->insert_id());
	}
	
	function delete_by_id($id)
	{
		$this->db->where('adv_id', $id);
		$this->db->delete($this->table);
		$this->MCode->delete_by_adv_id($id);
	}
	
	function edit($item)
	{
		$this->db->where('adv_id', $item->adv_id);
		$this->db->set('name', $item->name);
		$this->db->update($this->table);
	}
	
}

/**
* @property int $adv_id
* @property string $name
*/
class t_adv extends object
{
	private $_codes=array();
	private $_codes_loaded=false;
	
	/**
	 * @return t_code[]
	 */
	public function codes()
	{
		$this->load_codes();
		return $this->_codes;
	}
	
	public function load_codes()
	{
		//Если не загружены, загрузим. Перезагрузки нет
		if ($this->_codes_loaded==false)
		{
			$CI= & get_instance();	/* @var $CI CI_Model */
			$codes=$CI->MCode->get_by_adv_id($this->adv_id);
			$this->set_codes($codes);
		}
	}
	
	public function set_codes($codes)
	{
		$this->_codes=$codes;
		$this->_codes_loaded=true;
	}
}


?>
