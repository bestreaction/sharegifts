<?php

    class Request {

        public static function all()
        {
            return $_REQUEST;
        }

        public static function post($name)
        {
            return filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING, false);
        }

        public static function get($name)
        {
            return filter_input(INPUT_GET, $name, FILTER_SANITIZE_STRING, false);
        }

        public static function session($key, $default = null)
        {
            if(isset($_SESSION[$key])){
                return $_SESSION[$key];
            } else {
                return $default;
            }
        }

        public static function auth($key, $default = null)
        {
            if(self::session('is_logged_in')){
                return $_SESSION['user_data'][$key];
            }
            return $default;
        }

        public static function setSession($data)
        {
            foreach($data as $key => $value){
                if(!is_array($value)){
                    $_SESSION[$key] = $value;
                } else {
                    foreach($value as $k => $v){
                        $_SESSION[$key][$k] = $v;
                    }
                }
            }
            return;
        }

        public static function sessionAll()
        {
            return $_SESSION;
        }

        public static function has($names)
        {
            $allRequest = $_REQUEST;
            if(is_array($names)){
                foreach($names as $name){
                    if(!array_key_exists($name, $allRequest)){
                        return false;
                    }
                }

                return true;
            } else {
                return array_key_exists($names, $allRequest) ? true : false;
            }

            return false;
        }
    }