<?php
class notification_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table_name = 'image';
  }

  public function update_user_settings_dob($data){
	// update the date_of_birth of user 
  	$this->db->set('date_of_birth', $data['dob']);
  	$this->db->where('id', $data['user_id']);
  	$this->db->update('user');
     return true;
  }

  public function update_user_settings_first_name($data){
  	//update first name in user table
  	$this->db->set('first_name', $data['first_name']);    
    $this->db->set('user_name', $data['first_name'].' '.$this->session->userdata('last_name'));
  	$this->db->where('id', $data['user_id']);
  	$this->db->update('user');

    return true;
  }

  public function update_user_settings_last_name($data){
  	//update last name
  	$this->db->set('last_name', $data['last_name']);
    $this->db->set('user_name', $this->session->userdata('last_name') .' '. $data['last_name']);
  	$this->db->where('id', $data['user_id']);
  	$this->db->update('user');
    return true;
  }

  public function update_user_settings_gender($data){
    //update last name
    $this->db->set('gender', $data['gender']);
    $this->db->where('id', $data['user_id']);
    $this->db->update('user');
    return true;
  }

  public function update_user_settings_district($data){
    //update last name
    $this->db->set('district', $data['district']);
    $this->db->where('id', $data['user_id']);
    $this->db->update('user');
    return true;
  }

   public function update_user_settings_chowk($data){
    //update location chowk
    $this->db->set('chowk', $data['chowk_name']);
    $this->db->where('id', $data['user_id']);
    $this->db->update('user');
    return true;
  }

  // function to deactivate the user
  public function deactivate_user($user_id){
    $this->db->set('status', 1);
    $this->db->where('id', $user_id);
    $this->db->update('user');

    return true;
  }

  // function to update profile picture directory
  public function update_profile_dir($new_profile, $full_path_profile, $user_id){
    $this->db->set('path', $new_profile);
    $this->db->set('full_path', $full_path_profile);
    $this->db->where('user_id',$user_id);
    $this->db->update('profile_picture');

    return true;
  }

  // function to update profile picture directory
  public function update_cover_dir($new_cover, $full_path_cover, $user_id){
    $this->db->set('path', $new_cover);
    $this->db->set('full_path', $full_path_cover);
    $this->db->where('user_id',$user_id);
    $this->db->update('cover_picture');

    return true;
  }

  // function update image directory
  public function update_image_dir($old_name, $new_name, $user_id){
    $sql = "UPDATE image set full_path = replace(full_path,'".$old_name."','".$new_name."'), path = replace(path,'".$old_name."','".$new_name."')WHERE user_id = ".$user_id;
    $this->db->query($sql);
    return true;
  }

}?>