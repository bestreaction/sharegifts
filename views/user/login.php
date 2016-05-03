<div class="col-sm-6 col-sm-push-3 col-sm-pull-3">

    <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <h2>Sign in</h2>
        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required autofocus autocomplete="off">
        </div>

        <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required autocomplete="off">
        </div>

        <input class="btn btn-lg btn-primary" type="submit" value="Login" />
        <fb:login-button scope="public_profile,email" data-size="large" onlogin="checkLoginState();"></fb:login-button>

        <div class="text-right">
            <a href="<?php ROOT_URL; ?>/user/register">Sign up here</a>
        </div>
        <div id="status">
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php ROOT_PATH; ?>/assets/js/fb.js"></script>
