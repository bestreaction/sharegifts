<?php

    abstract class Controller{
        protected $request;
        protected $action;

        public function __construct($action, $request)
        {
            $this->action = $action;
            $this->request = $request;
        }

        public function executeAction()
        {
            return $this->{$this->action}();
        }

        protected function returnView($viewModel, $fullView)
        {
            $view = 'views/' . strtolower(get_class($this)) . '/' . $this->action . '.php';
            if($fullView){
                if(Request::auth('id')){
                    $counter = (new GiftModel(Request::auth('id')))->getActiveRequestCounter();
                }
                require('views/main.php');
            } else {
                require($view);
            }
        }
    }