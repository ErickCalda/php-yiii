function showToast(message, type = 'success'){

    let toast = $('<div class="app-toast '+type+'">'+message+'</div>');

    $('#toast-container').append(toast);

    setTimeout(function(){

        toast.addClass('show');

    }, 100);


    setTimeout(function(){

        toast.removeClass('show');

        setTimeout(function(){

            toast.remove();

        }, 400);

    }, 3000);

}