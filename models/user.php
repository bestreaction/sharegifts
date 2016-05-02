<?php

    class UserModel extends Model
    {
        public function index()
        {
            $this->query("SELECT * FROM users");
            $rows = $this->resultSet();
        }

        public function register()
        {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $password = md5($post['password']);

            if($post['submit']){
                $this->query("INSERT INTO users(username, email, password, register_at) VALUES(:username, :email, :password, :register_at)");
                $this->bind(":username", $post['username']);
                $this->bind(":email", $post['email']);
                $this->bind(":password", $password);
                $this->execute();

                if($this->lastInsertId()){
                    header("Location: " .ROOT_URL. "/user/login");
                    exit;
                }
            }
        }

        public function login()
        {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $password = md5($post['password']);

            if($post['submit']){
                $this->query("SELECT * FROM users WHERE username = :username AND password = :password");
                $this->bind(":username", $post['username']);
                $this->bind(":password", $password);

                $row = $this->single();

                if($row){
                    $_SESSION['is_logged_in'] = true;
                    $_SESSION['user_data'] = [
                        "id" => $row['id'],
                        "username" => $row['username'],
                        "email" => $row['email']
                    ];

                    header("Location: " .ROOT_URL. "/home/index");
                } else {
                    echo 'Incorrect login';
                }
            }
            return;
        }
    }