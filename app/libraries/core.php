<?php
    /*
     * Core App Class
     * Create URL & loads core controller
     * URL FORMAT - /controller/method/params
     */ 

    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            //print_r($this->getUrl());
            $url = $this->getUrl();
            
            //Look in controllers if that controller exists based on first value of url, e.g. 'posts'
            if(file_exists(('../app/controllers/' . ucwords($url[0]) . '.php'))){
                //If exists, set as controller
                $this->currentController = ucwords($url[0]);
                // Unset 0 Index
                unset($url[0]);
            }

            //Require the controller, whether pages or posts or users etc
            require_once '../app/controllers/' . $this->currentController . '.php';

            //Instantiate the controller class, result e.g. "$pages = new Pages;"
            $this->currentController = new $this->currentController;

            //Check for second part of URL, which is the method
            if(isset($url[1])){
                //Check to see if method exists in controller
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    // Unset 0 Index
                    unset($url[1]);
                }
            }
            
            //Get Parameters usign tenery operator. If there are parameters it will assign them, else it will remain empty array
            $this->params = $url ? array_values($url) : [];

            //Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }

?>