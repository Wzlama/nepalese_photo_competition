<?php $this->load->view('/includes/header'); ?>
    <div class="ch-profile-hldr">
        <div class="ch-profile-header">
            <h3>Step 2:  Let Us add cover picture.</h3>
        </div>
        <div class="main-body">
            <div class="image-preview">
                <img src="images/profdef.png"  id="img-prev">
            </div>
        </div>
        <!-- end main body -->

        <div class="form-holder">
            <form action="addCoverPic/upload" method="post" enctype="multipart/form-data">
                <input type="file" name="coverPic" id="upload">
                <input type="submit" name="submit" value="Upload" class="btn-upload" id="upload-btn" style="visibility: hidden;">
            </form>
        </div>
        <!-- end class form-hloder -->
            <a href="<?php echo base_url('follow');?>" class="btn-skip">Skip>></a>
    </div>
    <!-- end ch-profile-hldr -->
    </div>
    <!-- end div change-profile-page -->
<?php $this->load->view('/includes/footer'); ?>
<script type="text/javascript">
    $('input#upload').change(function () {
        $('#upload-btn').css('visibility','visible');
        $('.btn-skip').remove();
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