<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class addCoverPic_model extends MY_Model
{
	public function __construct()
  {
    parent::__construct();
    $this->table_name = 'image';
  }  

  public function insert_image($table,$data)
  {
    $this->db->set('coverImage', $data['file_name']);
    $this->db->where('id', $data['user_id']);
    $this->db->update('user');

    $result = $this->db->insert($table,$data);
    return $result;
  }

  // function to update the profile picture 
  public function update_cover_pic($table_name,$image_data){
    $user_id = $this->session->userdata('user_id'); 
    // update the profile picture in user table 
    $this->db->set('coverImage', $image_data['file_name']);
    $this->db->where('id', $image_data['user_id']);
    $this->db->update('user');

    //first see if the profile picture for user exists in database 
    $sql      = "SELECT * FROM cover_picture WHERE user_id = ".$user_id;
    $q        = $this->db->query($sql);
    $covr_dtl = $q->result();
    
    if($covr_dtl[0]->user_id){
      // update the profile picture in the 
      $this->db->where('user_id', $user_id);
      $this->db->update($table_name, $image_data); 
    }else{
      $this->db->insert($table_name,$image_data);  
    }
    return true;
  }

  // this function returns all the profile picture information 
  public function get_cover_picture_detail_by_id($user_id){
    $this->db->select('*');
    $this->db->from('cover_picture');
    $this->db->where('user_id ',$user_id);
    $q = $this->db->get();
    if($q){
      return $q->result();
    }
    return false;
  }
}
//end class appProfilePic_model
?>