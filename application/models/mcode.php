<?php
class MCode extends CI_Model
{
	var $table='codes';
	var $ret_data_type='t_code';
	
   function __construct()
   {
      parent::__construct();
   }
	
	/**
	 * @return t_code[]
	 */
	function get_all()
	{
      $items=array();
		//$this->db->order_by('url');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['code_id']]=new $this->ret_data_type ($item);
		}
		
		return ($items);
	}
	
	/**
	 * @return t_code
	 */
	function get_by_adv_id($adv_id)
	{
		$items=array();
		$this->db->where('adv_id', $adv_id);
		$this->db->order_by('code_id');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['code_id']]=new $this->ret_data_type ($item);
		}
		
		return ($items);
	}
	
	/**
	 * @return t_code
	 */
	function get_by_company_id($company_id)
	{
		$sql='SELECT codes . * FROM codes LEFT JOIN companyes ON codes.code_id = companyes.code_id where companyes.company_id='.(int)$company_id.' GROUP BY codes.code_id';
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			return(new $this->ret_data_type ($item));
		}
		return (new $this->ret_data_type());
	}
	
	/**
	 * @return t_code[]
	 */
	function get_by_size($size_x,$size_y)
	{
		$items=array();
		if ($size_x)
		{
			$this->db->where('size_x<=', $size_x, false);
		}
		if ($size_y)
		{
			$this->db->where('size_y<=', $size_y, false);
		}
		$this->db->order_by('code_id');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['code_id']]=new $this->ret_data_type ($item);
		}
		
		return ($items);
	}
	
	/**
	 * @return t_code
	 */
	function get_by_id($id)
	{
		$item=new $this->ret_data_type();
		$this->db->where('code_id', $id);
		$query=$this->db->get($this->table);
		foreach ($query->result_array() as $item)
		{
			return(new $this->ret_data_type ($item));
		}
		return ($item);
	}
	
	function add($item)
	{
		$this->db->set('adv_id',$item->adv_id);
		$this->db->set('comment',$item->comment);
		$this->db->set('code',$item->code);
		$this->db->set('size_x',$item->size_x);
		$this->db->set('size_y',$item->size_y);
		$this->db->insert($this->table);
		return ($this->db->insert_id());
	}
	
	function delete_by_id($id)
	{
		$this->db->where('code_id', $id);
		$this->db->delete($this->table);
		$this->MCompany->delete_by_code_id($id);
		$this->MRegion->change_event();	
	}
	
	function delete_by_adv_id($adv_id)
	{
		$items=$this->get_by_adv_id($adv_id);
		foreach ($items as $item)
		{
			$this->delete_by_id($item->code_id);
		}
	}
	
	function edit($item)
	{
		$this->db->where('code_id', $item->code_id);
		$this->db->set('adv_id',$item->adv_id);
		$this->db->set('comment',$item->comment);
		$this->db->set('code',$item->code);
		$this->db->set('size_x',$item->size_x);
		$this->db->set('size_y',$item->size_y);
		$this->db->update($this->table);
		$this->MRegion->change_event();	}
	
}

/**
* @property int $code_id
* @property int $adv_id
* @property string $comment
* @property string $code
* @property int $size_x
* @property int $size_y
*/

class t_code extends object
{
	private $_advertise;
	private $_advertise_loaded=false;
	private $_companyes;
	private $_companyes_loaded=false;

	/**
	 * @return t_adv
	 */
	public function advertise()
	{
		$this->load_advertise();
		return $this->_advertise;
	}
	
	public function load_advertise()
	{
		//Если не загружены, загрузим. Перезагрузки нет
		if ($this->_advertise_loaded==false)
		{
			$CI= & get_instance();	/* @var $CI CI_Model */
			$advertise=$CI->MAdvertise->get_by_code_id($this->code_id);
			$this->set_advertise($advertise);
		}
	}
	
	public function set_advertise($advertise)
	{
		$this->_advertise=$advertise;
		$this->_advertise_loaded=true;
	}
	
	/**
	 * @return t_company[]
	 */
	public function companyes()
	{
		$this->load_companyes();
		return $this->_companyes;
	}
	
	public function load_companyes()
	{
		//Если не загружены, загрузим. Перезагрузки нет
		if ($this->_companyes_loaded==false)
		{
			$CI= & get_instance();	/* @var $CI CI_Model */
			$companyes=$CI->MCompany->get_by_code_id($this->code_id);
			$this->set_companyes($companyes);
		}
	}
	
	public function set_companyes($companyes)
	{
		$this->_companyes=$companyes;
		$this->_companyes_loaded=true;
	}
	
	
}

?>
