<?php

    class Bootstrap {
        private $controller;
        private $action;
        private $request;

        public function __construct($request)
        {
            $this->request = $request;

            if(array_key_exists('controller', $this->request) === false || $this->request['controller'] === ''){
                $this->controller = 'home';
            } else {
                $this->controller = self::camelCase($this->request['controller']);
            }

            if(array_key_exists('controller', $this->request) === false || $this->request['action'] === ''){
                $this->action = 'index';
            } else {
                $this->action = self::camelCase($this->request['action']);
            }
        }

        public function createController()
        {
            // Check Class ?
            if(class_exists($this->controller)){
                $parents = class_parents($this->controller);
                // Check Extended ?
                if(in_array("Controller", $parents)){
                    if(method_exists($this->controller, $this->action)){
                        return new $this->controller($this->action, $this->request); // new user(register, request);
                    } else {
                        // Method does not exist!
                        echo '<h1>Method does not exist!</h1>';
                        return;
                    }
                } else {
                    // Base controller does not exist!
                    echo '<h1>Base Controller not found!</h1>';
                    return;
                }
            } else {
                // Controller Class does not exist!
                echo '<h1>Controller class does not exist!</h1>';
                return;
            }
        }


        public static function camelCase($str, array $noStrip = [])
        {
            // non-alpha and non-numeric characters become spaces
            $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
            $str = trim($str);
            // uppercase the first character of each word
            $str = ucwords($str);
            $str = str_replace(" ", "", $str);
            $str = lcfirst($str);

            return $str;
        }
    }