<?php $this->load->view('/includes/header'); ?>

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>

<div class="change-profile-page">
	<div class="_notifications">
		<h3 style="color:#fff;">Notifications </h3>
	    <ul>
	        <?php foreach ($activity_list as $activity): ?>
	            <?php if($activity->host_user_id == $this->session->userdata('user_id')): ?>
	                <a href="photo?id=<?php echo encrypt_decrypt('encrypt',$activity->post_id); ?>" style="text-decoration: none;"><li><span><?php echo $activity->donor_user_name . ' ' . $activity->activity . ' your photo.'?></span></li></a>
	            <?php endif; ?>
	        <?php endforeach; ?>
	    </ul>
	</div>
	<!-- _notifications ends here -->
</div>
<!-- end div change-profile-page -->

<?php $this->load->view('/includes/footer'); ?>
