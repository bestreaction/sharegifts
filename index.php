<?php
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

    require('models/home.php');
    require('models/user.php');


    $bootstrap = new Bootstrap($_GET);
    $controller = $bootstrap->createController();
    if($controller){
        $controller->executeAction();
    }
