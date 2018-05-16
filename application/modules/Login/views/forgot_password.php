<?php $this->load->view('/includes/header_public'); ?>
<div class="content">
    <section  class="signup">
        <h5 style="color: grey">Enter email add.</h5>
        <form class="forgot_pwd_email" method="post">
            <input  type="text" name="email" value="" placeholder="Enter Your email address.">
           <p id="email" style="color: orange;"></p>

            <input class="input-area" type="submit" name="submit" value="Submit" style="max-width: 150px;">
        </form>
    </section>
    <!-- end section signup -->

    <section class="promo">
            <img src="<?php echo base_url(); ?>images/bg.png">
        <?php //} ?>
    </section>
    <!-- end section promo -->
</div>
<div class="clear-fix"></div>
<!-- end class content -->
<?php $this->load->view('/includes/footer_public'); ?>
