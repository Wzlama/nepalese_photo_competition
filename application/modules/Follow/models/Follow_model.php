<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Follow_model extends MY_Model
{
   public function __construct()
  {
    parent::__construct();
    $this->table_name = 'user';
  }

   public function get_users_list()
  {
    $this->db->select('*')
            ->from($this->table_name)
            ->order_by('rand()')
            ->where('status','0');
    $q = $this->db->get();
    
    return $q->result();
  }

  public function get_user_by_id($id){
    $this->db->select('*')
             ->from($this->table_name)
             ->where('id',$id)
             ->where('status','0');
    $q = $this->db->get();
    return $q->result();
  }

  public function add_followers($table_name, $data){
     //add users to database table     
    $result = $this->db->insert($table_name,$data);
    return $result;
  }
}
?>