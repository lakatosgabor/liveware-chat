function showNewChatBox(){
    $("#new_chat_box").modal("show");
}

function createNewChat(){
    var new_chat_username = document.getElementById("new_chat_username").value;
    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.post("/inbox/ajax", {
      'createNewChat': '1',
      'new_chat_username' : new_chat_username,
    }, function (result) {
        if (result.type == 'success'){
            $("#new_chat_box").modal("hide");
            setTimeout(function (){location.href = "/inbox/"+result.chat_group_id;}, 1);

        }
      
    });
}