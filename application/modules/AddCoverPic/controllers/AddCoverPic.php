<?php
class addCoverPic extends MX_Controller{
  function __construct() {
    parent::__construct();
    $this->load->model('addCoverPic_model');
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
        'content' => 'addCoverPic_view',
        'title'=>'Add Cover Picture'
    );
    $this->load->view('/includes/content', $view);
  }

  public function upload(){
    $sad = $this->session->all_userdata();

    if(!is_dir("cover_pic/". $sad["user_name"])) {
      mkdir("cover_pic/". $sad["user_name"], 0777);
      $upload_path = ("/cover_pic/". $sad["user_name"]);
    }else{
      $upload_path = ("/cover_pic/". $sad["user_name"]);
    }

    if ( !empty($_FILES) ) 
    {
      $file = $_FILES['coverPic'];
      $full_path = site_url('/cover_pic');
      $user_id   = $sad['user_id'];    
      $data['file_name'] = $file['name'];
      $data['file_type'] = $file['type'];
      $data['file_size'] = $file['size'];      
      $data['path'] = $upload_path;
      $data['full_path'] = base_url().'/' .$upload_path;
      //remove the published column from the database after finishing the upload
      $data['created_at'] = date("F j, Y, g:i a");
      $data['user_id'] = $user_id;  
      // var_dump($data);
      // die;

      $tempFile = $_FILES['coverPic']['tmp_name'];
      $fileName = $_FILES['coverPic']['name'];
      $targetPath = getcwd() .  $upload_path . '/';
      $targetFile = $targetPath . $fileName ;

      if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/jpg'){
        if(move_uploaded_file($tempFile, $targetFile) && $this->addCoverPic_model->insert_image('cover_picture',$data)){
         redirect('./follow', 'refresh');
        }else{
          echo 'Your image could not be uploaded.';
        }
      }else{
        redirect('./addCoverPic', 'refresh');
      }
    }
  }

  function change_cover_pic(){
    $user_id = $this->session->userdata('user_id');
    $cover_picture_detail = $this->addCoverPic_model->get_cover_picture_detail_by_id($user_id);
    //recent activity list
    $activity_list             = $this->home_model->get_all_activities_by_id($user_id);
    $view = array(      
        'controller'               => $this,
        'content'                  => 'change_cover_pic',
        'cover_picture_detail'     => $cover_picture_detail,
        'activity_list'            => $activity_list,
        'title'                    => 'Change Cover Picture'
    );
    $this->load->view('/includes/content', $view);
  }


  function update_cover_pic(){
    // get the list of data saved in session
    $sad = $this->session->all_userdata();

    if(!is_dir("cover_pic/". $sad["user_name"])) {
      mkdir("cover_pic/". $sad["user_name"], 0777);
      $upload_path = ("/cover_pic/". $sad["user_name"]);
    }else{
      $upload_path = ("/cover_pic/". $sad["user_name"]);
    }

    if ( !empty($_FILES) ) 
    {
      $file = $_FILES['coverPic'];
      $full_path = site_url('/cover_pic');
      $user_id   = $sad['user_id'];    
      $data['file_name'] = $file['name'];
      $data['file_type'] = $file['type'];
      $data['file_size'] = $file['size'];      
      $data['path'] = $upload_path;
      $data['full_path'] = base_url().'/' .$upload_path;
      //remove the published column from the database after finishing the upload
      $data['created_at'] = date("F j, Y, g:i a");
      $data['user_id'] = $user_id;  
      // var_dump($data);
      // die;

      $tempFile = $_FILES['coverPic']['tmp_name'];
      $fileName = $_FILES['coverPic']['name'];
      $targetPath = getcwd() .  $upload_path . '/';
      $targetFile = $targetPath . $fileName ;

      if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/jpg'){
        if(move_uploaded_file($tempFile, $targetFile) && $this->addCoverPic_model->update_cover_pic('cover_picture',$data)){
         redirect('profile', 'refresh');
        }else{
          echo 'Your image could not be uploaded.';
        }
      }else{
        redirect('addCoverPic', 'refresh');
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
// end class addCoverPic