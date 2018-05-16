<?php $this->load->view('/includes/header_public'); ?>
<div class="content">
    <section  class="signup">
        <h5 style="color: grey">Please add email add.</h5>

        <form class="change-pwd-form" action="login/creat_new_password" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input  type="text" name="password" value="" placeholder="Enter Your New Password.">
            <br>
            <br>
            <input  type="text" name="confirm_password" value="" placeholder="Enter Your New Password Again.">

           <p id="confirm_password" style="color: red;"></p>

            <input class="input-area" type="submit" name="submit" value="Submit" style="max-width: 150px;">
        </form>
    </section>
    <!-- end section signup -->

    <section class="promo">
            <img src="<?php echo base_url(); ?>images/bg.png">
    </section>
    <!-- end section promo -->
</div>
<div class="clear-fix"></div>
<!-- end class content -->
<?php $this->load->view('/includes/footer_public'); ?>
