<?php

    namespace Pulse\Core;

    class Route {
    	private $_routes = array();
    
    	public function __construct($array) {
    		$this->_routes = $array;
    	}
    
    	public function match($uri) {
    		if (empty($this->_routes)) {
    			return false;
    		}
    
    		foreach ($this->_routes as $findMe => $replaceWith) {
    			preg_match("#^$findMe#", $uri, $match);
                
    			if (!empty($match)) {		
    				$segment1 = substr($replaceWith, 0, strpos($replaceWith, '*'));
    				$segment1 = rtrim($segment1, '/') . '/';
    				$segment2 = substr($uri, strlen($match[0]));
    
    				return $segment1 . $segment2;
    
    			}
    		}
    		return false;
    	}
    
    
    }

?>