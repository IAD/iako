<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class request extends object
{
   function __construct($data = false) 
   {
      if ($data==false)
      {
         parent::__construct($_REQUEST);
      }
	  parent::__construct();
   }
}

?>
