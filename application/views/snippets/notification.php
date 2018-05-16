<div class="notification">
    <div class="notification-max-height">
        <h4 style="text-align: center; color: #3b5998;">Notifications</h4>
        <hr>
        <ul style="list-style: bullet;">
            <?php foreach ($activity_list as $activity): ?>
                <!-- get only the activities if this user -->
                    <?php //var_dump($this->session->userdata('user_id')); ?>
                <?php if($activity->host_user_id == $this->session->userdata('user_id')): ?>
                    <a href="photo?id=<?php echo encrypt_decrypt('encrypt',$activity->post_id); ?>" style="text-decoration: none;" id="noti-anchor"><li style="border-bottom: 1px solid #fff; color: #9F9F9F; font-size: 12px; padding-left: 40px;"><?php echo $activity->donor_user_name . ' ' . $activity->activity . '     your photo.'?></li></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>        
    </div>
    <a href="<?php echo site_url('notification'); ?>" class="see-more"><h3>See All</h3>
</div>

 <?php 
     function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
      } 
?>