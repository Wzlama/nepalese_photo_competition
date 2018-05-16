<?php 
class Login_model extends MY_Model
{
	public function __construct()
  {
    parent::__construct();
    $this->table_name = 'user';
  }  

  //finds user by its id
  public function find_by_id($user_id){
    $this->db->SELECT('*');
    $this->db->FROM('user');
    $this->db->where('id', $user_id);
    $data = $this->db->get()->result();
    return $data;
  }

  /**
   * Authenticate user.
   * 
   * @param array $data
   * @return type 
   */
  public function authenticate(array $data)
  {
    $query = $this->db->get_where($this->table_name, array('email_address' => $data['email_address'], 'password' => $data['password']));
    $user_id = 0;
    $is_valid = ($query->num_rows() > 0);
    if ($is_valid == TRUE)
    {
        $user_id = $query->row()->id;
        $this->update_last_logged_in($user_id);
        $this->update_last_ip($user_id);

        $this->db->set('status', 0);
        $this->db->where('id', $user_id);
        $this->db->update('user');
    }
    
    return $user_id;
  }

  public function create_user($data)
  {
    //add users to database table   
    $this->db->insert($this->table_name,$data);
    if($this->db->affected_rows() > 0)
    {
      $userInfo = $this->get_user_by_email($data['email_address']);
      return $userInfo; 
    }else{
      return false;
    }
  }

  public function get_user_by_email($email)
  {
    $this->db->select('*')
            ->from($this->table_name)
            ->where('email_address',$email);
    $q = $this->db->get();
    return $q->result();
  }

  /**
   * Update last_ip column for user.
   * 
   * @param type $user_id
   * @return type 
   */
  public function update_last_ip($user_id)
  {
    $this->db->update($this->table_name, array('last_ip' => $this->input->ip_address()), array('id' => $user_id));
    
    return $user_id;
  }

  public function update_password($new_password,$user_id){
        $this->db->where('id',$user_id);
        $this->db->update($this->table_name,array('password' => $new_password));

        $this->db->select('email_address')
                 ->from('user')
                 ->where('id',$user_id);
        $q = $this->db->get();

        if($q){
            return $q->result();
        }else{
            return false;
        }
  }
  
  /**
   * Update last_logged_in column for user.
   * 
   * @param type $user_id
   * @return type 
   */
  public function update_last_logged_in($user_id)
  {
    $now =  date("F j, Y, g:i a");
    $this->db->update($this->table_name, array('last_logged_in' => $now), array('id' => $user_id));
    
    return $user_id;
  }

  function get_pop_image_of_last_month(){
    $data = $this->db->select('image_id')
                     ->from('rate_tbl')
                     ->order_by('no_of_likes','desc')
                     ->limit(1)
                     ->get()->result(); 
    if(!empty($data)):
        $image_info = $this->db->select('*')
                           ->from('image')
                           ->where('id=',$data[0]->image_id)
                           ->get()->result();
        return $image_info;
    endif;
    
    return false;
  }

}
//end class login_model
?>