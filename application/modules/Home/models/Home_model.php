<?php
class Home_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table_name = 'image';
  }

  function insert_image($data)
  {
    $result = $this->db->insert($this->table_name,$data);
    return $result;
  }

  function get_all_images(){
    $date =  date('M Y');

    $this->db->select('name, full_path, created_at, id, caption, user_id')
             ->from($this->table_name)
             ->where('created_at =', $date)
             ->order_by('rand()');
    $q = $this->db->get();

    return $q->result();
  }

  function insert_comment($table_name, $data){
    $this->db->insert($table_name,$data);
    $insert_id = $this->db->insert_id();

    $date      = date('M Y');
    $full_date = date("Y-m-d H:i:s"); 

    $sql = "INSERT INTO activities (donor_user_id,donor_user_name,status,activity,host_user_id,post_id,activity_date,activity_full_date) VALUES (".$data['commented_by_id'].",".$this->db->escape($data['commented_by_user_name']).", '0' , 'commmented' ,".$data['owner_id'].",".$data['image_id'].",".$this->db->escape($date).",".$this->db->escape($date).")";

    $this->db->query($sql);

    // inserting commentcount in rate_tbl
    $this->db->select('*')
             ->from('rate_tbl')
             ->where('image_id',$data['image_id']);
    $r = $this->db->get();
    $data2 = $r->result();
    if($data2){
      $new_total_comments = intval($data2[0]->total_comments)+1;
      $sql = "UPDATE rate_tbl SET total_comments=". $new_total_comments .", date = '". $date ."' WHERE image_id = ".$data2[0]->image_id;
      $this->db->query($sql);
    }else{
      $sql = "INSERT INTO rate_tbl(image_id,no_of_likes,total_comments, date) VALUES (".$data['image_id'].",0,1, '". $date ."')";
      $this->db->query($sql);
    }

    $this->db->select('profile_picture.full_path, user.first_name, user.last_name, user.profileImage')
              ->from('profile_picture')
              ->join('user', 'profile_picture.user_id = user.id')
              ->where('profile_picture.user_id',$data['commented_by_id']);
    $q = $this->db->get();
    if($q->result()){
      $data = $q->result();
      $data1[] = array('first_name'=>$data[0]->first_name, 'last_name'=>$data[0]->last_name, 'full_path'=>$data[0]->full_path, 'profileImage'=>$data[0]->profileImage, 'comment_id' => $insert_id);
      return $data1;
    }
    $data1[] = array('commented_by_user_name' => $data['commented_by_user_name'], 'comment' => $data['comment'], 'comment_id' => $insert_id);
    return $data1;
  }

  function get_all_comments(){
    $date =  date('M Y');

    $this->db->select('*');
    $this->db->from('image_comments');
    $this->db->join('image', 'image_comments.image_id = image.id','left');
    $this->db->where('image.created_at',$date);
    $query = $this->db->get();
    return $query->result();
  }

  function get_all_likes_by_user(){
    $date    =  date('M Y');
    $user_id = $this->session->userdata('user_id');

    $this->db->select('*');
    $this->db->from('image_likes');
    $this->db->join('image', 'image_likes.image_id = image.id');
    $this->db->where('image.created_at',$date);
    $this->db->where('image_likes.liked_by',$user_id);
    $query = $this->db->get();
    return $query->result();
  }

  function get_all_likes(){
    $date    =  date('M Y');

    $this->db->select('*');
    $this->db->from('image_likes');
    $this->db->join('image', 'image_likes.image_id = image.id');
    $this->db->where('image.created_at',$date);
    $query = $this->db->get();
    return $query->result();
  }

  function insert_likes($data){
    $like_info = $this->db->select('*')
                          ->from('image_likes')
                          ->where('liked_by',$data['liked_by'])
                          ->where('image_id',$data['image_id'])
                          ->get()->result();

    if(empty($like_info)){
      if($this->db->insert('image_likes',$data)){

        $date    =  date('M Y');

        $image_owner = $this->db->select('user_id')
                            ->from('image')
                            ->where('id',$data['image_id'])
                            ->get()->result_array();

        $sql = "INSERT INTO activities (donor_user_id,donor_user_name,status,activity,host_user_id,post_id,activity_date) VALUES (".$data['liked_by'].",".$this->db->escape($data['user_name']).", '0' , 'Likes' ,".$image_owner[0]['user_id'].",".$data['image_id'].",".$this->db->escape($date).")";

        $this->db->query($sql);

         // inserting commentcount in rate_tbl
        $this->db->select('*')
                 ->from('rate_tbl')
                 ->where('image_id',$data['image_id']);
        $r = $this->db->get();
        $data2 = $r->result();
        if($data2){
          $new_no_of_likes = intval($data2[0]->no_of_likes)+1;
          $sql = "UPDATE rate_tbl SET no_of_likes=". $new_no_of_likes .", date = '". $date ."' WHERE image_id = ".$data2[0]->image_id;
          $this->db->query($sql);
        }else{
          $sql = "INSERT INTO rate_tbl(image_id,no_of_likes,total_comments,date) VALUES (".$data['image_id'].",1,0,'".$date ."')";
          $this->db->query($sql);
        }
        return TRUE;
      }    
    }
    // end check for like already exists
    return FALSE;
  }

  function delete_likes($data){
      $this->db->where('liked_by', $data['liked_by']);
      $this->db->where('image_id', $data['image_id']);
      $this->db->delete('image_likes');

      // inserting commentcount in rate_tbl
      $this->db->select('*')
               ->from('rate_tbl')
               ->where('image_id',$data['image_id']);
      $r = $this->db->get();
      $data2 = $r->result();
      if($data2){
        $new_no_of_likes = intval($data2[0]->no_of_likes)-1;
        $sql = "UPDATE rate_tbl SET no_of_likes=". $new_no_of_likes ." WHERE image_id = ".$data2[0]->image_id;
        $this->db->query($sql);
      }else{
        $sql = "INSERT INTO rate_tbl(image_id,no_of_likes,total_comments) VALUES (".$data['image_id'].",0,0)";
        $this->db->query($sql);
      }
  }

  function get_all_activities_by_id($id){
    $date   = date('M Y');

    $result = $this->db->select('*')
                       ->from('activities')
                       ->where('activity_date =', $date)
                       ->where('host_user_id', $id)
                       ->order_by('id','DESC')
                       ->get()->result();
    return $result;
  }

  function get_all_activities(){
    $date    =  date('M Y');

    $result =$this->db->select('*')
                      ->from('activities')
                      ->where('activity_date =',$date)
                      ->limit(10)
                      ->order_by('id', 'DESC')
                      ->get()->result();
    return $result;
  }

  function get_all_activities_for_jquery(){
    $date    =  date('M Y');
    $result  = $this->db->select('activities.id, activities.donor_user_id, activities.donor_user_name, activities.status, activities.activity, activities.host_user_id, activities.post_id, activities.activity_date, activities.activity_full_date, user.profileImage')
                      ->from('activities')
                      ->where('activity_date =',$date)
                      ->limit(1)
                      ->order_by('id', 'DESC')                      
                      ->join('user', 'activities.donor_user_id = user.id')
                      ->get()->result();
    return $result;
  }

  function get_all_users(){
    $result =$this->db->select('*')
                      ->from('user')
                      ->get()->result();
    return $result;
  }

  public function delete_comment($table_name, $data)
  {
    $data1 = $this->db->select('*')
                       ->from('image_comments')
                       ->where('comment_id',$data['comment_id'])
                       ->get()->result();
                       var_dump($data);
    if($data1){
      // inserting commentcount in rate_tbl
      $this->db->select('*')
               ->from('rate_tbl')
               ->where('image_id',$data1[0]->image_id);
      $r = $this->db->get();
      $data2 = $r->result();
      if($data2){
        $new_total_comments = intval($data2[0]->total_comments)-1;
        $sql = "UPDATE rate_tbl SET total_comments=". $new_total_comments ." WHERE image_id = ".$data2[0]->image_id;
        $this->db->query($sql);
      }else{
        $sql = "INSERT INTO rate_tbl(image_id,no_of_likes,total_comments) VALUES (".$data['image_id'].",0,1)";
        $this->db->query($sql);
      }
    }

    $result = $this->db->delete($table_name, array('comment_id' => $data['comment_id']));
    return $result;
  }

  public function get_all_profile_pic(){
    $result =$this->db->select('*')
                      ->from('profile_picture')
                      ->get()->result();
    return $result;
  }

  public function get_pop_images(){
    $date =  date('M Y');

    $this->db->select('image_id')
             ->from('rate_tbl')
             ->where('date', $date)
             ->limit(6)
             ->order_by('no_of_likes','desc');

    $q = $this->db->get();

    $data = $q->result();
    $total_image = count($data);
    
    if($total_image != 0):
        for($i=0;$i<$total_image;$i++){
          $data1[$i] = $this->db->select('name, full_path, created_at, id, caption, user_id')
                                ->from($this->table_name)
                                ->where('created_at =', $date)
                                ->where('id=', $data[$i]->image_id)
                                ->get()->result();
        }
        // var_dump($data1);
        
        return $data1;
    endif;
        return false;
  }  

  // this function returns last months best image
  public function get_last_month_pop_image(){
    $currentMonth      = date('F');
    $currentYear       = date('Y');
    $prevMonth         = Date('F', strtotime($currentMonth . " last month"));
    $standardDateFormat = substr( $prevMonth , 0 , 3);
    $standardDateFormat .= ' ' . $currentYear;

    // the sql statement which selects last month best image
    $sql = "select image_id, count(image_id) c from image_likes where date = '". $standardDateFormat ."'
        group by image_id ORDER BY count(image_id) DESC";

    $q      = $this->db->query($sql);
    $result = $q->result();
    
    
//     var_dump(count($result));
//     echo "</br>";
    
//   for($i=0; $i< count($result); $i++){
//       $prev_result = 0;
//         if($result[$i]->c == $prev_result){
//             // do something
//             echo "<h2>".$result[$i]->c."</h2></br>";
//         }
//         $prev_result = $result[$i]->c;
//         var_dump($result);
//         echo "</br>";
//   }
//   die;
    
    
    
    if($result):
        $data = $this->db->select('name, full_path, created_at, id, caption, user_id')
                         ->from('image')
                         ->where('created_at =', $standardDateFormat)
                         ->where('id =',$result[0]->image_id)
                         ->get()->result();
        return $data;
    endif;
    
    return false;
  }

  // this function returns the likes of the previous month best image
  public function get_all_likes_prev($image_id){
    $currentMonth      = date('F');
    $currentYear       = date('Y');
    $prevMonth         = Date('F', strtotime($currentMonth . " last month"));
    $standardDateFormat = substr( $prevMonth , 0 , 3);
    $standardDateFormat .= ' ' . $currentYear;

    $this->db->select('*');
    $this->db->from('image_likes');
    $this->db->join('image', 'image_likes.image_id = image.id');
    $this->db->where('image.created_at',$standardDateFormat);
    $this->db->where('image.id',$image_id);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_all_comments_prev($image_id){
    $currentMonth      = date('F');
    $currentYear       = date('Y');
    $prevMonth         = Date('F', strtotime($currentMonth . " last month"));
    $standardDateFormat = substr( $prevMonth , 0 , 3);
    $standardDateFormat .= ' ' . $currentYear;

    $this->db->select('*');
    $this->db->from('image_comments');
    $this->db->join('image', 'image_comments.image_id = image.id','left');
    $this->db->where('image.created_at',$standardDateFormat);
    $this->db->where('image.id',$image_id);
    $query = $this->db->get();
    return $query->result();
  }
}
?>