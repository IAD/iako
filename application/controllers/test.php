<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
   }
	
	public function t1()
	{
		$a=  $this->MCompany->get_by_id(26);
		echo '<pre>';
		//var_dump($a->region());
		//var_dump($a->region()->site());
		foreach ($a->region()->site()->regions() as $region)
		{
			/* @var $region t_region */
			echo $region->comment."<br/>";
		}
		
		
		$a=$this->MAdvertise->get_by_id(8);
		echo "a:".$a->name.":<br/>";
		foreach ($a->codes() as $code)
		{
			/* @var $code t_code */
			echo "c:".$code->comment."<br/>";
			foreach ($code->companyes() as $company)
			{
				/* @var $company t_company */
				echo "cn:".$company->weight."<br/>";
			}
		}
		$a=$this->MCompany->get_by_id(8);
		echo $a->code()->advertise()->name;
		echo '</pre>';
		
	}
}
?>
