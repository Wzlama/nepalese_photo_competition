<?php
class profile extends MX_Controller{
    
  function __construct() {
    parent::__construct();
    $this->load->model('Profile_model');
    $this->load->model('home/home_model');
  }

  function index() {
    //this is the stored user information from session
    $sad = $this->session->all_userdata();

    if(isset($_GET['puk'])):
      $user_id = $_GET['puk'];
      // if the id from url is not equal to the id saved in session then redirect to userprofile view
      if($sad['user_id'] != $this->encrypt_decrypt('decrypt', $user_id)){
        header("Location: Profile/view_user_profile?user_id=".$user_id);
        die;
      }
    endif;

    if (!$sad['logged_in'] == true) {
        redirect(base_url());
    }
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
    // copy these lists later in two other function which loads the same page but different url 
    $my_image_list             = $this->Profile_model->get_all_images_by_id($sad['user_id']);
    // comment list of this month
    $comment_list              = $this->home_model->get_all_comments();
    // select only the likes from this particular user. 
    $likes_in_image            = $this->home_model->get_all_likes_by_user();
    // gets all likes done by other users also 
    $likes_list                = $this->home_model->get_all_likes();
    //recent activity list
    $activity_list             = $this->home_model->get_all_activities();
    //users of our application
    $user_list                 = $this->home_model->get_all_users();
    // gets all profile pictures
    $profile_pics              = $this->home_model->get_all_profile_pic();
    // gets all the user information 
    $user_info                 = $this->Profile_model->get_all_user_info();
    // select all the users i am following
    $subscribed_photographers  = $this->Profile_model->get_all_subscribed_photographer_list($sad['user_id']);
    // selects all the user o whome this user is not subscribed
    $unfollowed_user_list      = $this->Profile_model->get_all_unsubscribed_photographers($sad['user_id']);
    // var_dump($unfollowed_user_list);die;

    $view = array(  
        'controller'               => $this,
        'my_image_list'            => $my_image_list,
        'comment_list'             => $comment_list,
        'activity_list'            => $activity_list,
        'likes'                    => $likes_in_image,
        'user_list'                => $user_list,
        'profile_pics'             => $profile_pics,      
        'message'                  => $message,  
        'message_success'          => $message_success,
        'likes_list'               => $likes_list,
        'user_info'                => $user_info,
        'subscribed_photographers' => $subscribed_photographers,
        'unfollowed_user_list'     => $unfollowed_user_list, 
        'content'                  => 'profile_view',
        'title'                    => 'Profile'
    );
    $this->load->view('/includes/content', $view);
  }

  // function that uploads the image if user uploads it from profile page.
  function upload(){

    $sad = $this->session->all_userdata();
    if (!$sad['logged_in'] == true) {
      redirect(base_url());
    }

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
      // sql injection should be prevented in caption
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
        redirect('profile?msg=success');        
      }
    }else{
      redirect('profile?msg=error');
    }
  }
  // end function upload

  //this function updates the user info by calling a function in model
  function about_info(){
    $sad = $this->session->all_userdata();
    if (!$sad['logged_in'] == true) {
      redirect(base_url());
    }

    if(isset($_POST)){
      $data_e['dob']      = $_POST['dob'];
      $data['education']  = $_POST['education'];
      $data['intrest']   = $_POST['intrests'];
      $data['philosophy'] = $_POST['philosophy'];
      $data['user_id']    = $this->session->userdata('user_id'); 
      
      $table_name         = 'user_info';
      $this->Profile_model->update_user_info($data, $table_name, $data_e);

    }
  }

  // this function unsubscribes the user 
  function unsubscribe(){
    $sad = $this->session->all_userdata();
    if (!$sad['logged_in'] == true) {
      redirect(base_url());
    }

    $user_id = $_POST['id'];

    //call the function in model to ensure the user has been removed
    $this->Profile_model->unsubscribe($user_id);
  }

  // this function subscribes user 
  function subscribe(){
    $sad = $this->session->all_userdata();
    if (!$sad['logged_in'] == true) {
      redirect(base_url());
    }

    $data['followed_by']   = $_POST['followed_by'];
    $data['first_name']    = $_POST['first_name'];
    $data['last_name']     = $_POST['last_name'];
    $data['email_address'] = $_POST['email_address'];
    $data['user_id']       = $_POST['user_id'];

    //call the function in model to ensure the user has been added
     $this->Profile_model->add_followers($data);
  }

  //this function is for notification detail walkthrough
  function viewNotification(){
    $sad = $this->session->all_userdata();
    if (!$sad['logged_in'] == true) {
      redirect(base_url());
    }

    $data['id']      = $_POST['activity_id'];
    $data['post_id'] = $_POST['post_id'];
    
    // call to the function that performs the update in the database
    $this->Profile_model->update_notification($data);

    return true;
  }

  public function view_user_profile(){
    //this is the stored user information from session
    $sad = $this->session->userdata();
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

    $user_id         = $_GET['user_id'];
    $decrypt_user_id = $this->encrypt_decrypt('decrypt', $user_id);
    
    // copy these lists later in two other function which loads the same page but different url 
    $my_image_list             = $this->Profile_model->get_all_images_by_id($decrypt_user_id);
    // comment list of this month
    $comment_list              = $this->home_model->get_all_comments();
    // select only the likes from this particular user. 
    $likes_in_image            = $this->home_model->get_all_likes_by_user();
    // gets all likes done by other users also 
    $likes_list                = $this->home_model->get_all_likes();
    //recent activity list
    $activity_list             = $this->home_model->get_all_activities();
    //users of our application
    $user_list                 = $this->home_model->get_all_users();
    // gets all profile pictures
    $profile_pics              = $this->home_model->get_all_profile_pic();
    // gets all the user information 
    $user_info                 = $this->Profile_model->get_all_user_info();
    // check to see if user is logged in
    if(isset($sad['user_id'])){
      // followed users 
      $followed_photographers  = $this->Profile_model->get_all_subscribed_photographer_list($sad['user_id']);
      // unfollowed users
      $unfollowed_user_list    = $this->Profile_model->get_all_unsubscribed_photographers($sad['user_id']);
    // var_dump($subscribed_photographers);die;
    }else{
      $followed_photographers  = '';
      $unfollowed_user_list              = '';
    }
    // select all the users i am following
    $subscribed_photographers  = $this->Profile_model->get_all_subscribed_photographer_list($decrypt_user_id);
    // selects all the user o whome this user is not subscribed

    $view = array(   
        'controller'               => $this,
        'user_id'                  => $decrypt_user_id,  
        'my_image_list'            => $my_image_list,
        'comment_list'             => $comment_list,
        'activity_list'            => $activity_list,
        'likes'                    => $likes_in_image,
        'user_list'                => $user_list,
        'profile_pics'             => $profile_pics,      
        'message'                  => $message,  
        'message_success'          => $message_success,
        'likes_list'               => $likes_list,
        'followed_photographers'   => $followed_photographers,
        'user_info'                => $user_info,
        'subscribed_photographers' => $subscribed_photographers,
        'unfollowed_user_list'     => $unfollowed_user_list, 
        'content'                  => 'view_user_profile',
        'title'                    => 'Profile'
    );
    $this->load->view('/includes/content', $view);
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
//end class follow

  