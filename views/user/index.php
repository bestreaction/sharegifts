<div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
    <!-- Default panel contents -->
    <div class="panel-heading">Send Gift to Users</div>
    <!-- Table -->
    <div class="panel-body">
        <form class="form-inline" action="<?php echo ROOT_URL; ?>/user/change-default-time" method="post">
            <input type="text" placeholder="d-m-Y" name="curdate" class="form-control">
            <input type="submit" value="Change current date for testing purpose" class="btn btn-sm">
        </form>
        <br/>
        <form class="form-inline" action="<?php echo ROOT_URL; ?>/gift/truncate" method="get">
            <input class="btn btn-xs btn-danger" type="submit" value="Truncate users__gifts table for testing purpose">
        </form>
        <br/>
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
        <?php foreach($viewModel['users'] as $user) { ?>
        <tr id="row-<?php echo $user['id']; ?>">
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['register_at']; ?></td>
            <td>
                <button type="button" id="sendGift" class="btn btn-primary btn-sm"
                        data-toggle="tooltip" data-placement="top" title="Send a gift"
                    data-to="<?php echo $user['id'];?>" data-gift-id="1">
                    <span class="glyphicon glyphicon-gift"></span> Send a Gift
                </button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

