<?php
class MSite extends CI_Model
{
	var $table='sites';
	var $ret_data_type='t_site';
	
   function __construct()
   {
      parent::__construct();
   }
	
	/**
	 * @return t_site[]
	 */
	function get_all()
	{
		return($this->get_all_with_regions_count());
 	}
	
	/**
	 * @return t_site[]
	 */
	function get_all_with_regions_count()
	{
      //Получим список сайтов
		$sql='SELECT sites . * , count( regions.region_id ) AS regions_count FROM sites LEFT JOIN regions ON sites.site_id = regions.site_id GROUP BY sites.site_id ORDER BY url';
		$items=array();
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['site_id']]=new $this->ret_data_type ($item);
		}
		return ($items);

	}
	
	/**
	 * @return t_site
	 */
	function get_by_id($id)
	{
		$item=new $this->ret_data_type();
		$sql='SELECT sites . * , count( regions.region_id ) AS regions_count FROM sites LEFT JOIN regions ON sites.site_id = regions.site_id where sites.site_id='.(int)$id.' GROUP BY sites.site_id ORDER BY url';
		$query=$this->db->query($sql);
		foreach ($query->result_array() as $item)
		{
			return(new $this->ret_data_type ($item));
		}
		return ($item);
	}
	
	/**
	 * @return t_site
	 */
	function get_by_region_id($region_id)
	{
		$item=new $this->ret_data_type();
		$sql='SELECT sites . * , count( regions.region_id ) AS regions_count FROM sites LEFT JOIN regions ON sites.site_id = regions.site_id where regions.region_id='.(int)$region_id.' GROUP BY sites.site_id ORDER BY url';
		$query=$this->db->query($sql);
		foreach ($query->result_array() as $item)
		{
			return(new $this->ret_data_type ($item));
		}
		return ($item);
	}
	
	function add($item)
	{
		$this->db->set('url',$item->url);
		$this->db->insert($this->table);
		return ($this->db->insert_id());
	}
	
	function delete_by_id($id)
	{
		$this->db->where('site_id', $id);
		$this->db->delete($this->table);
		$this->MRegion->delete_by_site_id($id);
	}
	
	function edit($item)
	{
		$this->db->where('site_id', $item->site_id);
		$this->db->set('url', $item->url);
		$this->db->update($this->table);
	}
	
}

/**
* @property int $site_id
* @property string $url
*/

class t_site extends object
{
	private $_regions=array();
	private $_regions_loaded=false;
	
	/**
	 * @return t_region[]
	 */
	public function regions()
	{
		$this->load_regions();
		return $this->_regions;
	}
	
	public function load_regions()
	{
		//Если не загружены, загрузим. Перезагрузки нет
		if ($this->_regions_loaded==false)
		{
			$CI= & get_instance();	/* @var $CI CI_Model */
			$regions=$CI->MRegion->get_by_site_id($this->site_id);
			$this->set_regions($regions);
		}
	}
	
	public function set_regions($regions)
	{
		$this->_regions=$regions;
		$this->_regions_loaded=true;
	}	
}

?>
