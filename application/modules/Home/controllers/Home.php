<?php
class home extends MX_Controller{    
  function __construct() {
    parent::__construct();
    $this->load->model('home_model');
    $sad = $this->session->all_userdata();
    if (!isset($sad['logged_in']) || !$sad['logged_in'] == true) {
      redirect(base_url());
    }
  }
  
 function index() {
    // messages error or success
    if(isset($_GET['msg'])){
      $msg = $_GET['msg'];
      if($msg == 'success'){
        $message_success = 'Image Uploaded successfully';
        $message = '';
      }
      if($msg =='error'){        
        $message = 'Please enter caption and correct image format file.';
        $message_success = '';
      }
    }else{
      $message = '';
      $message_success = '';
    }


    // get the most popular image of last month
    $last_month_pop_img = $this->home_model->get_last_month_pop_image();
    
    // copy these lists later in two other function which loads the same page but different url 
    $image_list         = $this->home_model->get_all_images();
    
    // comment list of this month
    $comment_list       = $this->home_model->get_all_comments();
    
    // select only the likes from this particular user. 
    $likes_in_image     = $this->home_model->get_all_likes_by_user();
    
    // gets all likes done by other users also 
    $likes_list         = $this->home_model->get_all_likes();
    
    // get the lije list of previous month best image
    $likes_list_prev     = '';    
    if(!empty($last_month_pop_img)):
        $likes_list_prev    = $this->home_model->get_all_likes_prev($last_month_pop_img[0]->id);
    endif;
    
    //recent activity list
    $activity_list      = $this->home_model->get_all_activities();
    
    //users of our application
    $user_list          = $this->home_model->get_all_users();
    
    // gets all profile pictures
    $profile_pics       = $this->home_model->get_all_profile_pic();
    
    // popular images of this month
    $pop_img            = $this->home_model->get_pop_images();
    
    // gets all the list of comment on previously best image
    $comment_list_prev  = '';
    if(!empty($last_month_pop_img)):
        $comment_list_prev      = $this->home_model->get_all_comments_prev($last_month_pop_img[0]->id);
    endif;
    // var_dump($last_month_pop_img);
    // die;

    $view = array(
        'controller'         => $this,
        'content'            => 'home_view',
        'image_list'         => $image_list,
        'pop_img'            => $pop_img,
        'comment_list'       => $comment_list,
        'activity_list'      => $activity_list,
        'likes'              => $likes_in_image,
        'user_list'          => $user_list,
        'profile_pics'       => $profile_pics,      
        'message'            => $message,  
        'message_success'    => $message_success,
        'likes_list'         => $likes_list,
        'title'              => 'Home',
        'last_month_pop_img' => $last_month_pop_img,
        'likes_list_prev'    => $likes_list_prev,
        'comment_list_prev'  => $comment_list_prev
    );
    $this->load->view('/includes/content', $view);
  }

  function upload(){
    $sad = $this->session->all_userdata();

    $date =  date('M Y'); 

    if(!is_dir("uploaded_image/". $sad["user_name"] .'/' .$date)) {
      mkdir("uploaded_image/". $sad["user_name"] .'/' .$date, 0777);
      $upload_path = ("uploaded_image/". $sad["user_name"] .'/' .$date);
    }else{
      $upload_path = ("uploaded_image/". $sad["user_name"] .'/' .$date);
    }

    if ( !empty($_FILES) && $this->input->post('caption') != null) 
    {
      $file = $_FILES['imgupload'];
      $user_id   = $this->session->userdata('user_id');     
      $data['name'] = uniqid().'.jpg';
      $data['caption'] = $this->input->post('caption');
      $data['file_type'] = $file['type'];
      $data['file_ext'] = $file['type'];
      $data['file_size'] = $file['size'];      
      $data['path'] = $upload_path;
      $now = new DateTime('now'); 
      $data['full_path'] = base_url().$upload_path;
      //remove the published column from the database after finishing the upload
      $data['created_at'] = $date;
      $data['updated_at'] = $now->format('Y-m-d');
      $data['user_id'] = $user_id; 

      $tempFile = $_FILES['imgupload']['tmp_name'];
      $fileName =  $data['name'];
      $targetPath = $upload_path;
      $targetFile = $targetPath .'/'. $fileName ;

      //add the files to the database and move to directory
      if(move_uploaded_file($tempFile, $targetFile) && $this->home_model->insert_image($data)){
        redirect('home?msg=success');        
      }
    }else{
      redirect('home?msg=error');
    }
  }

  function postComment(){
    $data['commented_by_id']           = $this->session->userdata('user_id');
    $data['commented_by_user_name']    = $this->session->userdata('user_name');
    $data['owner_id']                  = $_POST['owner_id'];
    $data['image_id']                  = $_POST['image_id'];
    $data['comment']                   = $_POST['comment'];  
    $data['date']                      = date('M Y'); 

    $result = $this->home_model->insert_comment('image_comments',$data);
    
    echo json_encode($result);
    
  }

  function likes(){
    $sad = $this->session->all_userdata();
    $data['image_id']  = $_POST['image_id'];
    $data['liked_by']  = $sad['user_id'];
    $data['user_name'] = $sad['user_name']; 
    $data['date']      = date('M Y'); 

    //insert_likes beacause its more technical term 
    $result = $this->home_model->insert_likes($data);
    if($result){
      echo 'Success';
    }else{
      echo 'Not liked';
    }
  }

   function unlikes(){
    $sad = $this->session->all_userdata();
    $data['image_id']  = $_POST['image_id'];
    $data['liked_by']  = $sad['user_id'];
    $data['user_name'] = $sad['user_name'];

    $result = $this->home_model->delete_likes($data);
    
     echo 'Success';
  }

  function getActivities(){
    $result = $this->home_model->get_all_activities_for_jquery();
    foreach ($result as $value) {
      $data['id']        = $this->encrypt_decrypt('encrypt',$value->id);
      $data['donor_user_id']     = $value->donor_user_id;
      $data['donor_user_name']   = $value->donor_user_name;
      $data['status']            = $value->status;
      if($value->profileImage == ""){
        $data['profile_image']   = 'images/profdef.png';
      }else{
        $data['profile_image']     = 'profile_pic/'.$value->donor_user_name.'/'.$value->profileImage;
      }
      $data['activity']          = $value->activity;
      $data['host_user_id']      = $value->host_user_id;
      $data['post_id']           = $this->encrypt_decrypt('encrypt',$value->post_id);
      $data['activity_date']     = $value->activity_date;
      $data['acivity_full_date'] = $value->activity_full_date;
    }

    var_dump($data);
    echo json_encode($data);
  }

  public function delete_comment(){
    if(!empty($_POST)){
      $data['comment_id'] = $_POST['comment_id'];

      //delete from database 
      $result = $this->home_model->delete_comment('image_comments',$data);
      return $result;
    }
  }

  function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
  } 

}
