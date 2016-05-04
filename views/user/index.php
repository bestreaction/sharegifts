<div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
    <!-- Default panel contents -->
    <div class="panel-heading">Send Gift to Users</div>
    <!-- Table -->
    <div class="panel-body">
       <p class="text-right">
           <button type="button" class="btn btn-primary btn-sm" onclick="sendRequest()">
               <span class="glyphicon glyphicon-gift"></span> Send gifts to Facebook Friends
           </button>
       </p>
        <p id="statusMsg" style="display:none;"></p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Register At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php foreach($data['users'] as $user) { ?>
        <tr id="row-<?php echo $user['id']; ?>">
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['register_at']; ?></td>
            <td>
                <button type="button" id="sendGift" class="btn btn-primary btn-sm"
                        data-toggle="tooltip" data-placement="top" title="Send a gift"
                    data-to="<?php echo $user['id'];?>" data-gift-id="1">
                    <span class="glyphicon glyphicon-gift"></span>
                </button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<script type="text/javascript" src="<?php ROOT_PATH; ?>/assets/js/fb.js"></script>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1792063247693484',
            cookie     : true,  // enable cookies to allow the server to access
                                // the session
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.6' // use graph api version 2.6
        });
    };

    // Load the SDK asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function sendRequest() {
        FB.ui({method: 'apprequests',
            message: 'This is a test message',

        }, function(response){
            console.log(response);
        });
    }

</script>

