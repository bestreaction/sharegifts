<div class="jumbotron">
    <div class="container">
        <strong>You have <?php echo $viewModel['myGiftCounter']; ?> gifts!</strong>
    </div>
</div>

<div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
    <!-- Default panel contents -->
    <div class="panel-heading">Claim Requests</div>
    <!-- Table -->
    <div class="panel-body">
        <p id="claimStatusMsg" style="display:none;"></p>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Sent By</th>
            <th>Gift</th>
            <th>Sent At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <?php
            foreach ($viewModel['myGifts'] as $myGift){
                if(!isset($myGift['claim_at']) && is_null($myGift['expired_at'])){
                    echo '<tr id="row-'.$myGift['id'].'">'.
                        '<td>'.$myGift['name'].'</td>'.
                        '<td>'.$myGift['title'].'</td>'.
                        '<td>'.(new DateTime('@'.$myGift['sent_at']))->format('d/m/Y').'</td>'.
                        '<td><a href="#" id="claimGift" data-id="'.$myGift['id'].'"><span class="label label-info">Claim</span></a></td>'.
                        '</tr>';
                }
            }
        ?>
    </table>
</div>

<div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
    <!-- Default panel contents -->
    <div class="panel-heading">Expired Requests</div>
    <!-- Table -->
    <table class="table">
        <thead>
        <tr>
            <th>Sent By</th>
            <th>Gift</th>
            <th>Sent At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <?php
            foreach ($viewModel['myGifts'] as $myGift){
                if(!isset($myGift['claim_at']) && !is_null($myGift['expired_at'])){
                    echo '<tr>'.
                        '<td>'.$myGift['name'].'</td>'.
                        '<td>'.$myGift['title'].'</td>'.
                        '<td>'.(new DateTime('@'.$myGift['sent_at']))->format('d/m/Y').'</td>'.
                        '<td><span class="label label-danger">Expired</span></td>'.
                        '</tr>';
                }
            }
        ?>
    </table>
</div>