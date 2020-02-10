function showTemporaryMessage(text, type, time, showCloseButton)
{
    if (showCloseButton == undefined) {
        showCloseButton = false;
    }

    Messenger().hideAll();
    Messenger().post({
        message: text,
        type: type,
        hideAfter: time,
        showCloseButton: showCloseButton
    });
}

function hideAllMessage()
{
    Messenger().hideAll();
}

function trackNotification(data, url)
{
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'HTML',
        beforeSend: function(){
        },
        success: function(response){
        },
        complete: function(){
        },
        error: function(a, b, c){
            showTemporaryMessage(c, 'error', 5);
            return false;
        }
    });
}
