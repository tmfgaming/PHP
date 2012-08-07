<?php

    class Home extends Pulse\Core\Controller {
        
        public function index() {
            $this->view->render('home');
        }
    }

?>