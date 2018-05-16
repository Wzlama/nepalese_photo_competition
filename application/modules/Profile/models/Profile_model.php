<?php
class profile_model extends MY_Model
{
   public function __construct()
  {
    parent::__construct();
    $this->table_name = 'user';
  }

  public function get_all_user_info(){
  	$sad['user_id'] = $this->session->userdata('user_id');
  	$this->db->select('*')
             ->from('user_info')
             ->where('user_id',$sad['user_id']);
    $q = $this->db->get();

    return $q->result();
  }

  // function to update the userinformation
  public function update_user_info($data, $table_name, $data_e){
  	$userExists = $this->get_all_user_info();
  	if( $userExists ){
     $result = $this->db->update($table_name,$data);
    }else{
  		$this->db->insert($table_name, $data);
    }

  	// update the date_of_birth of user 
  	$this->db->set('date_of_birth', $data_e['dob']);
  	$this->db->where('id', $this->session->userdata('user_id'));
  	$this->db->update('user');
  }

  //this function gets all the image of user by id uoloaded in this month
  public function get_all_images_by_id($id){
  	$date =  date('M Y');

    $this->db->select('name, full_path, created_at, id, caption, user_id')
             ->from('image')
             ->where('created_at =', $date)
             ->where('user_id',$id);
    $q = $this->db->get();

    return $q->result();
  }

  // returns the lists of all the photographers subscribed by the user
  public function get_all_subscribed_photographer_list($user_id){
    $this->db->select('*')
             ->from('follower')
             ->where('followed_by',$user_id)
             ->order_by('rand()');
    $q = $this->db->get();

    return $q->result();
  } 

  // returns the list of all unsubscribed photographers list 
  public function get_all_unsubscribed_photographers($user_id){
    $sql = 'SELECT user.id, user.first_name, user.last_name, user.email_address, user.profileImage FROM user WHERE user.id NOT IN (SELECT user_id FROM follower where followed_by = ' . $user_id . ' ORDER BY RAND())';

    $query = $this->db->query($sql);

    return $query->result_object();
  }

  // function to remove the subscribed user
  public function unsubscribe($user_id){
    $this->db->where('user_id', $user_id);
    $this->db->delete('follower');
  }

  // function to add followers
  public function add_followers($data){
     //add users to database table     
    $result = $this->db->insert('follower',$data);
    return $result;
  }

  // function to update the database of notification when user views the notification
  public function update_notification($data){
    $this->db->set('status', '1');
    $this->db->where('host_user_id',$this->session->userdata('user_id'));
    $this->db->update('activities');
    return true;
  }

}
?>