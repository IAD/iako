<?php
class MRegion extends CI_Model
{
	var $table='regions';
	var $ret_data_type='t_region';
	
   function __construct()
   {
      parent::__construct();
   }
	
	/**
	 * @return t_region[]
	 */
	function get_all()
	{
/*
		$items=array();
		$this->db->order_by('url');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['region_id']]=new $this->ret_data_type ($item);
		}
		
		return ($items);

 */
		return($this->get_all_with_companyes_count());
	}
	
	/**
	 * @return t_region[]
	 */
	function get_all_with_companyes_count()
	{
		$sql='SELECT regions . * , count( companyes.company_id ) AS companyes_count FROM regions LEFT JOIN companyes ON regions.region_id = companyes.region_id GROUP BY regions.region_id ORDER BY region_id';
		$items=array();
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['region_id']]=new $this->ret_data_type ($item);
		}
		return ($items);
	}
	
	/**
	 * @return t_region[]
	 */
	function get_by_site_id($site_id)
	{
		$sql='SELECT regions . * , count( companyes.company_id ) AS companyes_count FROM regions LEFT JOIN companyes ON regions.region_id = companyes.region_id where regions.site_id='.(int)$site_id.' GROUP BY regions.region_id ORDER BY region_id';
		$items=array();
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['region_id']]=new $this->ret_data_type ($item);
		}
		return ($items);
	}

	/**
	 * @return t_region
	 */
	function get_by_company_id($company_id)
	{
		$sql='SELECT regions . * , count( companyes.company_id ) AS companyes_count FROM regions LEFT JOIN companyes ON regions.region_id = companyes.region_id where companyes.company_id='.$company_id.' GROUP BY regions.region_id ORDER BY region_id';
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			return(new $this->ret_data_type ($item));
		}
		return (new $this->ret_data_type());
	}

	/**
	 * @return t_region[]
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
		$this->db->order_by('region_id');
		$query=$this->db->get($this->table);
		
		foreach ($query->result_array() as $item)
		{
			$items[$item['region_id']]=new $this->ret_data_type ($item);
		}
		
		return ($items);
	}
	
	/**
	 * @return t_region
	 */

	function get_by_id($id)
	{
		$sql='SELECT regions . * , count( companyes.company_id ) AS companyes_count FROM regions LEFT JOIN companyes ON regions.region_id = companyes.region_id where regions.region_id='.(int)$id.' GROUP BY regions.region_id ORDER BY region_id';
		$items=array();
		$query=$this->db->query($sql);
		
		foreach ($query->result_array() as $item)
		{
			return(new $this->ret_data_type ($item));
		}
		return ($items);
	}
	
	/**
	 * @return int
	 */
	function add($item)
	{
		$this->db->set('site_id',$item->site_id);
		$this->db->set('comment',$item->comment);
		$this->db->set('code_id_defoult',$item->code_id_defoult);
		$this->db->set('size_x',$item->size_x);
		$this->db->set('size_y',$item->size_y);
		$this->db->insert($this->table);
		$this->change_event();
		return ($this->db->insert_id());
	}
	
	function delete_by_id($id)
	{
		$this->db->where('region_id', $id);
		$this->db->delete($this->table);
		$this->MCompany->delete_by_region_id($id);
		$this->change_event();
	}
	
	function delete_by_site_id($site_id)
	{
		$items=$this->get_by_site_id($site_id);
		foreach ($items as $item)
		{
			$this->delete_by_id($item->region_id);
		}
		$this->change_event();
	}
	
	function edit($item)
	{
		$this->db->where('region_id', $item->region_id);
		$this->db->set('site_id',$item->site_id);
		$this->db->set('comment',$item->comment);
		$this->db->set('code_id_defoult',$item->code_id_defoult);
		$this->db->set('size_x',$item->size_x);
		$this->db->set('size_y',$item->size_y);
		$this->db->update($this->table);
		$this->change_event();
	}
	
	function change_event()
	{
		//Изменился блок или кампания
		//Пересчитаем все коды вызова областей сайта
		$regions=$this->get_all();
		$companyes=$this->MCompany->get_all();
		$codes=$this->MCode->get_all();
		foreach ($regions as $region)
		{
			$blocks=array();
			$min=0;
			foreach ($companyes as $company)
			{
				if ($company->region_id==$region->region_id && $company->weight!=0)
				{
					$blocks[]=array(
						'from' => $min + $company->weight,
						'step' => $company->weight,
						'code'=>  base64_encode($codes[$company->code_id]->code)
					);
					$min+=$company->weight;
				}
			}
			//Запишем изменения в /include/$region_id.php
			$this->write_to($region->region_id, $blocks, $min);
		}
	}
	
	function write_to($filename, $codes, $min)
	{
		$file=fopen($_SERVER['DOCUMENT_ROOT'].'/include/'.$filename.'.php','w') or die('error');
		//echo $_SERVER['DOCUMENT_ROOT'].'/include/regions/'.$filename.'.php';
		$code='
<?php
$_adv_codes='.var_export($codes,true).';
$_adv_max='.$min.';
$_adv_rnd=rand(0, $_adv_max);
$_adv_find=true;
foreach ($_adv_codes as $_adv_code)
{
	if (isset($_adv_code["from"]) && $_adv_code["from"]>=$_adv_rnd)
	{
		if (isset($_adv_code["code"]) && $_adv_find)
		{
			eval(" ?>".base64_decode($_adv_code["code"])."<?php ");
			$_adv_find=false;
		}
	}
}
?>';
		
		fputs($file, $code);
		fclose($file); 
	}
}

/**
* @property int $region_id
* @property int $site_id
* @property string $comment
* @property int $code_id_defoult
* @property int $size_x
* @property int $size_y
*/

class t_region extends object
{
	private $_site;
	private $_site_loaded=false;
	private $_companyes;
	private $_companyes_loaded=false;

	/**
	 * @return t_site
	 */
	public function site()
	{
		$this->load_site();
		return $this->_site;
	}
	
	public function load_site()
	{
		//Если не загружены, загрузим. Перезагрузки нет
		if ($this->_site_loaded==false)
		{
			$CI= & get_instance();	/* @var $CI CI_Model */
			$site=$CI->MSite->get_by_region_id($this->region_id);
			$this->set_site($site);
		}
	}
	
	public function set_site($site)
	{
		$this->_site=$site;
		$this->_site_loaded=true;
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
			$companyes=$CI->MCompany->get_by_region_id($this->region_id);
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
