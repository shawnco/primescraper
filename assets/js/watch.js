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

function getLocation(){
    var request = $.post({
        url: 'watch/getLocation',
        dataType: 'text'
    });
    request.done(function(data){
        var result = $.parseJSON(data);
        $('#location').html(result['season'] + '-' + result['episode']);
    });
}

function getLinks(){
    var request = $.post({
        url: 'watch/getLinks',
        dataType: 'text'
    });
    request.done(function(data){
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
    getLocation();
    $('.fa-chevron-left').click(function(){
        var request = $.post({
            url: 'watch/previousEpisode',
            dataType: 'text'
        });
        request.done(function(data){
            message(data);
            getLinks();
            getLocation();
        })
    });
    
    $('.fa-chevron-right').click(function(){
        var request = $.post({
            url: 'watch/nextEpisode',
            dataType: 'text'
        });
        request.done(function(data){
            message(data);
            getLinks();
            getLocation();
        });
    });
    
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
            if(data.indexOf('Reload') > 0){
                $(this).toggleClass('check-circle-o');
            }
        })
    })
});
