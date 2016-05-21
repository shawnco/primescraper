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
      var newSource = $('#source_name').val();
      var currentSources = new Array();
      $('.list_name').each(function(index){
          currentSources[index] = $(this).text();
      });
      if(currentSources.indexOf(newSource) > 0){
          message('That source already exists.');
      }else{
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
                output = "<li><div class='row'><div class='col-sm-2' id='list_name'>" + result['domain'] + "</div>";
                output += "<div class='col-sm-2' id='list_type'>" + result['type'] + "</div>"
                output += "<div class='col-sm-2' id='list_preference'>" + result['preference'] + "</div>";
                output += "<div class='col-sm-2 list_actions'><i class='fa fa-pencil-square-o' aria-hidden='true'></i><i class='fa fa-trash-o' aria-hidden='true'></i></div>";
                output += "</div></li>";
                $('#source_list').append(output);
            }
        });
      }
   }); 
   
   // Handle editing a source.
   $('.fa-pencil-square-o').on('click', function(){
       var row = $(this).parent().parent();
       
       // Replace the domain name with an input.
       var domainName = row.find('.list_name').text();
       row.find('.list_name').text('');
       row.find('.list_name').append("<input class='border form-control' id='form_name' name='form_name' value='" + domainName + "' />");
       console.log(row.find('.list_name').find('form_name'));
       
       // Replace the type name with an input
       var sourceType = row.find('.list_type').text();
       row.find('.list_type').text('');
       row.find('.list_type').append("<input class='border form-control' id='form_type' name='form_type' value='" + sourceType + "' />");
       
       // Finally, replace this icon with a check.
       $(this).switchClass('fa-pencil-square-o', 'fa-check');
   });
   
   // Complete the editing process
   $('.fa-check').on('click', function(){
       // Get the new domain and sources
       var source = $(this).parent().parent().find('#form_name').val();
       var type = $(this).parent().parent().find('#form_type').val();
       var preference = $(this).parent().parent().find('.list_preference').text();
       var request = $.post({
           url: 'sources/updateSource',
           data: 'source=' + source + '&type=' + type + '&preference=' + preference,
           dataType: 'text'
       });
       request.done(function(data){
           var result = $.parseJSON(data);
           console.log(result);
           var row = $($('.list_preference')[result.preference]).parent().parent();
           row.find('.list_name').text(result.domain);
           row.find('.list_type').text(result.type);
           $(this).switchClass('fa-check', 'fa-pencil-square-o');
           message('Source successfully updated.');
       });
   });
   
   // Delete sources
   $('.fa-trash-o').on('click', function(){
       if(confirm('Are you sure you want to delete this source?')){
           var source = $(this).parent().parent().find('.list_name').text();
           var preference = $(this).parent().parent().find('.list_preference').text();
            // Remove the list element
           $(this).parent().parent().parent().remove();
           var request = $.post({
               url: 'sources/deleteSource',
               data: 'source=' + source + '&preference=' + preference,
               dataType: 'text'
           });
           request.done(function(data){
               
               // Re-display the preferences.
               var preferences = $.parseJSON(data);
               var rows = $('.list_preference');
               for(p in preferences){
                   $(rows[p]).text(preferences[p].preference);
               }
               message('Source deleted.');
           });
       }
   });
});
