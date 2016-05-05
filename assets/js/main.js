$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});


$("body").on("click", "#sendGift", function(e){
    var giftId = $(this).data('gift-id');
    var to = $(this).data('to');

    $.ajax({
        type: 'post',
        url: '/gift/send',
        dataType: 'json',
        cache: false,
        data: 'gift_id=' + giftId + '&to=' + to
    }).always(function(xhr){
        if (xhr.error === false) {
            $("#row-" + to).removeClass("danger").addClass("success");
            $("#row-" + to + " td:nth-child(3)").text("");
            $("#statusMsg").fadeIn().html('<div class="alert alert-success">' + xhr.data + '</div>');
        } else {
            $("#row-" + to).addClass("danger");
            $("#statusMsg").fadeIn().html('<div class="alert alert-danger">' + xhr.data + '</div>');
        }
    });
});

$("body").on("click", "#claimGift", function(e){
    var id = $(this).data('id');

    $.ajax({
        type: "post",
        url: "/gift/receive",
        dataType: "json",
        cache: false,
        data: "id=" + id
    }).always(function(xhr){
        if (xhr.error === false) {
            $("#row-" + id).removeClass("danger").addClass("success");
            $("#row-" + id + " td:nth-child(4)").text("");
            $("#claimStatusMsg").fadeIn().html('<div class="alert alert-success">' + xhr.data + '</div>');
        } else {
            $("#row-" + id).addClass("danger");
            $("#claimStatusMsg").fadeIn().html('<div class="alert alert-danger">' + xhr.data + '</div>');
        }
    });
});