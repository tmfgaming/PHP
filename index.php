<?php
    use Pulse\Core\Autoloader as Autoloader;
    error_reporting(E_ALL);
    
    
    /*
    *---------------------------------------------------------------
    * Const
    *---------------------------------------------------------------
    */
    
    defined('BASEPATH') or define('BASEPATH', realpath(dirname(__file__)) . '/');
    defined('PKGPATH') or define('PKGPATH', BASEPATH . 'Packages/');
    defined('COREPATH') or define('COREPATH', PKGPATH . 'Pulse/');
    defined('APPPATH') or define('APPPATH', PKGPATH . 'App/');
    
    /*
    *---------------------------------------------------------------
    * Autoloader -- Loads some classes which listed
    *---------------------------------------------------------------
    */
    
    
    if (!function_exists('bootstrap_autoloader')) {
        function bootstrap_autoloader()
        {
            require (COREPATH . 'Classes/Autoloader.php');
            Pulse\Core\Autoloader::setIncludePath(PKGPATH);
            Pulse\Core\Autoloader::register();
    
            Autoloader::add_classes(array(
                "Pulse\\Core\\Pulse" => PKGPATH . 'Pulse/Classes/Pulse.php',
                "Pulse\\Core\\Spark" => PKGPATH . 'Pulse/Classes/Spark.php',
                "Pulse\\Core\\View" => PKGPATH . 'Pulse/Classes/View.php',
                "Pulse\\Core\\Registry" => PKGPATH . 'Pulse/Classes/Registry.php',
                "Pulse\\Core\\Controller" => PKGPATH . 'Pulse/Classes/Controller.php',
                "Pulse\\Core\\Model" => PKGPATH . 'Pulse/Classes/Model.php',
                ));
    
            alias(array(
                "Pulse\\Core\\Autoloader" => 'Autoloader',
                "Pulse\\Core\\Spark" => 'Spark',
                ));
        }
    }
    
    
    if (!function_exists('alias')) {
        function alias($array)
        {
            foreach ($array as $class => $alias) {
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
    
    $Spark = new Pulse\Core\Spark();
    
    $Spark->setPathRoot(APPPATH);
    $Spark->setPathController('Controller/');
    $Spark->setPathModel('Model/');
    $Spark->setPathView('View/');
    $Spark->setControllerDefault('home');
    $Spark->init();

?>