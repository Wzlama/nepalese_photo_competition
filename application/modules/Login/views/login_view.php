<?php $this->load->view('/includes/header_public'); ?>

<div class="content">
    <section  class="signup">
        <h3>Upload Your Best Photograph And Be The Best.</h3>
        <form class="signup-form" action="login/createNewUser" method="post">
            <input class="input-area _e1" type="text" name="firstName" value="" placeholder="Enter First Name.">

            <input class="input-area _e1" type="text" name="lastName" value="" placeholder="Enter Last Name."><br>
            <p id="lastName" style="color: red;"></p><span id="firstName" style="color: red;"></span>


            <input class="input-area" type="email" name="email" value="" placeholder="Enter Email Address."><br>
            <p id="email" style="color: red;"></p>

            <input class="input-area" id="password_text" type="password" name="password" value="" placeholder="Enter password."><br> 
            <p id="password" style="color: red;"></p>

            <input class="input-area" id="confirm_password_text" type="password" name="confirm_password" value="" placeholder="Confirm password."><br> 
            <p id="confirm_password" style="color: red;"></p>

            <select style="margin: 5px;" class="_smScrn-select" name="day">
                <!-- use php in production -->
                <option value="">Day</option>
                <?php for($i=1;$i<=32;$i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
             <select class="_smScrn-select" name="month">
                <!-- use php in production -->
                <option value="">Month</option>
                <option value="1">Jan</option>
                <option value="2">Feb</option>
                <option value="3">mar</option>
                <option value="4">Apr</option>
                <option value="5">May</option>
                <option value="6">Jun</option>
                <option value="7">Jul</option>
                <option value="8">Aug</option>
                <option value="9">Sep</option>
                <option value="10">Oct</option>
                <option value="11">Nov</option>
                <option value="12">Dec</option>
            </select>
             <select class="_smScrn-select" name="year">
                <!-- use php in production -->
                <option value="">Year</option>
                <?php for($i=2017;$i>=1905;$i--): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select><br><br>
            <p id="day" style="color: red;"></p>
            <p id="month" style="color: red;"></p>
            <p id="year" style="color: red;"></p>

           <input name="sex" value="male" type="radio" checked="yes">Male<input name="sex" value="female" type="radio" id="sex">Female<br><br>
           <p id="sex" style="color: red;"></p>

           <select class="_smScrn_Select" name="country">
               <!-- use php in production -->
                <option value="Nepal">Nepal</option>
           </select>

           <select class="_smScrn_Select" name="district">
               <!-- use php in production -->
                <option value="">District</option>
                <option value="Taplejung">Taplejung</option>
                <option value="Panchthar">Panchthar</option>
                <option value="Ilam">Ilam</option>
                <option value="Jhapa">Jhapa</option>
                <option value="Morang">Morang</option>
                <option value="Sunsari">Sunsari</option>
                <option value="Dhankutta">Dhankutta</option>
                <option value="Sankhuwasabha">Sankhuwasabha</option>
                <option value="Bhojpur">Bhojpur</option>
                <option value="Terhathum">Terhathum</option>
                <option value="Okhaldunga">Okhaldunga</option>
                <option value="Khotang">Khotang</option>
                <option value="Solukhumbu">Solukhumbu</option>
                <option value="Udaypur">Udaypur</option>
                <option value="Saptari">Saptari</option>
                <option value="Siraha">Siraha</option>
                <option value="Dhanusa">Dhanusa</option>
                <option value="Mahottari">Mahottari</option>
                <option value="Sarlahi">Sarlahi</option>
                <option value="Sindhuli">Sindhuli</option>
                <option value="Ramechhap">Ramechhap</option>
                <option value="Dolkha">Dolkha</option>
                <option value="Sindhupalchauk">Sindhupalchauk</option>
                <option value="Kavreplanchauk">Kavreplanchauk</option>
                <option value="Lalitpur">Lalitpur</option>
                <option value="Bhaktapur">Bhaktapur</option>
                <option value="Kathmandu">Kathmandu</option>
                <option value="Nuwakot">Nuwakot</option>
                <option value="Rasuwa">Rasuwa</option>
                <option value="Dhading">Dhading</option>
                <option value="Makwanpur">Makwanpur</option>
                <option value="Rauthat">Rauthat</option>
                <option value="Bara">Bara</option>
                <option value="Parsa">Parsa</option>
                <option value="Chitwan">Chitwan</option>
                <option value="Gorkha">Gorkha</option>
                <option value="Lamjung">Lamjung</option>
                <option value="Tanahun">Tanahun</option>
                <option value="Syangja">Syangja</option>
                <option value="Kaski">Kaski</option>
                <option value="Manag">Manag</option>
                <option value="Mustang">Mustang</option>
                <option value="Parwat">Parwat</option>
                <option value="Myagdi">Myagdi</option>
                <option value="Baglung">Baglung</option>
                <option value="Gulmi">Gulmi</option>
                <option value="Palpa">Palpa</option>
                <option value="Nawalparasi">Nawalparasi</option>
                <option value="Rupandehi">Rupandehi</option>
                <option value="Arghakhanchi">Arghakhanchi</option>
                <option value="Kapilvastu">Kapilvastu</option>
                <option value="Pyuthan">Pyuthan</option>
                <option value="Rolpa">Rolpa</option>
                <option value="Rukum">Rukum</option>
                <option value="Salyan">Salyan</option>
                <option value="Dang">Dang</option>
                <option value="Bardiya">Bardiya</option>
                <option value="Surkhet">Surkhet</option>
                <option value="Dailekh">Dailekh</option>
                <option value="Banke">Banke</option>
                <option value="Jajarkot">Jajarkot</option>
                <option value="Dolpa">Dolpa</option>
                <option value="Humla">Humla</option>
                <option value="Kalikot">Kalikot</option>
                <option value="Mugu">Mugu</option>
                <option value="Jumla">Jumla</option>
                <option value="Bajura">Bajura</option>
                <option value="Bajhang">Bajhang</option>
                <option value="Achham">Achham</option>
                <option value="Doti">Doti</option>
                <option value="Kailali">Kailali</option>
                <option value="Kanchanpur">Kanchanpur</option>
                <option value="Dadeldhura">Dadeldhura</option>
                <option value="Baitadi">Baitadi</option>
                <option value="Darchula">Darchula</option>
           </select>

           <input class="location" type="text" name="chowk" value="" placeholder="Chowk name.">

           <p id="counry" style="color: red;"></p>
           <p id="district" style="color: red;"></p>
           <p id="chowk" style="color: red;"></p>
    
            <input class="input-area" type="text" name="phoneNum" value="" placeholder="Enter phone number.">
            
            <p id="phoneNum" style="color: red;"></p>
            
           <div class="agmt">
               <p>By clicking Create an account, you agree to our Terms and confirm that you have read our Data Policy</p>
           </div>
            <input class="input-area" type="submit" name="submit" value="Submit">
        </form>
    </section>
    <!-- end section signup -->

    <section class="promo">
         <?php //if($last_month_pic[0]->full_path){ ?>
            <!-- <img src="<?php echo $last_month_pic[0]->full_path . '/' .$last_month_pic[0]->name; ?>" width="100%" height="444px"> -->
             
            <img src="<?php echo base_url(); ?>images/bg.png">
        <?php //} ?>
    </section>
    <!-- end section promo -->
</div>
<div class="clear-fix"></div>
<!-- end class content -->
<?php $this->load->view('/includes/footer_public'); ?>
