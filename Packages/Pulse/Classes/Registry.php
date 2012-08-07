<?php

    namespace Pulse\Core;
    
    class Registry
    {

    	private static $_record = array();

    	public static function set($key, &$item) {
    		self::$_record[$key] = &$item;
    	}
    
    	public static function get($key) {
    		if (isset(self::$_record[$key]))
    		return self::$_record[$key];
    
    		else 
    		return false;
    	}
    
    }

?>