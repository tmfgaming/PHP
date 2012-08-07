<?php

    namespace Pulse\Core;
    
    class Spark {
        
        private $_controllerDefault = 'index';
        private $_uriController;
        private $_uriMethod;
        private $_uriValue = array();
        private $_pathModel = 'Model';
        private $_pathView = 'View';
        private $_pathController = 'Controller';
        private $_basePath;
        
        public $uri;
        public $uriSegments;
        public $uriSlashPath;
        
        public function __construct() {
            if(isset($_GET['url'])) {
                $uri = rtrim($_GET['url'], '/');
                $uri = filter_var($uri, FILTER_SANITIZE_URL);
            }
            $this->uri = (isset($uri)) ? $uri : '';
        }
        
        public function init($overrideUri = false) {
            if(!isset($this->_pathRoot))
            die('You must run setPathRoot($path)');
            
            $urlToBuild = ($overrideUri == true) ? $overrideUri : $this->uri;
            $this->_buildComponents($urlToBuild);
            
            $this->_initView();
            $this->_initModel();
            $this->_initController();
        }
        
        public function _buildComponents($uri) {
            $uri = explode('/', $uri);
            $this->uriSegments = $uri;
            $this->_initUriSlashPath($uri);
            $this->_uriController = ucwords($uri[0]);
            $this->_uriMethod = (isset($uri[1])) ? strtolower($uri[1]) : NULL;
            $this->_uriValue = array_splice($uri, 2);
            
            if (!isset($this->_uriController) || empty($this->_uriController))
            $this->_uriController = $this->_controllerDefault;
        }
        
        public function setPathRoot($path) {
            $this->_pathRoot = trim($path, '/') . '/';
        }
        
        public function setPathController($path) {
    		$this->_pathController = $this->_pathRoot . trim($path, '/') . '/';
    	}
        
        public function setPathModel($path) {
    		$this->_pathModel = $this->_pathRoot . trim($path, '/') . '/';
    	}
        
        public function setPathView($path) {
		  $this->_pathView = $this->_pathRoot . trim($path, '/') . '/';
	    }
        
        public function setControllerDefault($controller) {
    		$this->_controllerDefault = strtolower($controller);
    	}
        
        private function _initUriSlashPath() {
    		$this->uriSlashPath = '';
    		$realSegments = explode('/', $this->uri);
    
    		for ($i = 1; $i < count($realSegments); $i++) 
    		{
    			$this->uriSlashPath .= '../';
    		}
    	}
        
        private function _initController() {
    		if (file_exists($this->_pathController . $this->_uriController . '.php')) 
    		{
    
    			require $this->_pathController . $this->_uriController . '.php';
    			$controller = $this->_uriController;
    			$this->controller = new $controller();
    			$this->controller->pathModel = $this->_pathModel;
    
    			if (isset($this->_uriMethod))
    			{
    				if (!empty($this->_uriValue))
    				{
    					switch (count($this->_uriValue))
    					{
    						case 1:
    						$this->controller->{$this->_uriMethod}($this->_uriValue[0]);
    						break;
    
    						case 2:
    						$this->controller->{$this->_uriMethod}($this->_uriValue[0], $this->_uriValue[1]);
    						break;
    
    						case 3:
    						$this->controller->{$this->_uriMethod}($this->_uriValue[0], $this->_uriValue[1], $this->_uriValue[2]);
    						break;
    
    						case 4:
    						$this->controller->{$this->_uriMethod}($this->_uriValue[0], $this->_uriValue[1], $this->_uriValue[2], $this->_uriValue[3]);
    						break;
    
    						case 5:
    						$this->controller->{$this->_uriMethod}($this->_uriValue[0], $this->_uriValue[1], $this->_uriValue[2], $this->_uriValue[3], $this->_uriValue[4]);
    						break;
    					}
    				}
    				else
    				$this->controller->{$this->_uriMethod}();
    			}
    			else {
    				$this->controller->index();
    			}
    		}
    		else 
    		{
    			die(__CLASS__ . ': error (non-existant controller): ' . $this->_uriController);
    		}
    	}
        
        private function _initModel() {
    		$actualModel = $this->_pathModel . $this->_uriController . '_model.php';
    
    		if (file_exists($actualModel))
    		{
    			require $actualModel;
    			$model = (string) $this->_uriController . '_model';
    			$model = (object) new $model();
    			Registry::set('model', $model);
    		}
    	}
        
        private function _initView() {
    		$view = new View();
    		$view->setPath($this->_pathView);
    		Registry::set('view', $view);
    	}
    }

?>