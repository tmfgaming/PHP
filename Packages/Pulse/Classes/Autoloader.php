<?php

namespace Pulse\Core;

/**

 * SplClassLoader implementation that implements the technical interoperability

 * standards for PHP 5.3 namespaces and class names.

 *

 * http://groups.google.com/group/php-standards/web/final-proposal

 *

 *     // Example which loads classes for the Doctrine Common package in the

 *     // Doctrine\Common namespace.

 *     $classLoader = new SplClassLoader('Doctrine\Common', '/path/to/doctrine');

 *     $classLoader->register();

 *

 * @author Jonathan H. Wage <jonwage@gmail.com>

 * @author Roman S. Borschel <roman@code-factory.org>

 * @author Matthew Weier O'Phinney <matthew@zend.com>

 * @author Kris Wallsmith <kris.wallsmith@gmail.com>

 * @author Fabien Potencier <fabien.potencier@symfony-project.org>

 */

class Autoloader

{

    private static $_fileExtension = '.php';

    private static $_namespace;

    private static $_includePath;

    private static $_namespaceSeparator = '\\';



    private static $_map = array();



    public static function add_classes($classes) {
        if(is_array($classes)) {
            self::$_map = array_merge(self::$_map, $classes);
            return true;
        }
        return false;

    }



    public static function add_class($namespace, $path) {
        if($namespace and $path) {
            if( ! isset(self::$_map[$namespace])) {
                self::$_map[$namespace] = $path;
                return true;
            }
        }
        return false;
    }

    public static function setNamespaceSeparator($sep) {
        self::$_namespaceSeparator = $sep;
    }

    public static function getNamespaceSeparator() {
        return self::$_namespaceSeparator;
    }
    
    public static function setIncludePath($includePath) {
        self::$_includePath = $includePath;
    }

    public static function getIncludePath() {
        return self::$_includePath;
    }

    public static function setFileExtension($fileExtension) {
       self::$_fileExtension = $fileExtension;
    }

    public static function getFileExtension() {
        return self::$_fileExtension;
    }

    public static function register() {
        spl_autoload_register("Pulse\Core\Autoloader::loadClass");
    }

    public static function unregister() {
        spl_autoload_unregister("Pulse\Core\Autoloader::loadClass");
    }

    public static function loadClass($className) {
        if (null === self::$_namespace || self::$_namespace.self::$_namespaceSeparator === substr($className, 0, strlen(self::$_namespace.self::$_namespaceSeparator))) {
            $fileName = '';
            $namespace = '';
            if (false !== ($lastNsPos = strripos($className, self::$_namespaceSeparator))) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace(self::$_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }

            if( ! empty($namespace)) {
                $newNamespace = $namespace . '\\' . $className;
                if(isset(self::$_map[$newNamespace])) {
                    $path = self::$_map[$newNamespace];
                    if(file_exists($path)) {
                        require $path;
                        return true;
                    }
                }
            }

            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . self::$_fileExtension;
            require (self::$_includePath !== null ? self::$_includePath : '') . $fileName;

        }

    }

}

?>