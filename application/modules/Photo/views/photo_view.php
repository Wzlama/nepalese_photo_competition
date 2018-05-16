<?php if($this->session->userdata('user_id')){?>
    <?php $this->load->view('/includes/header'); ?>
<?php }else{ ?>
    <?php $this->load->view('/includes/header_no_login_public'); ?>
<?php } ?>

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>

<div class="photo-page">
    <div class="content_photo">
        <main>

        <div class="feed_photo">
            <?php foreach ($user_list as $user): ?>
                <?php if($user->id == $photo_dtl[0]->user_id): ?>
                    <!-- link to redirect to user profile -->
                    <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>" style="text-decoration: none;">
                    <div class="profileDesc">
                    <!-- check if profile picture is uploaded by user -->
                        <?php if($user->profileImage){ ?>
                            <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                        <?php }else{ ?>
                            <img src="images/profdef.png" height="60px;" style="padding: 5px; float: left;">
                        <?php } ?>
                        <span style="float: left; color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . " " .$user->last_name; ?></h3><br><br>
                        <span style="color: #e1e1e1; font-size: 12px; line-height: 10px;"><?php echo $photo_dtl[0]->created_at; ?></span>
                    </div>
                    <!-- end of link to user page -->
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
            <!-- end class profileDesc -->
            
            <?php if($photo_dtl[0]->user_id == $this->session->userdata('user_id')): ?>
                <span style="float: right; font-size: 10px; color: royalblue; padding-right: 4px; cursor: pointer;" onclick="delete_my_photo(<?php echo $photo_dtl[0]->id; ?>)">Delete My Image</span>
            <?php endif; ?>

            <div class="feedContent">
                <div class="img-desc"><?php echo $photo_dtl[0]->caption; ?></div>
                <!-- end div caption -->

                <div class="img-hldr">
                        <img src="<?php echo $photo_dtl[0]->full_path .'/'. $photo_dtl[0]->name; ?>" width="80%" id="image_view">
                </div>
                <!-- end class img-hldr -->
            </div>
            <!-- end class feedContent -->

            <!-- starting of class revw -->
            <div class="revw">

                <!-- display like button and unlike button if user is logged in  -->
                <?php if($this->session->userdata('user_id')): ?>
                    <hr>
                    <?php $liked = FALSE; foreach ($likes as $value):
                         if($value->image_id == $photo_dtl[0]->id ){ $liked = TRUE; }
                    endforeach; ?>

                    <?php if($liked == TRUE): ?>
                        <span onClick="unlike(<?php echo $photo_dtl[0]->id; ?>)" id="unlike<?php echo $photo_dtl[0]->id; ?>">Unlike</span>
                    <?php endif; ?>

                    <?php if($liked == FALSE): ?>
                        <span onClick="like(<?php echo $photo_dtl[0]->id; ?>)" id="like<?php echo $photo_dtl[0]->id; ?>">Like</span>
                    <?php endif; ?>                      
                    <span onClick="like(<?php echo $photo_dtl[0]->id; ?>)" id="likeOpt<?php echo $photo_dtl[0]->id; ?>" style="display: none;">Like</span>
                    <span onClick="unlike(<?php echo $photo_dtl[0]->id; ?>)" id="unlikeOpt<?php echo $photo_dtl[0]->id; ?>" style="display: none;">Unlike</span>
                    
                    <!-- end if of wheter to display like buttons or not -->
                    <?php endif; ?>

                <span onClick="showComments(<?php echo $photo_dtl[0]->id; ?>)">Comments</span>

                 <!-- starting of facebook share button -->
                <!-- <div id="shareBtn" class="btn btn-success clearfix" style="text-decoration: none; color: #9F9F9F; font-size: 14px; line-height: 15px;">Share</div>-->
                 
                <!-- <p style="margin-top: 50px">-->
                <!--  <hr />-->
                <!--  <a class="btn btn-small"  href="https://developers.facebook.com/docs/sharing/reference/share-dialog">Share Dialog Documentation</a>-->
                <!--</p>-->
                

                <span class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url('photo?id=').$controller->encrypt_decrypt('encrypt', $photo_dtl[0]->id); ?>" style="text-decoration: none; color: #9F9F9F; font-size: 14px; line-height: 15px;">Share this on facebook</a></span>
                <!-- Your share button code -->
                <!--  <div class="fb-share-button" -->
                <!--    data-href="<?php echo base_url('photo?id=').$controller->encrypt_decrypt('encrypt', $photo_dtl[0]->id); ?>" -->
                <!--    data-layout="button_count">-->
                <!--  </div>-->
                <!-- end of facebook share button -->

                <br>

                <?php $totalLikes = 0; foreach ($likes_list as $val) {
                    if($val->image_id == $photo_dtl[0]->id ){ $totalLikes++; }
                } ?>

                <span onclick="whoLikeThis(<?php echo $photo_dtl[0]->id; ?>)"><span id="totalLikes<?php echo $photo_dtl[0]->id; ?>"><?php echo $totalLikes; ?></span> people likes this.</span>

                <!-- below div pops up when users want to know who liked their photo -->
                <div id="dialog<?php echo $photo_dtl[0]->id; ?>" class="dialog" title="Liked By" style="display: none;">
                    <?php foreach ($likes_list as $val): ?>
                        <?php if ($val->image_id == $photo_dtl[0]->id): ?>
                            <div style="padding: 5px; border: 1px solid #e1e1e1; width: 100%; height: 65px;">
                                <!-- posting the name and profile_pic of the user whos uploaded the image -->
                                <?php foreach ($user_list as $user): ?>
                                    <?php if($val->liked_by == $user->id): ?>
                                        <!-- this is the link to iser profile -->
                                        <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>">
                                        <?php if($user->profileImage){ ?>
                                            <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                                        <?php }else{ ?>
                                            <img src="images/profdef.png" height="60px;" style="padding: 5px; float: left;">
                                        <?php }?>
                                        <span style="float: right; color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3><br><br>                                        
                                        <!-- end of link to user profile -->
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <!-- end of the name and profile_pic of the user who uploaded the image -->  
                            </div>
                        <?php endif; ?>
                    <?php endforeach ?>
                </div>
                <!-- end div likes -->

                <?php $comment_count = 0; foreach ($comment_list as $comment): 
                    if ($photo_dtl[0]->id == $comment->image_id) {
                        $comment_count++;
                ?>
                <?php } endforeach; ?>

                <span style="float: right;" onClick="showComments(<?php echo $photo_dtl[0]->id; ?>)"><?php echo $comment_count; ?> comments</span>
            </div>
            <!-- end class revw -->
            <?php if($this->session->userdata('user_id')):?>
            <!-- starting of postComment  container -->
            <div class="postComment-container">
                <form id="post_comment">
                    <textarea class="postComment" name="comment" placeholder="Enter a comment." id="comment<?php echo $photo_dtl[0]->id; ?>"></textarea><br>
                    <input type="button" onclick="postComment(<?php echo $photo_dtl[0]->id . ', ' . $photo_dtl[0]->user_id; ?>)" value="Post a comment" class="postButton">
                </form>
            </div>
            <!-- end postComment-container -->
            <?php endif; ?>

            <!-- starting of class comment -->
            <div class="comment" id="comments-show<?php echo $photo_dtl[0]->id; ?>" style="display: none;">
                <!-- starting of class comment-hldr -->
                <?php foreach ($comment_list as $comment): 
                    if ($photo_dtl[0]->id == $comment->image_id) {
                ?>
                <div class="comment-hldr" id="_<?php echo $comment->comment_id; ?>">
                     <?php if( $this->session->userdata('user_id') == $comment->commented_by_id): ?>
                        <div class="comment-buttons-holder" id="_button<?php echo $comment->comment_id; ?>">
                            <ul>
                                <li class="delete-btn" onClick= "comment_delete(<?php echo $comment->comment_id; ?>)">X</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <!-- starting of sm-prof-desc -->
                    <div class="sm-prof-desc">
                        <!-- the profile picture section -->
                            <?php $profilePicExists = false; foreach($profile_pics as $profile_pic): ?>
                                 <?php if($profile_pic->user_id == $comment->commented_by_id){
                                    $profilePicExists = true; ?>
                                    <!-- this is the link to user profile -->
                                    <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$comment->commented_by_id); ?>">
                                    <img src="<?php echo base_url() . $profile_pic->path . '/' .$profile_pic->file_name; ?>" class="user-img-pic"/> 
                                <?php } ?>
                            <?php endforeach; ?>
                            <?php if($profilePicExists == false) : ?>
                            <!-- this is the link to iser profile -->
                            <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$comment->commented_by_id); ?>">
                                <img src="<?php echo base_url('images'); ?>/prof.png" class="user-img-pic"/>
                            </a>
                            <?php endif; ?>
                        <!-- end of profile pic section -->                          
                    </div>  
                    <!-- end of sm-prof-desc-->
                    <div class="comment-hldr-text"><a href="#"><?php echo $comment->commented_by_user_name; ?></a><br>
                        <span><?php echo $comment->comment; ?></span>
                    </div>                                         
                </div>
                <!-- end class comment-hldr -->
                <?php } endforeach; ?>
            </div>
            <!-- end class comment -->
        </div>
        <!-- end class feed -->

    </main>
    </div> 
    <!-- end of the content body -->


</div>
<!-- end div login-page -->

<?php $this->load->view('/includes/footer'); ?>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
  
<script type="text/javascript">

    $(document).ready(function(){
        $('.comment').css('display','block');
    });

    // display the full size image on image click
    $('#image_view').click(function(){
        console.log()
        var img = $(this).attr("src");
        var appear_image = "<div id='appear_image_div' onClick='closeImage()'></div>";
        appear_image    = appear_image.concat("<img id='appear_image' src='"+img+"' />");
        appear_image    = appear_image.concat("<span id='close_img' onClick='closeImage()'>Close</span>")
        $('body').append(appear_image);
    });

    function closeImage(){
        // console.log('Close Image called');
        $('#appear_image_div').remove();
        $('#appear_image').remove();
        $('#close_img').remove();
    }
</script>
