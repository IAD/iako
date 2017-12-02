<?php
class MAuth extends CI_Model
{
   function __construct()
   {
      parent::__construct();
   }
	
	function auth()
	{
		if ($this->session->userdata('logon') === 'Yes!')
		{
			return (true);
		}
		include	 ($_SERVER['DOCUMENT_ROOT'].'/config.php');
		if (isset($config['user_password']))
		{
			if ($config['user_password']===$this->input->post('pwd', true))
			{
				$session_data = array('logon'=>'Yes!');
				$this->session->set_userdata($session_data);
				return (true);
			}
		}
		return (false);
	}
	
	function logoff()
	{
		$this->session->sess_destroy();
	}
}
?>
