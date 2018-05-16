<?php $this->load->view('/includes/header'); ?>

<div class="change-profile-page">

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>

<div class="ch-profile-hldr">
    <div class="ch-profile-header">
        <h3>Step 3:  Subscribe to some of the best Photographers of Nepal.</h3>
    </div>
    <div class="main-body">
        <div class="nothing">
        <?php $sad = $this->session->all_userdata();
              foreach($users_list as $user):
              if($user->id != $sad['user_id']):?>
                <div class="follow-np" id="user<?php echo $user->id; ?>">
                    <div class="prof-img-follow">
                    <?php if($user->profileImage != ''){ ?>
                        <!-- link to redirect to user profile -->
                        <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>" style="text-decoration: none;">
                            <img src="<?php echo base_url().'profile_pic/'. $user->first_name .' ' . $user->last_name .'/'. $user->profileImage; ?>"> 
                        <!-- end link to user pofile -->
                        </a>
                    <?php }else{ ?>
                    <!-- link to redirect to user profile -->
                    <a href="<?php echo site_url('profile/view_user_profile')?>?user_id=<?php echo $controller->encrypt_decrypt('encrypt',$user->id); ?>" style="text-decoration: none;">
                        <img src="images/profdef.png">
                    <!-- end link to user profile -->
                    </a>
                    <?php } ?>
                    </div>
                    <div class="desc-follow">
                        <span class="philo"><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
                        <a class="btn-sub" id="follow<?php echo $user->id; ?>" onClick="follow(<?php echo $sad['user_id']; ?>,<?php echo $user->id; ?>)">Subscribe</a>
                    </div>                            
                </div>
                <!-- end follow -->
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
        <div class="clear-fix"></div>
    </div>
    <!-- end main body -->
        <a href="home" class="btn-skip">Next>></a>
</div>
<!-- end ch-profile-hldr -->
</div>
<!-- end div change-profile-page -->

<?php $this->load->view('/includes/footer'); ?>
