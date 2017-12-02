<?php
class MRelationTableMapper extends CI_Model
{
	var $collection='temp';
	var $ret_data_type='object';
	
   function __construct()
   {
      parent::__construct();
   }
   
	function get_all($sort=array())
	{
      $items=array();
		$this->db->order_by('url');
		$query=$this->db->get('sites');
		
		foreach ($query->result() as $item)
		{
			$items[]=new $this->ret_data_type ($item);
		}
		
		return ($items);
	}
	
	function add($item)
	{
		$data['id']=md5(microtime());
		$data['url']=$item->url;
		
		$this->db->{$this->collection}->insert($data);
		return ($item);
	}
	
	function edit($item)
	{
		if ($item->id)
		{
			$where=array('id'=>$item->id);
			if ($this->db->{$this->collection}->find($where)->count()>0)
			{
				$data=$item();
				$this->db->{$this->collection}->update($where, array('$set'=>$data));
				return (true);
			}
		}
		return (false);
	}

	function get_by_id($id)
	{
		$where=array
		(
			'id'=>$id,
		);
		return ($this->get_one($where));
	}
	
	function get_one($where)
	{
		$rez=$this->db->{$this->collection}->findone($where);
		$item=new $this->ret_data_type($rez);
		return ($item);
	}
	
	function delete_by_id($id)
	{
		$where=array
		(
			'id'=>$id,
		);
		if ($this->db->{$this->collection}->find($where)->count()>0)
		{
			$this->delete($where);
			return (true);
		}
		return (false);
	}
	
	function delete($where)
	{
		$this->db->{$this->collection}->remove($where);
	}	
	
	function count($where)
	{
		return $this->db->{$this->collection}->find($where)->count();
	}
	
	function count_by_id($id)
	{
		$where=array
		(
			'id'=>$id,
		);
		return $this->count($where);
	}
}



?>
