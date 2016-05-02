<div class="col-sm-6 col-sm-push-3 col-sm-pull-3">
    <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <h2>Sign up</h2>
        <div class="form-group">
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
        </div>

        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
        </div>

        <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button class="btn btn-lg btn-primary" type="submit">Register</button>
    </form>
</div>
