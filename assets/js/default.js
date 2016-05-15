/**
 * Basic JavaScript functionality common to all pages
 */

function ajax(url, data){
    
}

function message(msg){
    $('#message').html(msg);
    setTimeout(function(){
        $('#message').html('');
    }, 5000);
}