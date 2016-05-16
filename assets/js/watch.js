/**
 *  The JavaScript for the watch page
 *  
 *  @author Shawn Contant <shawnc366@gmail.com>
 */

var links = new Array();
var i = 0;

function loadVideo(i){
    console.log('loading video');
    console.log(links[i].url);
    $('iframe').prop('src', links[i].url);
}

function getLinks(){
    var request = $.post({
        url: 'watch/getLinks',
        dataType: 'text'
    });
    request.done(function(data){
        console.log(data);
        links = $.parseJSON(data);
        //console.log(links);
        if(links.length < 1){
            message('There are no links for this video.');
        }else{
            message('Links loaded.');
            loadVideo(i);
        }
    });
}
$(document).ready(function(){
    getLinks();
    
    $('.fa-refresh').click(function(){
        var len = links.length;
        if(i < len - 1){
            i++;
        }else{
            message('Last of the links. Starting from the first.');
            i = 0;
        }
        loadVideo(i);
    });
    
    $('.fa-check').click(function(){
        var request = $.post({
            url: 'watch/markWatched',
            dataType: 'text'
        });
        request.done(function(data){
            message(data);
        })
    })
});
