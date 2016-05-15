/**
 *  JavaScript for the sources page
 *  
 *  @author Shawn Contant <shawnc366@gmail.com>
 */

$(document).ready(function(){
   $('#source_list').sortable({
       stop: function(event, ui){
           var names = $('.list_name');
           var sourceData = new Array();
           names.each(function(index){
               sourceData[index] = $(this).text();
           });
           // Do I need to add the csrf token? Guess we will see.
           var request = $.post({
               url: 'sources/resort',
               data: {data: sourceData},
               dataType: 'text'
           });
           request.done(function(data){
               var result = $.parseJSON(data);
               $('.list_preference').each(function(index){
                   $(this).text(result[index]['preference']);
               });
           });
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
          message(result['message']);
          if(result['result'] == 'success'){
              output = "<li><span id='list_name'>" + result['domain'] + "</span>";
              output += "<span id='list_type'>" + result['type'] + "</span>"
              output += "<span id='list_preference" + result['preference'] + "</span></li>";
              $('#source_list').append(output);
          }
      });
   }); 
});
