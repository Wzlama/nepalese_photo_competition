<?php
class login extends MX_Controller{
    
  function __construct() {
    parent::__construct();
    $this->load->model('Login_model');;
    $this->load->helper(array('email'));
    $this->load->library(array('email'));
  }

  function index() {
    if ($this->_is_logged_in() == TRUE)
    {
      redirect('home');
    }
    $prev_date = date('M Y', strtotime(date('Y-m')." -1 month"));
    // we need to find a algorithm to find out the best photo of last month
    // $pop_photo = $this->login_modle->get_pop_image_of_last_month();
    
    $data = $this->Login_model->get_pop_image_of_last_month();
    // var_dump($data);
    // die;
    if(!empty($_GET['msg'])){
      $msg = $_GET['msg']; 
    }else{
      $msg = false;
    }
    
    
    //   $nav     = $this->encrypt_decrypt('decrypt',"VXFMOXdiM0s5WWo0ZndBNEVOMU9SUT09");
    //   var_dump($nav);
    //   die;

    $view = array(
        'last_month_pic' => $data,
        'msg'            => $msg,
        'content'        => 'login_view',
        'title'          =>'Login'
    );
    $this->load->view('/includes/content', $view);
  }

  // function executed when forgot password is clicked
   public function forgot(){
      $view = array(
        'content' => 'forgot_password'
      );
      $this->load->view('includes/content', $view);
   }

   // function to load terms and  conditions
   public function terms_and_condition(){
      $view = array(
        'content' => 'terms_and_condition_view'
      );
      $this->load->view('includes/content',  $view);
   }

   // function to load developers page
   public function dev(){
      $view = array(
        'content' => 'developers'
      );
      $this->load->view('includes/content',  $view);
   }

   // function that creates new password
  function create_new_password(){
      $user_id = $this->encrypt_decrypt('decrypt', $_GET['puk']);
      
      $view = array(
        'user_id'  => $user_id,
        'content'   => 'new_password_view'
      ); 

      $this->load->view('includes/content', $view);
  }

  // function to create new password
  public function validate_new_password(){// Validate form.
    $this->load->library('form_validation');

    $data1 = array('success' => false, 'messages' => array());
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

    if ($this->form_validation->run() == TRUE)
    {
      $data['email']    = $this->input->post('email');

      $user_info = $this->Login_model->get_user_by_email($data['email']);

      if(!empty($user_info)){ 
        // if we have the user in database 
        if($this->send_mail($data['email'],$data['type'] = $user_info[0]->id)){
            $data1['success']           = true; 
            $data1['messages']['email'] = 'Please check your email';
            echo json_encode($data1);   
        }
      }else{
        $data1['messages']['email'] = 'Please enter correct email address';
        echo json_encode($data1);
      } 
    }else{
      $data1['messages']['email'] = form_error('email');
      echo json_encode($data1);
    }
  }
  // end of function create new password

  // start of the function password_change
  function password_changed(){
    $this->load->library('form_validation');

    $data1 = array('success' => false, 'messages' => array());
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
    $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]');

    if($this->form_validation->run() == TRUE){
      $password           = $this->input->post('password');
      $user_id            = $this->input->post('user_id');
      $data['password']   = $this->encrypt_decrypt('encrypt',$password);

      $test = $this->Login_model->update_password($data['password'] ,$user_id);
    //   var_dump($test);
    //   die;

      if($test){
        $data1['success'] = true;
        $data1['pass_ch'] = 'Casdfasdfsaf123244sadf3241';
        // just to verify email has been sent
        $this->send_mail($test[0]->email_address,$data['type']='pass_changed');
        echo json_encode($data1);
      }
    }else{
      $data1['messages']['confirm_password'] = 'Password mismatch.';
      echo json_encode($data1);
    }
  }
  // end function password_change

  function createNewUser(){
    // Validate form.
    $this->load->library('form_validation');

    $data1 = array('success' => false, 'messages' => array());
    $this->form_validation->set_rules('firstName', 'First Name', 'trim|required');      
    $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
    $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
    $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]');        
    $this->form_validation->set_rules('day', 'Day You were Born is', 'required');
    $this->form_validation->set_rules('month', 'Month You were Born is', 'required');
    $this->form_validation->set_rules('year', 'Year You were Born is', 'required');
    $this->form_validation->set_rules('country', 'Country you are from is required.', 'required');
    $this->form_validation->set_rules('district', 'District you are from is required.', 'required');
    $this->form_validation->set_rules('chowk', 'Chowk you are from is required.', 'required');
    $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>')
    ;$this->form_validation->set_rules('phoneNum', 'Phone Number', 'required|min_length[10]');
    
    if ($this->form_validation->run() == TRUE)
    {
      $data['first_name']    = $this->input->post('firstName');
      $data['last_name']     = $this->input->post('lastName');
      $data['email_address'] = $this->input->post('email');
      $password              = $this->input->post('password');
      $data['password']      = $this->encrypt_decrypt('encrypt',$password);
      $data['date_of_birth'] = $this->input->post('day') . '/' . $this->input->post('month') . '/' . $this->input->post('year');
      $data['country']       = $this->input->post('country');
      $data['district']      = $this->input->post('district');
      $data['chowk']         = $this->input->post('chowk');
      $data['gender']        = $this->input->post('sex');
      $data['created_at']    = date("F j, Y, g:i a");  
      $data['user_name']     = $this->input->post('firstName').' '.$this->input->post('lastName');
      $data['phoneNum']        = $this->input->post('phoneNum');

      // the function below creats user in database
      $result = $this->Login_model->create_user($data);
      if($result){
        // just to verify email has been sent
        $this->send_mail($data['email_address'],$data['type']='new_user');
      }
      
      $data1['success'] = true;
        // call the function to send email
        // $this->send_mail($data['email_address']);

        mkdir("uploaded_image/". $result[0]->first_name . ' ' .$result[0]->last_name);
        $this->create_login_session($result);
        echo json_encode($data1);
    }else{
        foreach($_POST as $key => $value) {
          $data1['messages'][$key] = form_error($key);
        }
      echo json_encode($data1);
    }
  }

  /**
   * Process user authentication.
   */
  public function authenticate()
  {
    // var_dump('We are here.');
    // die;
     // Validate form.
    $this->load->library('form_validation');
    $data1 = array('success' => false, 'messages' => array());
    $this->form_validation->set_rules('email_sign_in', 'Email Address', 'required');      
    $this->form_validation->set_rules('password_sign_in', 'Password', 'required');
    $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
    if ($this->form_validation->run() == TRUE)
    {
      // data from the user login form
      $data['email_address'] = $this->input->post('email_sign_in');
      $password = $this->input->post('password_sign_in');
      $data['password'] = $this->encrypt_decrypt('encrypt', $password);

      // result of checking the data in database
      $user_id = $this->Login_model->authenticate($data);
      
      if ($user_id > 0){
        // Create session var
        $user = $this->Login_model->find_by_id($user_id);
       // $this->send_mail($data['email_address'],$data['type']='new_user');
        $this->create_login_session($user);
        $this->session->set_flashdata('flash_message', 'You are logged in.');
        $data1['success'] = true;
      }else{
        $data1['messages']['email_sign_in'] = 'Email address and password does not match.';
      }
      echo json_encode($data1);
    }else{
      $data1['messages']['email_sign_in'] = 'Email address and password does not match.';
      echo json_encode($data1);
    }
  }

  // function to send mail on user creation
  public function send_mail($to_email,$type) { 
    $config = Array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://mail.nplespc.com',
        'smtp_port' => 465,
        'smtp_user' => 'info@nplespc.com',
        'smtp_pass' => 'info@nplespc.com'
    );
    
    $this->load->library('email',$config);
    // Set to, from, message, etc.
    $this->email->to($to_email);
    $this ->email->from("info@nplespc.com");
    if($type !='new_user' || $type != 'pass_changed'):
        $puk = $this->encrypt_decrypt('encrypt', $type);
        $url = base_url().'login/create_new_password?puk=' . $puk;
        $this->email->subject("Request to send your password.");
        $this->email->message("
            <table style=' border: 1px solid #e1e1e1; background:#5f5146; background-repeat: no-repeat; '>
        		<header style='margin: 0px auto;'>
        			<h3 style='font-size: 24px; line-height:15px; color: #fff; background: #13191d; height: 40px;  padding:10px 0px 0 10px;'><a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition</a></h3>			
        		</header>
        		<section style='padding-bottom: 20px; background:#5f5146; color: #fff; padding:0px 0px 10px 10px; height: 30%'>
        			<h4>Hello</h4>
        				You recently requested to reset your password for your Nepalese Photo Competition.<br> Click the button below to reset it<br>
                                        <a href='$url' style='text-decoration: none; color: #fff;'><button style='height: 35px; margin: 0px auto; border: #e1e1e1; margin: 10px;'>Reset your Password</button></a>
                                        <br>If you did not requested a password reset, please ignore this email or reply to let us know.

                                        <br>Thanks<br>
                                        <a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition</a>
        		</section>
        		<footer style='background: #000; color: #fff; margin-top:10px;'>
        			<a href='www.nplespc.com/login/terms_and_condition' style='text-decoration: none; color: #fff;'>Terms And Condition&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>&copy;<a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition 2017</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='www.nplespc.com/login/dev' style='text-decoration: none; color: #fff;'>Developers</a>
        		</footer>
        	</table>");
    endif;
    if($type == 'new_user' && $type != 'pass_changed'):
        $this->email->subject("User regestiration confirmiation");
        $this->email->message("
        	<table style=' border: 1px solid #e1e1e1; background: #5f5146; background-repeat: no-repeat; '>
        		<header style='margin: 0px auto;'>
        			<h3 style='font-size: 24px; line-height:15px; color: #fff; background: #13191d; height: 40px;  padding:10px 0px 0 10px;'>Welcome to <a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition</a></h3>			
        		</header>
        		<section style='padding-bottom: 20px; background:#5f5146; color: #fff; padding:0px 0px 10px 10px;'>
        			<h4>Congratulation.</h4>
        				Thank you for joining Nepalese Photo Competition.<br>
        				Upload new photos every month and win Rs.2500 every month.
        		</section>
        		<footer style='background: #000; color: #fff; margin-top: 10px;'>
        			<a href='www.nplespc.com/login/terms_and_condition' style='text-decoration: none; color: #fff;'>Terms And Condition&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>&copy;<a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition 2017</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='www.nplespc.com/login/dev' style='text-decoration: none; color: #fff;'>Developers</a>
        		</footer>
        	</table>");    
    endif;
    if($type == 'pass_changed' && $type != 'new_user'):
        $this->email->subject("Password change successful.");
        $this->email->message("
        <table style=' border: 1px solid #e1e1e1; background:#5f5146; background-repeat: no-repeat; '>
    		<header style='margin: 0px auto;'>
    			<h3 style='font-size: 24px; line-height:15px; color: #fff; background: #13191d; height: 40px;  padding:10px 0px 0 10px;'><a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition</a></h3>			
    		</header>
    		<section style='padding-bottom: 20px; color: #fff; padding:0px 0px 10px 10px; height: 20%'; background: #5f5146;>
    				You have recently changed your password for your Nepalese Photo Competition.<br> 
                                    <br>If you did not reset a password, please ignore this email or reply to let us know.

                                    <br>Thanks<br>
                                    <a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition</a>
    		</section>
    		<footer style='background: #000; color: #fff;'>
    			<a href='www.nplespc.com/login/terms_and_condition' style='text-decoration: none; color: #fff;'>Terms And Condition&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>&copy;<a href='www.nplespc.com' style='text-decoration: none; color: #fff;'>Nepalese Photo Competition 2017</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='www.nplespc.com/login/dev' style='text-decoration: none; color: #fff;'>Developers</a>
    		</footer>
    	</table>");
    endif;
    $result = $this->email->send();
    if($result){
      return true;
    }
    return false;
  } 
  
  /**
   * Process user logout.
   */
  public function logout()
  {
    $this->session->sess_destroy();
    redirect('login');
  }

  // function o encrypt or decrpt
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

  protected function create_login_session($data)
  {
    $session_data = array(
      'email_address'  => $data[0]->email_address,
      'user_name'      => $data[0]->first_name . ' ' . $data[0]->last_name,
      'first_name'     => $data[0]->first_name,
      'last_name'      => $data[0]->last_name,
      'user_id'        => $data[0]->id,
      'logged_in'      => TRUE,
      'ip'             => $this->input->ip_address()
    );
    $this->session->set_userdata($session_data);
  }

  private function _is_logged_in()
  {
    $session_data = $this->session->all_userdata();
    return (isset($session_data['user_id']) && $session_data['user_id'] > 0 && $session_data['logged_in'] == TRUE);
  }

}