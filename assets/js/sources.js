/**
 *  JavaScript for the sources page
 *  
 *  @author Shawn Contant <shawnc366@gmail.com>
 */

$(document).ready(function(){
   $('#source_list').sortable({
       stop: function(event, ui){
           alert('I must needs resorts!');
       }
   });
   $('#source_list').disableSelection();
   $('#add_button').click(function(){
      data = 'domain=' + $('#source_name').val() + '&type=' + $('#source_type').val() + '&primescraper_csrf_token=' + $('[name=primescraper_csrf_token]').val();
      var request = $.post({
          url: 'sources/addSource',
          data: data,
          dataType: 'text'
      });
      request.done(function(data){
          result = $.parseJSON(data);
          $('#message').html(result['message']);
          if(result['result'] == 'success'){
              output = "<li><span id='list_name'>" + result['domain'] + "</span>";
              output += "<span id='list_type'>" + result['type'] + "</span>"
              output += "<span id='list_preference" + result['preference'] + "</span></li>";
              $('#source_list').append(output);
              //$('#source_list').append('<li>' + result['domain'] + '</li>');
          }
      });
   }); 
});
