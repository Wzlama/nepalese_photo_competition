<?php
class photo_model extends MY_Model
{
	public function _construct(){
		parent::__construct();
	}

	public function get_photo_list($photo_id){
		$this->db->select('*')
			     ->from('image')
			     ->where('id',$photo_id);
		$q = $this->db->get();
		return $q->result();
	}

	// this function pulls all the comments on image
	public function get_comments_by_image_id($photo_id){
		$this->db->select('*')
			     ->from('image_comments')
			     ->where('image_id',$photo_id);
		$q = $this->db->get();
		return $q->result();
	}

	// this function pulls all the likes on the image
	public function get_likes_on_images($photo_id){
		$this->db->select('*')
				 ->from('image_likes')
				 ->where('image_id',$photo_id);
		
		$q = $this->db->get();
		return $q->result();
	}

	// function to remove the image from database
	public function delete_photo($photo_id){
		$this->db->delete('image', array('id' => $photo_id));
		return true;
	}
}
?>