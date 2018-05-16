<?php $this->load->view('/includes/header'); ?>

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>

<div class="change-profile-page">
    <div class="ch-profile-hldr">
        <div class="ch-profile-header">
            <h3>Add a new profile pic</h3>
        </div>
        <div class="main-body">
            <div class="image-preview">
                <?php if($profile_picture_detail){ ?>
                    <img src="<?php echo $profile_picture_detail[0]->full_path . '/' . $profile_picture_detail[0]->file_name ; ?>" id="img-prev">
                <?php }else{ ?>
                    <img src="<?php echo site_url('images'); ?>/profdef.png" id="img-prev">
                <?php } ?>
            </div>
        </div>
        <!-- end main body -->

        <div class="form-holder">
            <form action="addProfilePic/update_profile_pic" method="post" enctype="multipart/form-data">
                <input type="file" name="profilePic" id="upload">
        </div>
        <!-- end class form-holder -->
            <input type="submit" name="upload" value="Upload" class="btn-upload" id="upload-btn" style="float: right;">
            </form>
            <a href="<?php echo site_url('profile'); ?>" style="text-decoration: none; color: #800000; font-size: 12px;">Cancel</a>
    </div>
    <!-- end ch-profile-hldr -->
</div>
<!-- end div change-profile-page -->

<?php $this->load->view('/includes/footer'); ?>
<script type="text/javascript">
    $('input#upload').change(function () {
        $('#upload-btn').css('visibility','visible');
        readURL(this);
    });

    // this function is for the image preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
               $('#img-prev').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>