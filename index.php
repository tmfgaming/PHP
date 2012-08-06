<?php
    
    use Pulse\Core\Autoloader as Autoloader;
    error_reporting(E_ALL);
    
    /*
     *---------------------------------------------------------------
     * Const
     *---------------------------------------------------------------
     */
     
     defined('BASEPATH') or define('BASEPATH', realpath(dirname(__FILE__)) . '/');
     defined('PKGPATH') or define('PKGPATH', BASEPATH . 'Packages/');
     defined('COREPATH') or define('COREPATH', PKGPATH . 'Pulse/');
     defined('APPPATH') or define('APPPATH', PKGPATH . 'App/');
     
    /*
     *---------------------------------------------------------------
     * Autoloader -- Loads some classes which listed
     *---------------------------------------------------------------
     */
     
    if( ! function_exists('bootstrap_autoloader'))
    {
    	function bootstrap_autoloader()
    	{
    		require(COREPATH . 'Classes/Autoloader.php');
    		Pulse\Core\Autoloader::setIncludePath(PKGPATH);
    		Pulse\Core\Autoloader::register();
    
    		Autoloader::add_classes(array(
    				"Pulse\\Core\\Pulse" => PKGPATH . 'Pulse/Classes/Pulse.php',
                    "Pulse\\Core\\MVC" => PKGPATH . 'Pulse/Classes/MVC.php', 
    			));
    
    
    		alias(array(
    			"Pulse\\Core\\Autoloader" => 'Autoloader',
    			"Pulse\\Core\\Pulse" 	  => 'Pulse',
    		));
    	}
    }
     
     if(!function_exists('alias')) {
        function alias($array) {
            foreach($array as $class => $alias) {
                class_alias($class, $alias);
            }
        }
     }
     
    /*
     *---------------------------------------------------------------
     * Bootstrap -- Starts the Bootstrap
     *---------------------------------------------------------------
     */
     
     bootstrap_autoloader();