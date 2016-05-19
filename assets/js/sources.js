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
   
   // Handle adding new sources
   $('#add_button').click(function(){
      data = 'domain=' + $('#source_name').val() + '&type=' + $('#source_type').val() + '&primescraper_csrf_token=' + $('[name=primescraper_csrf_token]').val();
      var request = $.post({
          url: 'sources/addSource',
          data: data,
          dataType: 'text'
      });
      request.done(function(data){
          result = $.parseJSON(data);
          console.log(result);
          message(result['message']);
          if(result['result'] == 'success'){
              output = "<li><div class='row'><div class='col-sm-2' id='list_name'>" + result['domain'] + "</div>";
              output += "<div class='col-sm-2' id='list_type'>" + result['type'] + "</div>"
              output += "<div class='col-sm-2' id='list_preference'>" + result['preference'] + "</div>";
              output += "<div class='col-sm-2 list_actions'><i class='fa fa-pencil-square-o' aria-hidden='true'></i><i class='fa fa-trash-o' aria-hidden='true'></i></div>";
              output += "</div></li>";
              $('#source_list').append(output);
          }
      });
   }); 
   
   // Handle editing a source.
   $('.fa-pencil-square-o').click(function(){
       var row = $(this).parent().parent();
       
       // Replace the domain name with an input.
       var domainName = row.find('#list_name').text();
       console.log(domainName);
       row.find('#list_name').text("<input class='border form-control' id='form_name' name='form_name' value='" + domainName + "' />");
       
       // Replace the type name with an input
       var sourceType = row.find('#list_type').text();
       row.find('#list_type').text("<input class='border form-control' id='form_type' name='form_type' value='" + sourceType + "' />");
       
       // Finally, replace this icon with a check.
       $(this).switchClass('fa-pencil-square-o', 'fa-check');
   });
});
