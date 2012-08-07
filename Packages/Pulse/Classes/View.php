<?php

    namespace Pulse\Core;
    
    class View
    {
    
    
    	private $_viewQueue = array();
    
    
    	private $_path;
    
    	public function __construct() {}
    
    
    	public function render($name, $viewValues = array())
    	{
    		$this->_viewQueue[] = $name;
    
    
    		foreach($viewValues as $key => $value) 
    		{
    			$this->{$key} = $value;
    		}
    	}
    
    	public function setPath($path)
    	{
    		$this->_path = $path;
    	}
        
    	public function __destruct()
    	{
    		foreach($this->_viewQueue as $vc)
    		{
    			require $this->_path . $vc . '.php';
    		}
    	}
    
    }

?>