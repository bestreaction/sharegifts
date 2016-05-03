<?php

    class User extends Controller{

        protected function index(){
            $viewModel = new UserModel();
            $this->returnView($viewModel->index(), true);
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
            echo 'Hello';
        }

        protected function logout(){
            unset($_SESSION['is_logged_in']);
            unset($_SESSION['user_data']);
            session_destroy();

            header("Location: " .ROOT_URL. "/user/login");
        }
    }