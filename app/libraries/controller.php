<?php
    /*
    * Base Controller
    * Loads the models and views
    */
    class Controller {
        //Load model
        public function model($model){
            //Require model file from models folder
            require_once '../app/models/' . $model . '.php';

            //Instantiate the model, e.g. user or post etc
            return new $model();
        }

        //Load view
        public function view($view, $data = []){
            //Check for the view file
            if(file_exists('../app/views/' . $view . '.php')){
                //Require view file from views folder
                require_once '../app/views/' . $view . '.php';
            } else {
                //View doesn't exists
                die('View does not exist');
            }
        }
        

    }

?>