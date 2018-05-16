<?php $sad = $this->session->userdata();
    if(isset($sad['user_id'])) {
        $this->load->view('/includes/header'); 
    }else{ 
        $this->load->view('/includes/header_no_login_public');
    }
?>

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>

<div class="change-profile-page">

<!-- check if it is your profile -->
<?php if($user_id == $this->session->userdata('user_id')){ redirect('profile'); } ?>

<div class="profile-page">
                <!-- posting the name and profile_pic of the user whos uploaded the image -->
                <?php foreach ($user_list as $user): ?>
                    <?php if($user->id == $user_id): ?>
                        <?php if($user->coverImage){ ?>                            
                            <!-- end of header -->
                            <div class="cover">
                                <img src="<?php echo site_url('cover_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->coverImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                            </div>
                            <!-- check to see if user is logged in -->
                            <?php if(isset($sad['user_id'])): ?>

                                <?php $follow = FALSE; foreach ($followed_photographers as $follow_these): ?>
                                    <?php if( $follow_these->user_id == $user_id): $follow = true;?>
                                        <div class="sub-btn" onClick="unsubscribe(<?php echo $user->id; ?>)">
                                            <span id="sub_text">Unsubscribe</span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php if($follow == FALSE): ?>
                                    <div class="sub-btn" onClick="subscribe(<?php echo $sad['user_id'] .',\'' .$sad['first_name'] . '\',\'' . $sad['last_name'] . '\',\'' . $sad['email_address'] . '\',' . $user_id; ?>)">
                                            <span id="sub_text">Subscribe</span>
                                        </div>
                                <?php endif; ?>

                            <!-- checking finished if user is looged in -->
                            <?php endif; ?>
                        <?php }else{ ?>
                            <!-- end of header -->
                            <div class="cover">
                                <img src="<?php echo site_url(); ?>images/wall.png">
                            </div>

                            <!-- check to see if user is logged in -->
                            <?php if(isset($sad['user_id'])): ?>
                               <?php $follow = FALSE; foreach ($followed_photographers as $follow_these): ?>
                                    <?php if( $follow_these->user_id == $user_id): $follow = true;?>
                                        <div class="sub-btn" onClick="unsubscribe(<?php echo $user->id; ?>)">
                                            <span id="sub_text">Unsubscribe</span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php if($follow == FALSE): ?>
                                    <div class="sub-btn" onClick="subscribe(<?php echo $sad['user_id'] .',\'' .$sad['first_name'] . '\',\'' . $sad['last_name'] . '\',\'' . $sad['email_address'] . '\',' . $user_id; ?>)">
                                            <span id="sub_text">Subscribe</span>
                                        </div>
                                <?php endif; ?> 
                            <!-- checking finished if user is looged in -->
                            <?php endif; ?>
                        <?php } ?>
                            <!-- begin of new-idea -->
                            <div class="new-idea" style="padding-top: 53px;">  
                            <?php if($user->profileImage){ ?>
                                <div class="profile-pic">
                                    <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                                </div>
                            <?php }else{ ?> 
                                <div class="profile-pic">
                                    <img src="<?php echo site_url(); ?>images/profdef.png" height="60px;" style="padding: 5px; float: left;">
                                </div>
                            <?php }?>
                                <div class="username"><a href="<?php echo site_url('profile/view_user_profile?user_id=') . $controller->encrypt_decrypt('encrypt',$user->id); ?>"><?php echo $user->first_name . '<br/> ' . $user->last_name; ?></a></div>                                
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- end of the name and profile_pic of the user who uploaded the image -->

                                <div class="timeline">Timeline</div>
                                <div class="about">About</div>
                                <div class="photos">Photos</div>
                                <div class="subscribed">Subscribed</div>

                            </div>
                            <!-- end div new-idea -->

            <!-- timeline section begins -->
            <div class="timelinex">
            <?php foreach($my_image_list as $image):  ?>
                    <div class="profileDesc">
                        <!-- posting the name and profile_pic of the user whos uploaded the image -->
                        <?php foreach ($user_list as $user): ?>
                            <?php if($image->user_id == $user->id): ?>
                                <?php if($user->profileImage){ ?>
                                    <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                                <?php }else{ ?>
                                    <img src="<?php echo site_url(); ?>images/profdef.png" height="60px;" style="padding: 5px; float: left;">
                                <?php }?>
                                <span style="float: left; color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3><br><br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <!-- end of the name and profile_pic of the user who uploaded the image -->
                        
                        <span style="color: #e1e1e1; font-size: 12px; line-height: 10px;">Published on: <?php echo $image->created_at; ?></span>

                    </div>
                    <!-- end class profileDesc -->

                    <div class="feedContent">
                        <div class="img-desc"><?php echo $image->caption; ?></div>
                        <!-- end div caption -->

                        <div class="img-hldr">
                            <!-- check if we need to provide full url in production site -->
                            <a href="<?php echo site_url('photo'); ?>?id=<?php echo $controller->encrypt_decrypt('encrypt',$image->id); ?>"><img src="<?php echo $image->full_path .'/'. $image->name; ?>" width="80%"></a>
                        </div>
                        <!-- end class img-hldr -->
                    </div>
                    <!-- end class feedContent -->

                    <!-- starting of class revw -->
                    <div class="revw">
                        <hr>
                        <!-- check if user is logged in -->
                        <?php if(isset($sad['user_id'])): ?>
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

                            <span onClick="showComments(<?php echo $image->id; ?>)">Comments</span><br>

                        <?php endif; ?>
                        <!-- end of checking of user loggedin -->

                        <?php $totalLikes = 0; foreach ($likes_list as $val) {
                            if($val->image_id == $image->id ){ $totalLikes++; }
                        } ?>
                        <span onclick="whoLikeThis(<?php echo $image->id; ?>)"><span id="totalLikes<?php echo $image->id; ?>"><?php echo $totalLikes; ?></span> people likes this.</span>

                        <!-- below div pops up when users want to know who liked their photo -->
                        <div id="dialog<?php echo $image->id; ?>" class="dialog" title="Liked By" style="display: none;">
                            <?php foreach ($likes_list as $val): ?>
                                <?php if ($val->image_id == $image->id): ?>
                                    <div style="padding: 5px; border: 1px solid #e1e1e1; width: 100%; height: 65px;">
                                        <!-- posting the name and profile_pic of the user whos uploaded the image -->
                                        <?php foreach ($user_list as $user): ?>
                                            <?php if($val->liked_by == $user->id): ?>
                                             <!-- this is the link to iser profile -->
                                            <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>">
                                                <?php if($user->profileImage){ ?>
                                                    <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" height="60px;" style="padding: 5px; float: left;">
                                                <?php }else{ ?>
                                                    <img src="<?php echo site_url(); ?>images/profdef.png" height="60px;" style="padding: 5px; float: left;">
                                                <?php }?>
                                                <span style="float: left; color: #3b5998; font-size: 16px; line-height: 10px;  margin: 15px 0 0 0;"><?php echo $user->first_name . ' ' . $user->last_name; ?></h3><br><br>
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

                        <!-- starting of facebook share button -->
                        <span class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url('photo?id=').$controller->encrypt_decrypt('encrypt', $image->id); ?>" style="text-decoration: none; color: #9F9F9F; font-size: 14px; line-height: 15px;">Share this on facebook</a></span>
                        <!-- end of facebook share button -->
                    </div>
                    <!-- end class revw -->

                    <?php if(isset($sad['user_id'])): ?>
                        <!-- starting of postComment  container -->
                        <div class="postComment-container">
                            <form id="post_comment">
                                <textarea class="postComment" name="comment" placeholder="Enter a comment." id="comment<?php echo $image->id; ?>"></textarea><br>
                                <input type="button" onclick="postComment(<?php echo $image->id .', ' . $image->user_id; ?>)" value="Post a comment" class="postButton">
                            </form>
                        </div>
                        <!-- end postComment-container -->
                    <?php endif; ?>

                    <!-- starting of class comment -->
                    <div class="comment" id="comments-show<?php echo $image->id; ?>" style="display: none;">
                        <!-- starting of class comment-hldr -->
                        <?php foreach ($comment_list as $comment): 
                            if ($image->id == $comment->image_id) {
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
                                    <!-- this is the link to user profile -->
                                    <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$comment->commented_by_id); ?>">
                                        <img src="<?php echo base_url('images'); ?>/profdef.png" class="user-img-pic"/>
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
            <?php endforeach; ?>

            </div>
            <!-- timeline section ends -->

            <!-- about section begins -->
                <div class="aboutx">
                    <div class="header-aboutx">
                        About
                    </div>
                    <div class="about-main">
                        <div class="info-usr">
                            <h3><?php foreach($user_list as $user): ?>
                                <?php if($user->id == $user_id): ?>
                                    <?php echo $user->first_name . ' ' . $user->last_name; ?>
                                <?php endif; ?>
                            <?php endforeach; ?></h3>
                            <form class="user-info" id="about_form">
                                <div class="form-group">
                                    <label for="dob">Date Of Birth</label><br>
                                    <?php foreach($user_list as $user): ?>
                                        <?php if($user->id == $this->session->userdata('user_id')){ ?>
                                            <input type="text" name="dob" id="dob" value="<?php echo $user->date_of_birth; ?>" class="form-control" readonly>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </div>

                                <!-- end div form-group -->
                                <div class="form-group">
                                    <label for="edu">Education</label><br>
                                    <?php if($user_info): ?>
                                         <input type="text" id="education" name="education" value="<?php echo $user_info[0]->education; ?>" class="form-control" readonly>
                                    <?php else: ?>
                                        <input type="text" id="education" name="education" value="Education" class="form-control" readonly>
                                    <?php endif; ?>
                                </div>
                                <!-- end div form-group -->

                                <div class="form-group">
                                    <label for="intrests">Intrests</label><br>
                                    <?php if($user_info): ?>
                                        <input type="text" id="intrests" name="intrests" value="<?php echo $user_info[0]->intrest; ?>" class="form-control" readonly>
                                    <?php else: ?>
                                        <input type="text" id="intrests" name="intrests" value="Intrests." class="form-control" readonly>
                                    <?php endif; ?>
                                </div>
                                <!-- end group form group -->

                                <div class="form-group">
                                    <label for="dob">Photography Philosophy</label><br>
                                    <?php if($user_info): ?>
                                        <textarea class="form-control txt" id="philosophy" name="philosophy" readonly><?php echo $user_info[0]->philosophy; ?></textarea>
                                    <?php else: ?>
                                        <textarea class="form-control txt" id="philosophy" name="philosophy" readonly>Your philosophy about Photography.</textarea>
                                    <?php endif; ?>
                                </div>
                                <!-- end group form-group -->
                            </form>
                            <!-- end form -->
                        </div>
                        <div class="prof-usr">
                            <!-- posting the name and profile_pic of the user whos uploaded the image -->
                            <?php foreach ($user_list as $user): ?>
                                <?php if($user_id == $user->id): ?>
                                    <?php if($user->profileImage){ ?>
                                        <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" style="padding-top: 25px; float: left;">
                                    <?php }else{ ?>
                                        <img src="<?php echo site_url(); ?>images/profdef.png" style="padding-top: 25px; float: left;">
                                    <?php }?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- end about main -->
                </div>
            <!-- about section ends -->

            <!-- Subscribed Section begins -->
                <div class="subscribedx" style="max-height: 675px;">
                    <div class="header-aboutx">
                        Subscribed
                    </div>
                    <div class="sub-hldr" style="max-height: 195px;">
                    <?php foreach($subscribed_photographers as $sub_channel): ?>
                            <?php foreach ($user_list as $user): ?>
                                <?php if($sub_channel->user_id == $user->id): ?>
                                    <div class="subscribed-hldr" id="<?php echo $user->id; ?>_un">
                                        <?php if($user->profileImage){ ?>
                                        <!-- link to redirect to user profile -->
                                        <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>" style="text-decoration: none;">
                                            <div class="prof-img">  
                                                <img src="<?php echo site_url('profile_pic').'/'.$user->first_name . ' ' . $user->last_name . '/' . $user->profileImage ; ?>" style="padding-top: 25px;">
                                            </div>
                                        </a>
                                        <?php }else{ ?>
                                        <!-- link to redirect to user profile -->
                                        <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>" style="text-decoration: none;">
                                            <div class="prof-img">  
                                                <img src="<?php echo site_url(); ?>images/profdef.png" style="padding-top: 25px;">
                                             </div>
                                        <!-- end link to user profile -->
                                        </a>
                                        <?php }?>
                                        <span><?php echo $user->first_name . ' ' . $user->last_name;?></span>
                                    </div>
                                    <!-- end class subscribed hldr-->
                                <?php endif; ?>
                            <?php endforeach; ?>
                    <?php endforeach; ?>
                    </div>
                    <?php if(count($subscribed_photographers) > 3): ?>
                        <!-- show seemore if there are user is subscribed to more than 3 users -->
                        <span id="seemore" style="cursor: pointer; color: #e1e1e1;">See more...</span>
                    <?php endif; ?>
                    <!-- end class sub-hldr -->
                </div>
            <!-- subscribed section Ends -->

            <!-- photo section begins -->
                <div class="photosx">
                    <div class="header-aboutx">
                        Photos<br>
                        <?php foreach ($user_list as $user): ?>
                            <?php if($user->id == $user_id): ?>
                                <span style="font-size: 12px;"><?php echo $user->first_name . ' ' . $user->last_name; ?>'s Photo's For This Month</span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php foreach($my_image_list as $image): ?>
                    <div class="user-img-hldr">
                         <a href="<?php echo site_url('photo'); ?>?id=<?php echo $controller->encrypt_decrypt('encrypt',$image->id); ?>">
                            <div class="view-img">
                                <img src="<?php echo $image->full_path .'/'. $image->name; ?>">
                            </div>
                        </a>
                    </div>
                    <!-- end class user-img-hldr -->
                    <?php endforeach ?>
                </div>
            <!-- photo section ends -->
        </div>
        <!-- end div home page -->

        <div class="profile-right-nav-bar n1">
            <h1>Problem Solver pvt.ltd</h1>
            <hr>
            <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
            <hr>
            <h3>Contact Us: 01-44141414</h3>
        </div>
    
        <div class="profile-right-nav-bar n2">
            <h1>Care for us pvt.ltd</h1>
            <hr>
            <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
            <hr>
            <h3>Contact Us: 01-554719</h3>
        </div>
    
        <div class="profile-right-nav-bar n3">
            <h1>New technology pvt.ltd</h1>
            <hr>
            <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
            <hr>
            <h3>Contact Us: 01-222123</h3>
        </div>
        
        <div class="profile-right-nav-bar n4">
            <h1>New technology pvt.ltd</h1>
            <hr>
            <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
            <hr>
            <h3>Contact Us: 01-222123</h3>
        </div>
        
        <div class="profile-right-nav-bar n5">
            <h1>New technology pvt.ltd</h1>
            <hr>
            <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
            <hr>
            <h3>Contact Us: 01-222123</h3>
        </div>
        
        <div class="profile-right-nav-bar n6">
            <h1>New technology pvt.ltd</h1>
            <hr>
            <p>We deal with all the hardware and software maintainance, security and other stuffs with your organization</p>
            <hr>
            <h3>Contact Us: 01-222123</h3>
        </div>
<?php $this->load->view('/includes/footer'); ?>
