<?php

    class User extends Controller{

        protected function index(){
            $viewModel = new UserModel();

            $users = $viewModel->index();

            $this->returnView($viewModel->index(), true, ['users' => $users]);
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
            echo '<script>' .
                'FB.logout();'.
            '</script>';

            unset($_SESSION['is_logged_in']);
            unset($_SESSION['user_data']);
            session_destroy();

            header("Location: " .ROOT_URL. "/user/login");
            exit;
        }
    }