<?php
class follow extends MX_Controller{
    
  function __construct() {
    parent::__construct();
    $this->load->model('follow_model');    
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
        'content'       => 'follow_view',
        'title'         => 'Follow'
    );
    $this->load->view('/includes/content', $view);
  }

  function add_followers(){
    if(!empty($_POST)){
      $data['followed_by'] = $_POST['followed_by'];
      $data['user_id'] = $_POST['user_id'];
      $userInfo = $this->follow_model->get_user_by_id($data['followed_by']);
      $data['first_name'] = $userInfo[0]->first_name;
      $data['last_name'] = $userInfo[0]->last_name;
      $data['email_address'] = $userInfo[0]->email_address;

      //add the followers to database 
      $result = $this->follow_model->add_followers('follower',$data);
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
//end class follow
  