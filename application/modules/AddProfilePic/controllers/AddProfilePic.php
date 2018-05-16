<?php
class addProfilePic extends MX_Controller{
  function __construct() {
    parent::__construct();
    $this->load->model('addProfilePic_model');
    $this->load->model('follow/follow_model');
    $this->load->model('home/home_model');
    $sad = $this->session->all_userdata();
    if (!$sad['logged_in'] == true) {
      redirect(base_url());
    }
  }
  
  function index() {
    $users_list = $this->follow_model->get_users_list();
    //recent activity list
    $activity_list  = $this->home_model->get_all_activities();

    $view = array(
      'controller'    => $this,
      'users_list'    => $users_list,
      'activity_list' => $activity_list,
      'content' => 'addProfilePic_view',
      'title'=>'Add Profile Picture'
    );
    $this->load->view('/includes/content', $view);
  }

  public function upload(){
    $sad = $this->session->all_userdata();

    if(!is_dir("profile_pic/". $sad["user_name"])) {
      mkdir("profile_pic/". $sad["user_name"], 0777);
      $upload_path = ("/profile_pic/". $sad['user_name']);
    }else{
      $upload_path = ("/profile_pic/". $sad['user_name']);
    }
    
    if (!empty($_FILES) ) 
    {
      $file = $_FILES['profilePic'];

      $user_id   = $sad['user_id']; 
      $image_data = array(  
          'file_name'       => $file['name'],
          'file_type'      => $file['type'],
          'file_size' => $file['size'],
          'path'      => $upload_path,
          'full_path' => base_url().$upload_path,
          'created_at'=> date("F j, Y, g:i a"),
          'user_id'   => $user_id,
      );

      $tempFile = $_FILES['profilePic']['tmp_name'];
      $fileName = $_FILES['profilePic']['name'];
      $targetPath = getcwd() .  $upload_path . '/';
      $targetFile = $targetPath . $fileName;
      if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/jpg'){
        if(move_uploaded_file($tempFile, $targetFile) && $this->addProfilePic_model->insert_image('profile_picture',$image_data)){
         redirect('./addCoverPic', 'refresh');
        }else{
          echo 'Your image could not be uploaded.';
        }
      }else{
        redirect('./addProfilePic', 'refresh');
      }
    }
  }

  function change_profile_pic(){
    $user_id = $this->session->userdata('user_id');
    $profile_picture_detail = $this->addProfilePic_model->get_profile_picture_detail_by_id($user_id);
    //recent activity list
    $activity_list             = $this->home_model->get_all_activities_by_id($user_id);
    $view = array(      

        'controller'               => $this,
        'content'                  => 'change_profile_pic',
        'profile_picture_detail'   => $profile_picture_detail,
        'activity_list'            => $activity_list,
        'title'                    => 'Change Profile Picture'
    );
    $this->load->view('/includes/content', $view);
  }


  function update_profile_pic(){
    // get the list of data saved in session
    $sad = $this->session->all_userdata();

    // path of the user whose image is in the path
     if(!is_dir("profile_pic/". $sad["user_name"])) {
      mkdir("profile_pic/". $sad["user_name"], 0777);
      $upload_path = ("/profile_pic/". $sad['user_name']);
    }else{
      $upload_path = ("/profile_pic/". $sad['user_name']);
    }

    if (!empty($_FILES) ) 
    {
      $file = $_FILES['profilePic'];

      $user_id   = $sad['user_id']; 
      $image_data = array(  
          'file_name' => $file['name'],
          'file_type' => $file['type'],
          'file_size' => $file['size'],
          'path'      => $upload_path,
          'full_path' => base_url().$upload_path,
          'created_at'=> date("F j, Y, g:i a"),
          'user_id'   => $user_id,
      );

      $tempFile = $_FILES['profilePic']['tmp_name'];
      $fileName = $_FILES['profilePic']['name'];
      $targetPath = getcwd() .  $upload_path . '/';
      $targetFile = $targetPath . $fileName;
      if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/jpg'){
        if(move_uploaded_file($tempFile, $targetFile) && $this->addProfilePic_model->update_profile_pic('profile_picture',$image_data)){
          redirect('profile', 'refresh');
        }else{
          echo 'Your image could not be uploaded.';
        }
      }else{
        redirect('profile', 'refresh');
      }
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
//end class addProfilePic
?>