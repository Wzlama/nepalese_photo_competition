<?php $this->load->view('/includes/header'); ?>

<div class="home-page">
    <!-- end of header -->

     <!-- starting of the side bar left -->
    <div class="leftBar">
        <div class="side01 active">News Feed.</div>            
        <div class="side02">Popular Photos of this month.</div>
        <div class="side03">
        <?php $total_image_upto_now = count($pop_img); ?>
        <?php for($i=0;$i<$total_image_upto_now;$i++){ ?>            
            <?php if(!empty($pop_img[$i][0])): ?>
                <a href="<?php echo site_url('photo'); ?>?id=<?php echo $controller->encrypt_decrypt('encrypt',$pop_img[$i][0]->id); ?>">
                    <img src="<?php echo $pop_img[$i][0]->full_path .'/'. $pop_img[$i][0]->name; ?>" style="width: 65px; height: 55px;">
                </a>
            <?php endif; ?>
        <?php } ?>
        </div>
        <div class="side04">Trending</div>
        <div class="side05">
            <?php foreach ($activity_list as $value) : ?>
                <div class="activity_wraper">
                    <?php foreach ($user_list as $user): ?>
                        <?php if($value->donor_user_id == $user->id): ?>
                            <?php if($user->profileImage){ ?>
                                <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" style="padding: 5px; float: left; border-radius: 50%;"width="33px" height="31px">
                            <?php }else{ ?>
                                <img src="images/profdef.png" style="padding: 5px; float: left; border-radius: 50%;" height=30px;">
                            <?php }?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <a href="<?php echo site_url('photo'); ?>?id=<?php echo $controller->encrypt_decrypt('encrypt',$value->post_id); ?>" style="text-decoration: none; color: #9F9F9F"><?php echo $value->donor_user_name . ' ' . $value->activity .' a photo.'; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end of the side bar left -->
    <div class="clear-fix"></div>

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>


    <!-- starting of div content -->
    <div class="_content">
        <?php if($message != ''): ?>
            <span id="email_sign_in" style="color: red; font-size: 12px;"><?php echo $message; ?></span>
        <?php endif; ?>
        <?php if($message_success != ''): ?>
            <span id="email_sign_in" style="color: green; font-size: 12px;"><?php echo $message_success; ?></span>
        <?php endif; ?>
        <div class="postContainer">
            <div class="uploadImg"><h3>Upload Your Image Here.<h3></div>
            <hr>
            <div class="imagePreview"  id="imgPreview"></div>
            <div class="uploadForm">
                <form action="home/upload" method="post" enctype="multipart/form-data" id="upload_form">
                    <input id ="caption" type="text" name="caption" placeholder="Enter description about the image here!" /><br/>
                    <input type="file" name="imgupload" id="imgupload" multiple="multiple"/>
                    <input id="btn-post" type="submit" name="post" value="Post">
                    <div class="clear-fix"></div>
                </form>
            </div>
            <!-- end uploadForm -->
        </div>
        <!-- end postContainer here -->
        <div class="clear-fix"></div>


        <!-- starting of div feed -->
        <div class="feed">
            <!-- statrting of the post for last month best image -->
            <?php if(date('d') <= "08" && !empty($last_month_pop_img)): ?>
                <div class="container">
                    <h3 style="text-align: center;">Winner of last month</h3>
                     <!-- starting of divprofileDesc -->
                    <div class="profileDesc">
                        <!-- posting the name and profile_pic of the user whos uploaded the image -->
                        <?php foreach ($user_list as $user): ?>
                            <?php if(($last_month_pop_img[0]->user_id == $user->id)): ?>
                                <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>" style="text-decoration: none;">
                                <?php if($user->profileImage){ ?>
                                    <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                                <?php }else{ ?>
                                    <img src="images/profdef.png" height="60px;" style="padding: 5px; float: left;">
                                <?php }?>
                                <span style="color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3><br><br>
                            <?php endif; ?>
                        <?php endforeach; ?></a>
                        <!-- end of the name and profile_pic of the user who uploaded the image -->

                        <span style="color: #e1e1e1; font-size: 12px; line-height: 10px;">Published on: <?php echo $last_month_pop_img[0]->created_at; ?></span>
                        <div class="clear-fix"></div>
                    </div>
                    <!-- end div profileDesc -->

                    <!-- starting of div feedContent -->
                    <div class="feedContent">

                        <!-- starting of class img-desc -->
                        <div class="img-desc"><?php echo $last_month_pop_img[0]->caption?></div>
                        <!-- end div caption -->

                        <!-- starting of div img-hldr -->
                        <div class="img-hldr">
                            <img src="<?php echo $last_month_pop_img[0]->full_path .'/'. $last_month_pop_img[0]->name; ?>" width="80%">
                        </div>
                        <!-- end div img-hldr -->

                        <div class="clear-fix"></div>
                    </div>
                    <!-- end class feedContent -->

                    <!-- starting of class revw -->
                    <div class="revw">
                        <hr>
                        <?php $sad = $this->session->all_userdata(); ?>

                        <?php $totalLikes = 0; foreach ($likes_list_prev as $val) {
                            if($val->image_id == $last_month_pop_img[0]->id ){ $totalLikes++; }
                        } ?>
                        <span onclick="whoLikeThis(<?php echo $last_month_pop_img[0]->id; ?>)"><span id="totalLikes<?php echo $last_month_pop_img[0]->id; ?>"><?php echo $totalLikes; ?></span> people likes this.</span>

                        <!-- below div pops up when users want to know who liked their photo -->
                        <div id="dialog<?php echo $last_month_pop_img[0]->id; ?>" class="dialog" title="Liked By" style="display: none;">
                            <?php foreach ($likes_list_prev as $val): ?>
                                <?php if ($val->image_id == $last_month_pop_img[0]->id): ?>
                                    <div style="padding: 5px; border: 1px solid #e1e1e1; width: 97%; height: 65px;">
                                        <!-- posting the name and profile_pic of the user whos uploaded the image -->
                                        <?php foreach ($user_list as $user): ?>
                                            <?php if($val->liked_by == $user->id): ?>
                                                <!-- this is the link to iser profile -->
                                                <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>">
                                                <?php if($user->profileImage){ ?>
                                                    <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left; width: 61px;">
                                                <?php }else{ ?>
                                                    <img src="images/profdef.png" height="60px;" style="padding: 5px; float: left; width: 61px;">
                                                <?php }?>
                                                <span style="float: right; color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3><br><br>
                                            <?php endif; ?>
                                            <!-- end of link to user profile -->
                                            </a>
                                        <?php endforeach; ?>
                                        <!-- end of the name and profile_pic of the user who uploaded the image -->  
                                    </div>
                                <?php endif; ?>
                            <?php endforeach ?>
                        </div>
                        <!-- end div likes -->

                        <?php $comment_count = 0; foreach ($comment_list_prev as $comment): 
                            if ($last_month_pop_img[0]->id == $comment->image_id) {
                                $comment_count++;
                        ?>
                        <?php } endforeach; ?>

                        <span style="float: right;" onClick="showComments(<?php echo $last_month_pop_img[0]->id; ?>)"><?php echo $comment_count; ?> comments</span>
                    </div>
                    <!-- end class revw -->

                    <!-- starting of class comment -->
                    <div class="comment" id="comments-show<?php echo $last_month_pop_img[0]->id; ?>">
                        <!-- starting of class comment-hldr -->
                        <?php foreach ($comment_list_prev as $comment): 
                            if ($last_month_pop_img[0]->id == $comment->image_id) {
                        ?>
                        <div class="comment-hldr" id="_<?php echo $comment->comment_id; ?>">
                             <?php if( $sad['user_id'] == $comment->commented_by_id): ?>
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
                 <!-- end class container -->
            <?php endif; ?>
            <!-- starting of div container -->

            <?php foreach($image_list as $image):  ?>
            <div class="container">
             <!-- starting of divprofileDesc -->
                <div class="profileDesc">

                    <!-- posting the name and profile_pic of the user whos uploaded the image -->
                    <?php foreach ($user_list as $user): ?>
                        <?php if($image->user_id == $user->id): ?>
                            <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>" style="text-decoration: none;">
                            <?php if($user->profileImage){ ?>
                                <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                            <?php }else{ ?>
                                <img src="images/profdef.png" height="60px;" style="padding: 5px; float: left;">
                            <?php }?>
                            <span style="color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3><br><br>
                        <?php endif; ?>
                    <?php endforeach; ?></a>
                    <!-- end of the name and profile_pic of the user who uploaded the image -->

                    <span style="color: #e1e1e1; font-size: 12px; line-height: 10px;">Published on: <?php echo $image->created_at; ?></span>
                    <div class="clear-fix"></div>
                </div>
                <!-- end div profileDesc -->

                <!-- starting of div feedContent -->
                <div class="feedContent">

                    <!-- starting of class img-desc -->
                    <div class="img-desc"><?php echo $image->caption?></div>
                    <!-- end div caption -->

                    <!-- starting of div img-hldr -->
                    <a href="<?php echo site_url('photo'); ?>?id=<?php echo $controller->encrypt_decrypt('encrypt',$image->id); ?>"><div class="img-hldr">
                        <img src="<?php echo $image->full_path .'/'. $image->name; ?>" width="80%">
                    </div></a>
                    <!-- end div img-hldr -->

                    <div class="clear-fix"></div>
                </div>
                <!-- end class feedContent -->

                <!-- starting of class revw -->
                <div class="revw">
                    <hr>
                    <?php $sad = $this->session->all_userdata(); ?>
                    <?php $liked = FALSE; foreach ($likes as $value):
                         if($value->image_id == $image->id ){ $liked = TRUE; }
                    endforeach; ?>

                    <?php if($liked == TRUE): ?>
                        <span onClick="unlike(<?php echo $image->id; ?>)" id="unlike<?php echo $image->id; ?>">Unlike</span>
                    <?php endif; ?>

                    <?php if($liked == FALSE): ?>
                        <span onClick="like(<?php echo $image->id; ?>)" id="like<?php echo $image->id; ?>">Like</span>
                    <?php endif; ?>                      
                    <span onClick="like(<?php echo $image->id; ?>)" id="likeOpt<?php echo $image->id; ?>" style="display: none;">Like</span>
                    <span onClick="unlike(<?php echo $image->id; ?>)" id="unlikeOpt<?php echo $image->id; ?>" style="display: none;">Unlike</span>

                    <span onClick="showComments(<?php echo $image->id; ?>)">Comments</span>

                    <!-- starting of facebook share button -->
                    <span class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url('photo?id=').$controller->encrypt_decrypt('encrypt', $image->id); ?>" style="text-decoration: none; color: #9F9F9F; font-size: 14px; line-height: 15px;">Share this on facebook</a></span>
                    <!-- end of facebook share button -->

                    <br>

                    <?php $totalLikes = 0; foreach ($likes_list as $val) {
                        if($val->image_id == $image->id ){ $totalLikes++; }
                    } ?>
                    <span onclick="whoLikeThis(<?php echo $image->id; ?>)"><span id="totalLikes<?php echo $image->id; ?>"><?php echo $totalLikes; ?></span> people likes this.</span>

                    <!-- below div pops up when users want to know who liked their photo -->
                    <div id="dialog<?php echo $image->id; ?>" class="dialog" title="Liked By" style="display: none;">
                        <?php foreach ($likes_list as $val): ?>
                            <?php if ($val->image_id == $image->id): ?>
                                <div style="padding: 5px; border: 1px solid #e1e1e1; width: 97%; height: 65px;">
                                    <!-- posting the name and profile_pic of the user whos uploaded the image -->
                                    <?php foreach ($user_list as $user): ?>
                                        <?php if($val->liked_by == $user->id): ?>
                                            <!-- this is the link to iser profile -->
                                            <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>">
                                            <?php if($user->profileImage){ ?>
                                                <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left; width: 61px;">
                                            <?php }else{ ?>
                                                <img src="images/profdef.png" height="60px;" style="padding: 5px; float: left; width: 61px;">
                                            <?php }?>
                                            <span style="float: right; color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3><br><br>
                                        <?php endif; ?>
                                        <!-- end of link to user profile -->
                                        </a>
                                    <?php endforeach; ?>
                                    <!-- end of the name and profile_pic of the user who uploaded the image -->  
                                </div>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </div>
                    <!-- end div likes -->

                    <?php $comment_count = 0; foreach ($comment_list as $comment): 
                        if ($image->id == $comment->image_id) {
                            $comment_count++;
                    ?>
                    <?php } endforeach; ?>

                    <span style="float: right;" onClick="showComments(<?php echo $image->id; ?>)"><?php echo $comment_count; ?> comments</span>
                </div>
                <!-- end class revw -->

                <!-- starting of postComment  container -->
                <div class="postComment-container">
                    <form id="post_comment">
                        <textarea class="postComment" name="comment" placeholder="Enter a comment." id="comment<?php echo $image->id; ?>"></textarea><br>
                        <input type="button" onclick="postComment(<?php echo $image->id .', ' . $image->user_id; ?>)" value="Post a comment" class="postButton">
                    </form>
                </div>
                <!-- end postComment-container -->

                <!-- starting of class comment -->
                <div class="comment" id="comments-show<?php echo $image->id; ?>" style="display: none;">
                    <!-- starting of class comment-hldr -->
                    <?php foreach ($comment_list as $comment): 
                        if ($image->id == $comment->image_id) {
                    ?>
                    <div class="comment-hldr" id="_<?php echo $comment->comment_id; ?>">
                         <?php if( $sad['user_id'] == $comment->commented_by_id): ?>
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
             <!-- end class container -->
             <?Php endforeach; ?>
        </div>
        <!-- end of class feed -->

    </div>
    <!-- end div content -->
    <div class="clear-fix"></div>

    <div class="right-nav-bar n1h">
        <h1>Yantra Soluton pvt.ltd</h1>
        <hr>
        <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
        <hr>
        <h3>Contact Us: 01-44141414</h3>
    </div>

    <div class="right-nav-bar n2h">
        <h1>Care for us pvt.ltd</h1>
        <hr>
        <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
        <hr>
        <h3>Contact Us: 01-554719</h3>
    </div>

    <div class="right-nav-bar n3h">
        <h1>New technology pvt.ltd</h1>
        <hr>
        <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
        <hr>
        <h3>Contact Us: 01-222123</h3>
    </div>
    
    <div class="right-nav-bar n4h">
        <h1>New technology pvt.ltd</h1>
        <hr>
        <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
        <hr>
        <h3>Contact Us: 01-222123</h3>
    </div>

</div>
<!-- end div home page -->
<?php $this->load->view('/includes/footer'); ?>
