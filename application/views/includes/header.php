<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
    <head>
    <title>Nepalese Photo Competition</title>
    
    <!-- for facebook sharing -->
       <meta property="og:url"           content="https://www.nplespc.com/" />
      <meta property="og:type"          content="website" />
      <meta property="og:title"         content="Nepalese Photo Competition" />
      <meta property="og:description"   content="Upload your best image and win Rs.5000 every month." />
      <meta property="og:image"         content="https://www.nplespc.com/images/bg-fb.png" />
    <!--end of facebook sharing-->
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
    <title>Nepalese Photo Competition</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/home/screen_styles_home.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/home/screen_layout_large_home.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)"  href="<?php echo base_url(); ?>/assets/css/home/screen_layout_small_home.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 800px)"  href="<?php echo base_url(); ?>/assets/css/home/screen_layout_medium_home.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/addProfile/screen_styles_addProfile.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/addProfile/screen_layout_large_addProfile.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)"  href="<?php echo base_url(); ?>/assets/css/addProfile/screen_layout_small_addProfile.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 800px)"  href="<?php echo base_url(); ?>/assets/css/addProfile/screen_layout_medium_addProfile.css" />

     <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/follow/screen_styles_follow.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/follow/screen_layout_large_follow.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)"  href="<?php echo base_url(); ?>assets/css/follow/screen_layout_small_follow.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 800px)"  href="<?php echo base_url(); ?>assets/css/follow/screen_layout_medium_follow.css" />  

    <!-- jquery ui css -->
     <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css" />  

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/profile/screen_styles_profile.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/profile/screen_layout_large_profile.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)"  href="<?php echo base_url(); ?>assets/css/profile/screen_layout_small_profile.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 800px)"  href="<?php echo base_url(); ?>assets/css/profile/screen_layout_medium_profile.css" />
    
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/favicon.ico" />
    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/home.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/follow.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/profile.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notisettings.js"></script>
    <script type="text/javascript" src="//connect.facebook.net/en_US/all.js"></script>

</head>
<body>
    <header>
        <form id="search-form" method="POST" action="<?php echo site_url('/search'); ?>" >
            <input type="text" name="search" id="search-text" style="padding: 3px;"><input type="submit" id="search" value="search">
        </form>
        <ul>
            <li><a href="<?php echo site_url("/home"); ?>">Home</a></li>
            <li><a href="<?php echo site_url("/profile?puk=".$controller->encrypt_decrypt('encrypt',$this->session->userdata('user_id'))); ?>">Profile</a></li>
            <?php $count = 0; foreach ($activity_list as $activity):  ?>
                <!-- get only the activities if this user -->
                <?php if($activity->host_user_id == $this->session->userdata('user_id')): ?>
                    <!-- count only those notification where status is zero -->
                    <?php if($activity->status == 0){
                        $count++;
                    }?>
                <?php endif; ?>
            <?php endforeach; ?>
            <li><a href="#" id="noti"> <?php echo $count; ?> Notification</a></li>
            <li><a href="<?php echo site_url('notification/setting')?>">Settings</a></li>
            <li><a href="<?php echo site_url("/login/logout"); ?>">logout</a></li>
        </ul>
    </header>