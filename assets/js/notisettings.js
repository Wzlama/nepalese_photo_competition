$(document).ready(function(){
    // function to show or hide notification 

    $('#noti').click(function(){
        if($(window).width() <= 800) {
            // need this to be changed when uploaded to production
            window.location = "https://nplespc.com/notification";
            $.get( "profile/viewNotification", function() { console.log('Notification viewed.') })
        }else{
            // having some design issues need to fix the index
            // if($('.notification').hasClass('visible')){
            //     $('.notification').removeClass('visible');
            //     $('.notification').css('display','none');
            //     $('.setting').removeClass('visible');
            //     $('.setting').css('display','none');
            //     $.get( "profile/viewNotification", function() { console.log('Notification viewed.') })
            // }else{
            //     $('.notification').addClass('visible');
            //     $('.setting').removeClass('visible');
            //     $('.notification').css('display','block');
            //     $('.setting').css('display','none');
            //     $.get( "profile/viewNotification", function() { console.log('Notification viewed.') })
            // }          
            
            // UNTILL THE DESIGN ISSUE IS FIXED 
            window.location = "https://nplespc.com/notification";
            $.get( "profile/viewNotification", function() { console.log('Notification viewed.') })
        }
    });

    // function to show or hide settings
    // urrently i have got only one settng option so i am not using jquery.

    // $('#set').click(function(){
    //     if($(window).width() <= 800) {
    //         window.location = "https://localhost/settings";
    //     }else{
    //         if($('.setting').hasClass('visible')){
    //             $('.notification').removeClass('visible');
    //             $('.setting').removeClass('visible');
    //             $('.setting').css('display','none');
    //             $('.notification').css('display','none');
    //         }else{
    //             $('.notification').removeClass('visible');
    //             $('.setting').addClass('visible');
    //             $('.setting').css('display','block');
    //             $('.notification').css('display','none');
    //         }
    //     }
    // });

});
    
// function executed after user hav eclicked notification
// function viewNotification(id, post_id){
//     var activity_id = id;
//     var post_id     = post_id;

//     $.ajax({
//       method: "POST",
//       url: "profile/viewNotification",
//       data: { activity_id: activity_id, post_id: post_id }
//     })
//     .done(function( msg ) {
//       window.location.href='photo?id='+post_id;
//     });
// }

// function to handle the change in date
function change_dob(){
    $('#dob').removeAttr('readonly');
    $('#dob').focus();
    $('#ch_dob').css('display','none');
    $('#done_dob').css('display','inline-block');
}


// function to handle the viewfirst_name
function change_first_name(){
    $('#first_user_name').removeAttr('readonly');
    $('#first_user_name').focus();
    $('#ch_first').css('display','none');
    $('#done_first').css('display','inline-block');
}

// function to handle the view of the last name
function change_last_name(){
    $('#last_user_name').removeAttr('readonly');
    $('#last_user_name').focus();
    $('#ch_last').css('display','none');
    $('#done_last').css('display','inline-block');
}

// function to handle the view of the gender
function change_gender(){
    $('#ch_gender_hldr').css('display','none');
    $('#ch_gender').css('display','none');
    $('#gender').css('display','inline-block');
    $('#done_gender').css('display','inline-block');
}

// function to handle the view of the gender
function gender_changed(user_id){
  var value = $('#gender').val();
  
   $.ajax({
    method: "POST",
    url: "notification/update_gender",
    data: { gender: value, user_id: user_id }
  })
  .done(function( msg ) {
    $('#ch_gender_hldr').css('display','inline-block');
    $('#ch_gender_hldr').val(value);
    $('#ch_gender').css('display','inline-block');
    $('#done_gender').css('display','none');    
    $('#gender').css('display','none');
  });
}

// function to handle the view of the gender
function change_district(){
    $('#ch_dis_hldr').css('display','none');
    $('#ch_district').css('display','none');
    $('#district_ch').css('display','inline-block');
    $('#done_district').css('display','inline-block');
}

// function to handle the view of the district
function district_changed(user_id){
  var value = $('#district_ch').val();
  
   $.ajax({
    method: "POST",
    url: "notification/update_district",
    data: { district: value, user_id: user_id }
  })
  .done(function( msg ) {
    $('#ch_dis_hldr').css('display','inline-block');
    $('#ch_dis_hldr').val(value);
    $('#ch_district').css('display','inline-block');
    $('#done_district').css('display','none');    
    $('#district_ch').css('display','none');
  });
}

// function to handle the view of the last name
function change_chowk_name(){
    $('#chowk_name_change').removeAttr('readonly');
    $('#chowk_name_change').focus();
    $('#ch_chowk').css('display','none');
    $('#done_chowk').css('display','inline-block');
}

function dob_changed(user_id){
    var value = $('#dob').val();
    
     $.ajax({
      method: "POST",
      url: "notification/update_user_dob",
      data: { value: value, user_id: user_id }
    })
    .done(function( msg ) {
      $('#ch_dob').css('display','inline-block');
      $('#done_dob').css('display','none');
    });
}

function first_name_changed(user_id){
    var value = $('#first_user_name').val();
    
     $.ajax({
      method: "POST",
      url: "notification/update_user_first_name",
      data: { first_name: value, user_id: user_id }
    })
    .done(function( msg ) {
      $('#ch_first').css('display','inline-block');
      $('#done_first').css('display','none');
    });
}

function last_name_changed(user_id){
    var value = $('#last_user_name').val();
    
     $.ajax({
      method: "POST",
      url: "notification/update_user_last_name",
      data: { last_name: value, user_id: user_id }
    })
    .done(function( msg ) {
      $('#ch_last').css('display','inline-block');
      $('#done_last').css('display','none');
    });
}

function chowk_name_changed(user_id){
    var value = $('#chowk_name_change').val();
    
     $.ajax({
      method: "POST",
      url: "notification/update_user_chowk_name",
      data: { chowk_name: value, user_id: user_id }
    })
    .done(function( msg ) {
      $('#ch_chowk').css('display','inline-block');
      $('#done_chowk').css('display','none');
    });
}


