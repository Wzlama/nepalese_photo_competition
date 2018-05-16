<!doctype html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
    <title>Nepalese Photo Competition</title>
    
    <!-- for facebook sharing -->
       <meta property="og:url"           content="https://www.nplespc.com/" />
      <meta property="og:type"          content="website" />
      <meta property="og:title"         content="Nepalese Photo Competition" />
      <meta property="og:description"   content="Upload your best image and win Rs.5000 every month." />
      <meta property="og:image"         content="https://www.nplespc.com/images/bg-fb.png" />
    <!--end of facebook sharing-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login/screen_styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login/screen_layout_large.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width: 500px)"  href="<?php echo base_url(); ?>/assets/css/login/screen_layout_small.css" />
    <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width: 800px)"  href="<?php echo base_url(); ?>/assets/css/login/screen_layout_medium.css" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/favicon.ico" />
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/login.js"></script>
    
    </head>
    <body>
        <div class="login-page">
        <header>
            <a href="<?php echo site_url(); ?>" style="text-decoration: none; color: #fff;"><span class="logo">Nepalese Photo Competition</span></a>
            <form class="login-form">
                <label>Email</label>
                <input class="_mdScrn _smscrn" type="text" name="email_sign_in" value="" placeholder="Enter your email address." id="userEmail">
                <label>Password</label>
                <input class="_mdScrn _smscrn" type="password" name="password_sign_in" value="" placeholder="Enter your password." id="userPassword"> 
                <input type="submit" name="login" value="login">
                <br>
                <span><a href="<?php echo 'login/forgot'; ?>">Forgot Your Password</a></span>
                    <?php if(isset($$msg) && $msg == 'Casdfasdfsaf123244sadf3241'): ?>
                        <span style="color: orange; font-size: 12px;">Password successfully changed.</span>
                    <?php endif; ?>
                    <span id="email_sign_in" style="color: red; font-size: 12px;"></span>
                    <span id="pass_ch" style="color: red; font-size: 12px;"></span>
            </form>
        </header>
        <!-- end header -->
        