<?php $this->load->view('/includes/header'); ?>

<?php $this->view('../snippets/notification'); ?>

<?php $this->view('../snippets/settings'); ?>

<div class="change-profile-page">
	<div class="_notifications">
   <!--  <a href="<?php echo site_url('notification/deactivate_account');?>" style="text-decoration: none;"><div id="deactivate-acc">
                Deactivate your account
        </div></a> -->
        <span class="clear"></span>
        <!-- end div diactivate-acc -->
		<h3 style="color: #fff;">Settings </h3>

	    <form class="user-info" id="setting_form">
            <div class="form-group">
                
            </div>

            <div class="form-group">
                <label for="user_name">Date Of Birth</label><br>

                <?php foreach($user_list as $user): ?>
                    <?php if($user->id == $this->session->userdata('user_id')){ ?>
                        <input type="text" name="dob" id="dob" value="<?php echo $user->date_of_birth; ?>" class="form-control" readonly>
                        <span onClick="change_dob()" id="ch_dob">edit</span>
                        <span onClick="dob_changed(<?php echo $user->id; ?>)" id="done_dob" style="display: none; color: green;">Done</span><br>
                            
                    	<label for="first_name">First Name:</label><br>
                        <input type="text" name="user_name" id="first_user_name" value="<?php echo $user->first_name; ?>" class="form-control" readonly>
                        <span onClick="change_first_name()" id="ch_first">edit</span>
                        <span id="done_first" onClick="first_name_changed(<?php echo $user->id; ?>)" style="display: none; color: green;">Done</span><br>
                        

                        <!--  <label for="first_name">Middle Name:</label>
                        <input type="text" name="middle_user_name" id="middle_user_name" value="<?php echo $user->middle_name; ?>" class="form-control" readonly>
                        <span onClick="change_middle_name()" id="ch_middle">edit</span>
                        <span  onClick="middle_name_changed()" id="done_middle" style="display: none; color: green;">Done</span>
                        <br> -->

                        <label for="first_name">Last Name:</label><br>
                        <input type="text" name="user_name" id="last_user_name" value="<?php echo $user->last_name; ?>" class="form-control" readonly>
                        <span onClick="change_last_name()" id="ch_last">edit</span>
                        <span id="done_last" onClick="last_name_changed(<?php echo $user->id; ?>)" style="display: none; color: green;">Done</span>
                        <br>

                        <label for="gender">Gender:</label><br>
                        <input type="text" id="ch_gender_hldr" value="<?php echo $user->gender; ?>"  class="form-control"  readonly>
                        <select id="gender" name="gender" class="form-control" style="display: none;">
                                <option><?php echo 'female'; ?></option>
                                <option><?php echo 'male'; ?></option>
                            <option><?php echo 'others'; ?></option>
                        </select>
                        <span  onClick="change_gender()" id="ch_gender">edit</span>
                        <span onClick="gender_changed(<?php echo $user->id; ?>)" id="done_gender" style="display: none;">Done</span><br>

                        <label for="location">Country Name</label><br>
                        <input type="text-decoration" name="country" value="<?php echo $user->country; ?>" class="form-control" readonly><br>
                        <label for="location">District</label><br>
                        <input type="text" id="ch_dis_hldr" value="<?php echo $user->district; ?>"  class="form-control"  readonly>
                        <select id="district_ch" name="district" class="form-control" style="display: none;">
                            <option selected><?php echo $user->district; ?></option>
                            <option><?php echo 'others'; ?></option>
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
                        <span  onClick="change_district()" id="ch_district">edit</span>
                        <span onClick="district_changed(<?php echo $user->id; ?>)" id="done_district" style="display: none;">Done</span><br>

                        <label for="location">Chowk</label><br>
                        <input type="text-decoration"  id="chowk_name_change" name="country" value="<?php echo $user->chowk; ?>" class="form-control" readonly>
                        <span onClick="change_chowk_name()" id="ch_chowk">edit</span>
                        <span id="done_chowk" onClick="chowk_name_changed(<?php echo $user->id; ?>)" style="display: none; color: green;">Done</span>
                        <br>                        
                    <?php } ?>
                <?php endforeach; ?>

            </div>
        </form>
        <!-- end form -->
        <a href="<?php echo site_url(); ?>" style="float: right;"><button>Done</button></a>
	</div>
	<!-- _notifications ends here -->
</div>
<!-- end div change-profile-page -->

<?php $this->load->view('/includes/footer'); ?>
