<?php

    class UserModel extends Model
    {
        public function index()
        {
            if(Request::auth('id')) {
                $this->query("SELECT * FROM users WHERE id <> :id ORDER BY name asc");
                $this->bind(':id', Request::auth('id'));

                return $this->resultSet();
            } else {
                return [];
            }
        }

        public function register()
        {
            if(Request::has(['name', 'email', 'password']))
            {
                if (Request::post('name') === '' || Request::post('password') === '' || Request::post('email') === '')
                {
                    Messages::setMsg('All fields are required!', 'error');
                    header("Location: " . ROOT_URL . "/user/register");
                    exit;
                }

                $password = md5(Request::post('password'));

                // If pass there is no user with email.
                if($this->checkUser(Request::post('email')) === false) {
                    $this->query("INSERT INTO users(name, email, password, register_at) VALUES(:name, :email, :password, :register_at)");
                    $this->bind(":name", Request::post('name'));
                    $this->bind(":email", Request::post('email'));
                    $this->bind(":password", $password);
                    $this->bind(":register_at", (new DateTime())->format('Y-m-d H:i:s'));
                    $this->execute();

                    if ($this->lastInsertId()) {
                        header("Location: " . ROOT_URL . "/user/login");
                        exit;
                    }
                } else {
                    Messages::setMsg('Email used by someone. Please type another email.');
                    header("Location: " . ROOT_URL . "/user/register", "error");
                    exit;
                }
            }
        }

        public function login()
        {
            if(Request::has(['email', 'password']))
            {
                if (Request::post('email') === '' || Request::post('password') === '')
                {
                    Messages::setMsg('All fields are required!', 'error');
                    header("Location: " . ROOT_URL . "/user/login");
                    exit;
                }

                $password = md5(Request::post('password'));

                $this->query("SELECT id, name, email FROM users WHERE email = :email AND password = :password");
                $this->bind(":email", Request::post('email'));
                $this->bind(":password", $password);
                $row = $this->single();
                
                if($row){
                    Request::setSession([
                        'is_logged_in' => true,
                        'user_data' => [
                            'id' => $row['id'],
                            'name' => $row['name'],
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

        public function fbProcess(){
            if(Request::has(['id', 'name', 'email'])){
                $user = $this->checkUser(Request::post('email'));
                if($user !== false){
                    // User has been registered.
                    Request::setSession([
                        'is_logged_in' => true,
                        'user_data' => [
                            'id' => $user['id'],
                            'name' => $user['name'],
                            'email' => $user['email']
                        ]
                    ]);

                    return json_encode([
                        'error' => false
                    ]);
                } else {
                    $this->query("INSERT INTO users(name, email, fb_id, register_at) VALUES(:name, :email, :fb_id, :register_at)");
                    $this->bind(":name", Request::post('name'));
                    $this->bind(":email", Request::post('email'));
                    $this->bind(":fb_id", Request::post('id'));
                    $this->bind(":register_at", (new DateTime())->format('Y-m-d H:i:s'));
                    $this->execute();

                    if ($this->lastInsertId()) {
                        Request::setSession([
                            'is_logged_in' => true,
                            'user_data' => [
                                'id' => $this->lastInsertId(),
                                'name' => Request::post('name'),
                                'email' => Request::post('email')
                            ]
                        ]);

                        return json_encode([
                            'error' => false
                        ]);
                    } else {
                        return json_encode([
                            'error' => true,
                            'code' => __LINE__,
                            'data' => 'There was an error'
                        ]);
                    }
                }
            } else {
                return json_encode([
                    'error' => true,
                    'code' => __LINE__,
                    'data' => 'There was an error.'
                ]);
            }
        }

        protected function checkUser($email){
            $this->query("SELECT * FROM users WHERE email = :email");
            $this->bind(":email", $email);
            $row = $this->single();

            if($row){
                return $row;
            } else {
                return false;
            }
        }
    }