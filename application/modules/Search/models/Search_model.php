<?php 
class search_model extends MY_Model
{
	public function __construct()
	{
	   parent::__construct();
	   $this->table_name = 'user';
	}  

	public function search_users($name){
		$this->db->select('*')
		 		   ->from('user')
		           ->like('user_name', $name);

		$q = $this->db->get();

    	return $q->result();
	}
}
//end class search_model
?>