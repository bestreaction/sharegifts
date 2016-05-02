<?php

    class HomeModel extends Model{

        public function index()
        {
            return;
        }

        public function add()
        {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        }
    }