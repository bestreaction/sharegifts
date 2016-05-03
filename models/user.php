<?php

    class UserModel extends Model
    {
        public function index()
        {
            return;
        }

        public function register()
        {
            if(Request::has(['username', 'email', 'password']))
            {
                if (Request::post('username') === '' || Request::post('password') === '' || Request::post('email') === '')
                {
                    Messages::setMsg('All fields are required!', 'error');
                    header("Location: " . ROOT_URL . "/user/register");
                    exit;
                }

                $password = md5(Request::post('password'));

                // If pass there is no user with username or email.
                if($this->checkUser(Request::post('username'), Request::post('email')) === false) {
                    $this->query("INSERT INTO users(username, email, password, register_at) VALUES(:username, :email, :password, :register_at)");
                    $this->bind(":username", Request::post('username'));
                    $this->bind(":email", Request::post('email'));
                    $this->bind(":password", $password);
                    $this->bind(":register_at", (new DateTime())->format('Y-m-d H:i:s'));
                    $this->execute();

                    if ($this->lastInsertId()) {
                        header("Location: " . ROOT_URL . "/user/login");
                        exit;
                    }
                } else {
                    Messages::setMsg('Username or Email used by someone. Please type another email or username.');
                    header("Location: " . ROOT_URL . "/user/register", "error");
                    exit;
                }
            }
        }

        public function login()
        {
            if(Request::has(['username', 'password']))
            {
                if (Request::post('username') === '' || Request::post('password') === '')
                {
                    Messages::setMsg('All fields are required!', 'error');
                    header("Location: " . ROOT_URL . "/user/login");
                    exit;
                }

                $password = md5(Request::post('password'));

                $this->query("SELECT id, username, email FROM users WHERE (email = :email OR username = :username) AND password = :password");
                $this->bind(":username", Request::post('username'));
                $this->bind(":email", Request::post('username'));
                $this->bind(":password", $password);
                $row = $this->single();
                
                if($row){
                    Request::setSession([
                        'is_logged_in' => true,
                        'user_data' => [
                            'id' => $row['id'],
                            'username' => $row['username'],
                            'email' => $row['email']
                        ]
                    ]);

                    header("Location: " . ROOT_URL . "/home/index");
                    exit;
                } else {
                    Messages::setMsg('Account is not exist!', "error");
                    header("Location: " . ROOT_URL . "/user/login");
                    exit;
                }
            }
        }

        protected function checkUser($username, $email){
            $this->query("SELECT id FROM users WHERE username = :username OR email = :email");
            $this->bind(":username", $username);
            $this->bind(":email", $email);
            $row = $this->single();

            if($row){
                return true;
            } else {
                return false;
            }
        }
    }