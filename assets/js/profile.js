$(document).ready(function(){

	// on page ready we want time line to be selected.
	$(".timeline").css('background-color','#EDF9EF');
	$(".about").css('background-color','white');
	$(".subscribed").css('background-color','white');
	$(".photos").css('background-color','white');
	$(".timelinex").fadeIn("slow");
	$(".aboutx").fadeOut("slow");
	$(".subscribedx").fadeOut("slow");
	$(".photosx").fadeOut("slow");


	$(".subscribed").click(function(){
		$(".subscribed").css('background-color','#EDF9EF');
		$(".timeline").css('background-color','white');
		$(".about").css('background-color','white');
		$(".photos").css('background-color','white');
		$(".subscribedx").fadeIn("slow");
		$(".aboutx").fadeOut("slow");
		$(".photosx").fadeOut("slow");
		$(".timelinex").fadeOut("slow");
	});

	$(".photos").click(function(){
		$(".photos").css('background-color','#EDF9EF');
		$(".timeline").css('background-color','white');
		$(".about").css('background-color','white');
		$(".subscribed").css('background-color','white');
		$(".photosx").fadeIn("slow");
		$(".aboutx").fadeOut("slow");
		$(".subscribedx").fadeOut("slow");
		$(".timelinex").fadeOut("slow");
	});

	$(".about").click(function(){
		$(".about").css('background-color','#EDF9EF');
		$(".timeline").css('background-color','white');
		$(".subscribed").css('background-color','white');
		$(".photos").css('background-color','white');
		$(".aboutx").fadeIn("slow");
		$(".subscribedx").fadeOut("slow");
		$(".photosx").fadeOut("slow");
		$(".timelinex").fadeOut("slow");
	});

	$(".timeline").click(function(){
		$(".timeline").css('background-color','#EDF9EF');
		$(".about").css('background-color','white');
		$(".subscribed").css('background-color','white');
		$(".photos").css('background-color','white');
		$(".timelinex").fadeIn("slow");
		$(".aboutx").fadeOut("slow");
		$(".subscribedx").fadeOut("slow");
		$(".photosx").fadeOut("slow");
	});

	//ev enthandler below hide the edit button and shows the finish edit button
	// it may also post the form
	$('#edit').click(function(){
		$('#edit').css('display','none');
		$('#finishEdit').css('display','block');
		//removes the readonly attribute
		$('#dob').removeAttr("readonly");
	    $('#education').removeAttr("readonly");
	    $('#intrests').removeAttr("readonly");
	    $('#philosophy').removeAttr("readonly");
	    // gives focus to the intrest
	    $("#dob").focus();
	});

	// this function uploades the about form to the database 
	$('#finishEdit').click(function(){
		$('#edit').css('display','block');
		$('#finishEdit').css('display','none');

		$.ajax({
			method: "POST",
		    url:    "profile/about_info",
		    data:   $('#about_form').serialize()
		})
	});

	//this function shows all the subscribed photographer
	$('#seemore').click(function(){
		$('#_sub').css('display','none');
		$('.sub-hldr').css('max-height','585px');
		$('.sub-hldr').css('overflow','auto');
	});
});

// function to unsubscribe user
function unsubscribe(id){
	$.ajax({
		method  : "POST",
		url     : "profile/unsubscribe",
		data    :  {id:id},
		success : function(result) {
			//the id of the div element to be removed in case of unsubscribed
			var divId = '#'+id+'_un';
		    $(divId).remove();		    
		    $('#sub_text').text('Subscribe');
		    $(".sub-btn").attr("onclick","subscribe()");
		}
	});
}

// function to subscribe user
function subscribe(followed_by,first_name,last_name,email_address,user_id){
	$.ajax({
		method  : "POST",
		url     : "profile/subscribe",
		data    : {followed_by:followed_by, first_name:first_name, last_name:last_name, email_address:email_address, user_id:user_id},
		success : function(result){
			//the id of the div element to be removed in case of subscribed
			var divId = '#'+user_id+'_sub';
		    $(divId).remove();	
		    $('#sub_text').text('Unsubscribe');
		    $(".sub-btn").attr("onclick","unsubscribe("+user_id+")");
		}
	});
}


