<?php

    namespace Pulse\Core;
    use Pulse\Core\Registry;
    
    class Controller {
        
        public $view;
        public $model;
        public $segments;
        public $pathModel;
        
        public function __construct() {
            $this->segments = Registry::get('segments');
            $this->view = Registry::get('view');
            $this->model = Registry::get('model');
        }
        
        public function loadModel($model) {
    		$model = $model . '_model';
    		require_once($this->pathModel . $model . '.php');
    		return new $model;
    	}
        
       	public function location($url) {
    		header("location: $url");
    		exit(0);
    	}
        
    }

?>