/**
 *  The JavaScript for selecting series information.
 */

function selectSeries(i){
    // Update series.url to the new url
    // Update season and episode to 1 and 1
    // Empty series_data and fill it with the seasons and episodes
    // Show the new series url in the input box
    var newURL = $('#url-' + i).text();
    var request = $.post({
        url: 'series/update',
        data: 'url=' + newURL + '&primescraper_csrf_token=' + $('[name=primescraper_csrf_token]').val(),
        dataType: 'text'
    });
    request.done(function(data){
        $('#message').html(data);
    });
}
$(document).ready(function(){
    
    // Begin a very long winded search for the series urls. Return them as a JSON object.
    $('#search_series').click(function(){
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
                output += "<span id='url-" + r + "'>";
                output += result[r];
                output += "</span>";
                output += "<span class='select_button'><input type='button' onclick='selectSeries(" + r + ")' value='Select' /></span>";
                output += "</div>"
            }
            $('#results').html(output);
            $('#results').show();
        });
        request.fail(function(xhr, ts, et){
            alert(ts);
        });
    });
});