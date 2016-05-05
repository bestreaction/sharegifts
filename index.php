<?php
    ini_set('session.gc_maxlifetime', 3600);
    session_set_cookie_params(3600);

    session_start();
    // include config
    require('config.php');

    require('classes/Request.php');
    require('classes/Messages.php');
    require('classes/Bootstrap.php');
    require('classes/Controller.php');
    require('classes/Model.php');

    require('controllers/home.php');
    require('controllers/user.php');
    require('controllers/gift.php');

    require('models/home.php');
    require('models/user.php');
    require('models/gift.php');
    
    define("CURDATE", Request::session('curdate', (new DateTime())->format('d-m-Y H:i:s')));
    
    $bootstrap = new Bootstrap($_GET);
    $controller = $bootstrap->createController();
    if($controller){
        $controller->executeAction();
    }
