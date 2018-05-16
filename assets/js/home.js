$(document).ready(function(){
    // this function is for the image preview
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
               // $('#blah').attr('src', e.target.result);
        
                // first we need to clear the image that is already in the box
                $('#imgPreview img').remove();

                $("<img />",{
                            "src": e.target.result,
                            "width": "185",
                            "height": "105"
                        }).appendTo(imgPreview);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgupload").change(function(){
        readURL(this);
    });
    

    //self invoking function iife function with time interval to pull activity data
    var repeater;

    (function doWork() {
        var baseUrl   = 'home/getActivities';
        $.ajax({
            type: "POST",
            url: baseUrl,
            dataType: "json",
            success: function(data) {   
                var content = '';             
                  // $.each(data, function(index,cat){
                    content += '<div class="activity_wraper"><img src="'+data['profile_image']+'" style="padding: 5px; float: left; border-radius: 50%;"width="33px" height="31px"><a href="photo?id='+data["post_id"]+'" style="text-decoration: none; color: #9F9F9F">'+data["donor_user_name"]+' '+data["activity"]+' a photo.</a></div>';
                  // }); 
                $('.side05').prepend(content);                                                                                        
            }
        });
     repeater = setTimeout(doWork, 600000);
    })();

    //jquery UI that creates a dialogbox
    $( ".dialog" ).dialog({
        autoOpen: false,
        width: 'auto', // overcomes width:'auto' and maxWidth bug
        height: 'auto',
        modal: true,
        fluid: true, //new option
        resizable: false,
        open: function(){
            jQuery('.ui-widget-overlay').bind('click',function(){
                jQuery('#dialog').dialog('close');
            })
        }
    });

    // on window resize run function
    $(window).resize(function () {
        fluidDialog();
    });

    // catch dialog if opened within a viewport smaller than the dialog width
    $(document).on("dialogopen", ".ui-dialog", function (event, ui) {
        fluidDialog();
    });

    function fluidDialog() {
        var $visible = $(".ui-dialog:visible");
        // each open dialog
        $visible.each(function () {
            var $this = $(this);
            var dialog = $this.find(".ui-dialog-content").data("ui-dialog");
            // if fluid option == true
            if (dialog.options.fluid) {
                var wWidth = $(window).width();
                // check window width against dialog width
                if (wWidth < (parseInt(dialog.options.maxWidth) + 50))  {
                    // keep dialog from filling entire screen
                    $this.css("max-width", "100%");
                    $this.css("max-height", "375px");
                    $this.css("overflow-y", "auto");
                } else {
                    // fix maxWidth bug
                    $this.css("max-width", dialog.options.maxWidth + "px");
                    $this.css("max-height", "375px");
                    $this.css("overflow-y", "auto");
                }
                //reposition dialog
                dialog.option("position", dialog.options.position);
            }
        });

    }

    // addning the global script which closes all the dialogboxes by clicking outside them
    $(document.body).on("click", ".ui-widget-overlay", function()
    {
        $.each($(".ui-dialog"), function()
        {
            var $dialog;
            $dialog = $(this).children(".ui-dialog-content");
            if($dialog.dialog("option", "modal"))
            {
                $dialog.dialog("close");
            }
        });
    });      
});
// end of function doucment ready

// JSFiddle, when you set the wrapping to "onLoad" 
// or "onDomready", the functions you define are only defined inside that block,
// and cannot be accessed by outside event handlers
// function to show the comments of the
// home page for respective image
function showComments(id){
    $('#comments-show'+id).css('display','block');
}


    // for posting comment on button click
function postComment(id, user_id){
    var baseUrl   = 'home/postComment';
    var comment   = $('#comment'+id).val();
    console.log(user_id);
    $.ajax({
        type: "POST",
        url: baseUrl,
        data: { image_id: id, comment: comment, owner_id: user_id },
        dataType: "json",
        success: function(data) {
            $('#comment'+id).val('');
            $('#comments-show'+id).css('display','block');

            
              var content = '<div class="comment-hldr">'; 
              $.each(data, function(index,cat){
                if(cat.full_path != undefined){
                    content += '<div id="_'+cat.comment_id+'"><div class="comment-buttons-holder" id="_button'+cat.comment_id+'">\n\n\
                                <ul>\n\n\
                                    <li class="delete-btn" onClick= "comment_delete('+cat.comment_id+')">X</li>\n\n\
                                </ul>\n\n\
                            </div><div class="sm-prof-desc"><img src="' + cat.full_path +'/' +cat.profileImage +'"  height="45px" width="45px"></div>\n\
                    <div class="comment-hldr-text"><a href="#">'+cat.first_name + ' ' + cat.last_name +'</a><br><span>'+comment+'</span></div></div>';
                }else{
                    content += '<div id="_'+cat.comment_id+'"><div class="comment-buttons-holder" id="_button'+cat.comment_id+'">\n\n\
                                <ul>\n\n\
                                    <li id="'+cat.comment_id+'" class="delete-btn" onClick= "comment_delete('+cat.comment_id+')">X</li>\n\n\
                                </ul>\n\n\
                            </div><div class="sm-prof-desc"><img src="images/prof.png"  height="45px" width="45px"></div>\n\
                    <div class="comment-hldr-text"><a href="#">'+cat.commented_by_user_name+'</a><br><span>'+comment+'</span></div></div>';
                }
              }); 
              $('#comments-show'+id).prepend(content);                                                                                        
        }
    });
}

function like(id){
    // remove these default links while in development server
     var baseUrl   = '/home/likes';
     var image_id  = id;
    $.ajax({
        type: "POST",
        url: baseUrl,
        data: { image_id: id },
        dataType: "html",
        success: function(data) {
            var totalLikes = $('#totalLikes'+id).text();
            var newtotal   = parseInt(totalLikes)+1;
            if(data == 'Success')
            {
                $('#like'+id).css('display','none');
                $('#unlikeOpt'+id).css('display','inline');
                $('#likeOpt'+id).css('display', 'none');
                $('#totalLikes'+id).text(newtotal);
            }                                                                                   
        }
    });
}

function unlike(id){
    // remove these default links while in development server
     var baseUrl   = 'home/unlikes';
     var image_id  = id;
    $.ajax({
        type: "POST",
        url: baseUrl,
        data: { image_id: id },
        dataType: "html",
        success: function(data) {
            var totalLikes = $('#totalLikes'+id).text();
            var newtotal   = parseInt(totalLikes)-1;
            console.log(newtotal);
            if(data == 'Success')
            {
                $('#unlike'+id).css('display','none');
                $('#likeOpt'+id).css('display','inline');
                $('#unlikeOpt'+id).css('display','none');  
                $('#totalLikes'+id).text(newtotal); 
            }                                                                                
        }
    });
}

//this function displayes the description of people who liked your photo
function whoLikeThis(val){
    var id  = "#dialog"+val;

    $( id ).dialog( "open" );
    event.preventDefault();
    // $('#likes'+id).dialog("open");
}

//this is the funcrtion that deletes the comment by user_id 

function comment_delete(_comment_id)
{
    alert('Are you sure you want to delete this comment.');
    // remove these default links while in development server
    $.post("home/delete_comment",
    {
        task : "delete_comment",
        comment_id : _comment_id
    }
    )
    .success( function( data ){
        $('#_' + _comment_id).detach();
    }); 
}

// function to delete photo
function delete_my_photo(photo_id){
   alert('Are you sure you want to delete this photo.');
    $.post("photo/delete_photo",
    {
        id : photo_id
    }
    )
    .success( function( data ){
       window.location.href = 'profile';
    });  
}



