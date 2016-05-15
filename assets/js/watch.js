/**
 *  The JavaScript for the watch page
 *  
 *  @author Shawn Contant <shawnc366@gmail.com>
 */

var links = new Array();

function loadVideo(i){
    $('iframe').prop('src', links[i].url);
}

function getLinks(){
    var request = $.post({
        url: 'watch/getLinks',
        dataType: 'text'
    });
    request.done(function(data){
        links = $.parseJSON(data);
        console.log(links);
        if(links.length < 1){
            message('There are no links for this video.');
        }else{
            message('Links loaded.');
            loadVideo(0);
        }
    });
}
$(document).ready(function(){
    getLinks();
});
