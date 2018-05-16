// this function is to add followers to page
 function follow( id, user_id){
    $.ajax({
      url: 'follow/add_followers', //This is the current doc
      type: "POST",
      dataType:'json', // add json datatype to get json
      data: ({followed_by:id, user_id: user_id}),
      success: function(response){
        console.log(response);
        $('#user'+user_id).remove();
      },
      complete: function(){
        $('#user'+user_id).remove();
      }
    });
 } 

