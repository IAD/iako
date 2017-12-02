<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class object 
{
	protected $_data=array();
	
	function __construct($data=false)
	{
		if ($data!=false)
		{
			$this->_data=$data;
		}
	}
	
	function &__get($key)
	{
		return $this->_data[$key];
	}
	
	function __set($key, $value)
	{
		$this->_data[$key]=$value;
	}
	
	function __invoke($p1=false)
	{
		if ($p1==false)
		{
			return ($this->_data);
		}
	}
	
	function is_empty()
	{
		return (empty($this->_data));
	}
}

?>
