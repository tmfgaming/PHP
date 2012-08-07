<?php

    namespace Pulse\Core;
    use Pulse\Core\Registry;
    
    class Model {
    
    	public $db;
    
    	public function __construct()
    	{
    		$this->db = Registry::get('db');
    	}
    
    }

?>