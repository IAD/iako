<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class response extends object
{
	var $_messages_ok=array();
	var $_messages_error=array();
	
	function __set($key, $value)
	{
		if ($key=='messages_error')
		{
			$this->_messages_error[]=$value;
			$CI=& get_instance();
			$CI->session->set_flashdata('messages_error', $this->_messages_error);
			return (true);
		}
		if ($key=='messages_ok')
		{
			$this->_messages_ok[]=$value;
			$CI=& get_instance();
			$CI->session->set_flashdata('messages_ok', $this->_messages_ok);
			return (true);
		}
		$this->_data[$key]=$value;
	}
}

?>
