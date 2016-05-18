/**
 *  The JavaScript for selecting series information.
 */

function selectSeries(i){
    message('Collecting info on the series.');
    var newName = $('#url-' + i).text();
    var newURL = $('#url-' + i).attr('data-url');
    var request = $.post({
        url: 'series/update',
        data: 'url=' + newURL + '&name=' + newName + '&primescraper_csrf_token=' + $('[name=primescraper_csrf_token]').val(),
        dataType: 'text'
    });
    request.done(function(data){
        message(data);
        $('#url_holder').val(newName);
    });
}
$(document).ready(function(){
    
    // Begin a very long winded search for the series urls. Return them as a JSON object.
    $('#search_series').click(function(){
        message('Searching for links, please wait.');
        var data = 'url=' + $('#url_holder').val();
        var request = $.post({
            url: 'series/search',
            data: data + '&primescraper_csrf_token=' + $('[name=primescraper_csrf_token]').val(),
            dataType: 'text'
        });
        request.done(function(data){
            var result = $.parseJSON(data);
            var output = '';
            for(r in result){
                output += "<div id='output-" + r + "'>";
                output += "<span id='url-" + r + "' data-url='" + result[r].url + "'>";
                output += result[r].name;
                output += "</span>";
                output += "<span class='select_button'><input type='button' class='form-control border btn btn-primary' onclick='selectSeries(" + r + ")' value='Select' /></span>";
                output += "</div>"
            }
            $('#results').html(output);
            $('#results').show();
        });
        request.fail(function(xhr, ts, et){
            console.log(ts);
        });
    });
});