/**
 *  JavaScript for the sources page
 *  
 *  @author Shawn Contant <shawnc366@gmail.com>
 */

$(document).ready(function(){
   $('#source_list').sortable();
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
              $('#source_list').append('<li>' + result['domain'] + '</li>');
          }
      });
   }); 
});
