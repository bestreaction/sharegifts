<!DOCTYPE html>
<html>
<head>
    <title>Sharegifts</title>
    <meta charset="UTF-8">
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo HOME_URL;?>">Share (Now: <?php echo (new DateTime(CURDATE))->format('d-m-Y H:i:s');?>)</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <li><a href="<?php echo HOME_URL; ?>">Home</a></li>
                <?php if(!Request::session("is_logged_in")) { ?>
                    <li><a href="<?php echo ROOT_URL; ?>/user/login">Sign In</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo ROOT_URL; ?>/gift/my-gifts">My Gifts <span class="badge"><?php echo $counter; ?></span></a></li>
                    <li><a href="<?php echo ROOT_URL; ?>/user/index">Users</a></li>
                    <li><a href="<?php echo ROOT_URL; ?>/user/logout">Logout</a></li>
                <?php } ?>
                </ul>
            </div><!--/.navbar-collapse -->
        </div>
    </nav>

    <div class="container" style="margin-top:60px;">
        <div class="row">
            <?php Messages::display(); ?>
            <?php require($view); ?>
        </div>

    </div>



    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="<?php ROOT_PATH; ?>/assets/js/main.js"></script>
</body>
</html>