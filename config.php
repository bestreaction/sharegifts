<?php

    if($_SERVER['APP_ENV'] === 'local') {
        // Define DB Params
        define("DB_HOST", "localhost");
        define("DB_USER", "homestead");
        define("DB_PASS", "secret");
        define("DB_NAME", "sharegifts");

        // Define URL
        define("ROOT_PATH", "/");
        define("ROOT_URL", "http://sinan.dev");
        define("HOME_URL", "http://sinan.dev/home/index");
    } else {
        // Define DB Params
        define("DB_HOST", "localhost");
        define("DB_USER", "root");
        define("DB_PASS", "eaGc9OQuig");
        define("DB_NAME", "sharegifts");

        // Define URL
        define("ROOT_PATH", "/");
        define("ROOT_URL", "http://sinangul.com");
        define("HOME_URL", "http://sinangul.com/home/index");
    }