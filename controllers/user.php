<?php

    class User extends Controller{

        protected function index(){
            $viewModel = new UserModel();

            $users = $viewModel->index();

            $this->returnView(['users' => $users], true);
        }

        protected function register(){
            if(Request::session('is_logged_in')){
                header("Location: ".HOME_URL);
                exit;
            }

            $viewModel = new UserModel();
            $this->returnView($viewModel->register(), true);
        }

        protected function login(){
            if(Request::session('is_logged_in')){
                header("Location: ".HOME_URL);
                exit;
            }

            $viewModel = new UserModel();
            $this->returnView($viewModel->login(), true);
        }

        protected function fbLogin(){
            if(Request::session('is_logged_in')){
                header("Location: ".HOME_URL);
                exit;
            }
            
            $model = new UserModel();
            echo $model->fbProcess();
        }

        protected function logout(){
            unset($_SESSION['is_logged_in']);
            unset($_SESSION['user_data']);
            session_destroy();

            header("Location: " .ROOT_URL. "/user/login");
            exit;
        }

        protected function changeDefaultTime(){
            if(Request::post('curdate')) {
                if(!DateTime::createFromFormat('d-m-Y', Request::post('curdate'))) {
                    Messages::setMsg('Date format must be d-m-Y', 'error');
                    header('Location: /user/index');
                    exit;
                } else {
                    Messages::setMsg('Current date changed: '.Request::post('curdate'), 'success');
                    Request::setSession(['curdate' => (new DateTime(Request::post('curdate')))->format('d-m-Y H:i:s')]);
                }
            } else {
                Messages::setMsg('Current date is now', 'success');
                Request::setSession(['curdate' => (new DateTime('now'))->format('d-m-Y H:i:s')]);
            }

            header('Location: /user/index');
            exit;
        }
    }