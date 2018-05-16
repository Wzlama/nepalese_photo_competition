$(document).ready(function(){
	$('#searchbox').keydown(function(){
	    var searchTxt = $('#searchbox').val();
	    $.post("home/searchUser" ,{searchVal: searchTxt}, function(data){
	        $('#searchResult').html(data.first_name);
	    });
	    $.ajax({
	     url: 'home/searchUser', //This is the current doc
	     type: "POST",
	     dataType:'json', // add json datatype to get json
	     data: ({searchVal:searchTxt}),
	     success: function(response){
	        $.each(response, function(index, value){
	             var profileImage = 'prof.png';
	            if(value.profileImage) { // Covers 'undefined' as well
	              var profileImage = value.profileImage;
	            } 
	            // we need to change the link of the image src while production
	            $('#searchvalue').append('<tr><td><a href="profile/userProfile?id='+value.id+'"><img src="http://localhost/GalleryCMS-Master/profile_pic/'+ profileImage + '" width=25px; height: 25px;/>' + value.first_name+ ' ' + value.last_name + '</a><td></tr>');
	        });
	     }
	});
	    $('#searchvalue').empty();
	});
}