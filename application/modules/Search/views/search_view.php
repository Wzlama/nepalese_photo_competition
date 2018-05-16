<?php $this->load->view('/includes/header'); ?>

<div class="change-profile-page">

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>

<div class="ch-profile-hldr">
    <div class="ch-profile-header">
        <h3>Popular Photographers Of Nepal.</h3>
    </div>
    <div class="main-body">
    
        <?php $sad = $this->session->all_userdata();
	      	foreach($user_info as $user):
	            if($user->id != $sad['user_id']):?>
	        	<a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>">
        			<div class="nothing">
		                <div class="follow-np" id="user<?php echo $user->id; ?>">
		                    <div class="prof-img-follow">
		                    <?php if($user->profileImage != ''){ ?>
		                        <img src="<?php echo base_url().'profile_pic/'. $user->first_name .' ' . $user->last_name .'/'. $user->profileImage; ?>"> 
		                    <?php }else{ ?>
		                        <img src="images/profdef.png">
		                    <?php } ?>
		                    </div>
		                    <div class="desc-follow">
		                        <span class="philo"><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
		                        <?php $following = FALSE; foreach ($subscribed_photographers as $subs):
									if($subs->user_id == $user->id){ $following = TRUE; } ?>
		                        <?php endforeach; ?>
		                        <?php if($following){ ?>
		                        	<!-- <a class="btn-sub" id="follow<?php echo $user->id; ?>" onClick="unsubscribe(<?php echo $user->id; ?>)">Unsubscribe</a> -->
		                        <?php }else{ ?>
		                       		 <!-- <a class="btn-sub" id="follow<?php echo $user->id; ?>" onClick="follow(<?php echo $sad['user_id']; ?>,<?php echo $user->id; ?>)">Subscribe</a> -->
		                        <?php }?>
		                    </div>                            
		                </div>
		                <!-- end follow -->
		            <?php endif; ?>
				<?php endforeach; ?>
					<?php if(empty($user_info)): ?>
						<span>Sorry could not find your photographer. Try again with different name.</span>
					<?php endif; ?>
				    </div>
				    <!-- end of the div element -->
				</a>
        <div class="clear-fix"></div>
    </div>
    <!-- end main body -->
</div>
<!-- end ch-profile-hldr -->
</div>
<!-- end div change-profile-page -->

<?php $this->load->view('/includes/footer'); ?>
