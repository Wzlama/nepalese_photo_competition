<?php class notification extends MX_Controller{
	function __construct() {
	    parent::__construct();
	    $this->load->model('notification_model');
	    $this->load->model('home/home_model');
	    $this->load->model('profile/profile_model');
	    $sad = $this->session->all_userdata();
	    if (!$sad['logged_in'] == true) {
	      redirect(base_url());
	    }
	}

	function index(){
		//users of our application
    	$user_list      = $this->home_model->get_all_users();
    	//recent activity list
   		$activity_list  = $this->home_model->get_all_activities();
   		
		$view = array(
			'controller'    => $this,
	        'content'       => 'notification_view',
        	'user_list'     => $user_list,
        	'activity_list' => $activity_list,
	        'title'         => 'Notification'
	    );
	    $this->load->view('/includes/content', $view);
	}

	function setting(){
		// gets all the user information 
    	$user_info     = $this->profile_model->get_all_user_info();
    	//recent activity list
   		$activity_list = $this->home_model->get_all_activities();
   		//users of our application
    	$user_list     = $this->home_model->get_all_users();

		// load the view of array with the view
		$view = array(
			'controller'    => $this,
			'content'       =>  'setting_view',
			'title'         =>  'Setting',
			'user_list'     => $user_list,
        	'activity_list' => $activity_list,
			'user_info'     =>   $user_info,
 		);
	    $this->load->view('/includes/content', $view);
	}

	// function to update the user settings
	function update_user_dob(){
		$data['dob']     = $_POST['value'];
		$data['user_id'] = $_POST['user_id'];

		$this->notification_model->update_user_settings_dob($data);
	}

	// function to update the user setting first name
	function update_user_first_name(){
		$data['first_name']     = $_POST['first_name'];
		$data['user_id'] = $_POST['user_id'];

		$result = $this->notification_model->update_user_settings_first_name($data);
		if($result){
			// the condition may be that we may require a result from the base url in production
			$temp_profile       = 'profile_pic/'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			$new_profile        = 'profile_pic/'.$data['first_name'] .' '.$this->session->userdata('last_name');
			$full_path_profile  = site_url('profile_pic').'/'.$data['first_name'] .' '.$this->session->userdata('last_name');

			// function below updates the databse of profile with updated value of profile picture directory
			$this->notification_model->update_profile_dir($new_profile, $full_path_profile, $data['user_id']);

			// function to rename profile directory
			rename($temp_profile,$new_profile);

			$temp_cover      = 'cover_pic/'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			$new_cover       = 'cover_pic/'.$data['first_name'] .' '.$this->session->userdata('last_name');
			$full_path_cover = site_url('cover_pic').'/'.$data['first_name'] .' '.$this->session->userdata('last_name');

			// function below updates the databse of profile with updated value of profile picture directory
			$this->notification_model->update_cover_dir($new_cover, $full_path_cover,  $data['user_id']);

			$old_name = $this->session->userdata('first_name') .' ' . $this->session->userdata('last_name');
			$new_name = $data['first_name'] .' ' . $this->session->userdata('last_name');

			//along with that we need to update the image table
			$this->notification_model->update_image_dir($old_name, $new_name, $data['user_id']);

			// function to rename cover picture directory
			rename($temp_cover, $new_cover);

			$temp_upload = 'uploaded_image/'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			$new_uploaded_dir = 'uploaded_image/'.$data['first_name'] .' '.$this->session->userdata('last_name');

			// function to rename uploaded image dorectory
			rename($temp_upload, $new_uploaded_dir);

			// update session data
			$this->session->set_userdata('first_name', $data['first_name']);
			$this->session->set_userdata('user_name', $data['first_name'] . ' ' .$this->session->userdata('last_name'));
		}
	}

	// function to update the user setting last name
	function update_user_last_name(){
		$data['last_name']     = $_POST['last_name'];
		$data['user_id'] = $_POST['user_id'];

		$result = $this->notification_model->update_user_settings_last_name($data);
		if($result){
			// the condition may be that we may require a result from the base url in production
			$temp = 'profile_pic/'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			$new_profile  = 'profile_pic/'.$this->session->userdata('first_name') .' '.$data['last_name'];
			$full_path_profile  = site_url('profile_pic').'/'.$this->session->userdata('first_name') .' '.$data['last_name'];

			// function below updates the databse of profile with updated value of profile picture directory
			$this->notification_model->update_profile_dir($new_profile, $full_path_profile, $data['user_id']);

			// function to rename profile directory
			rename($temp,$new_profile);

			$temp_profile = 'cover_pic/'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			$new_cover  = 'cover_pic/'.$this->session->userdata('first_name') .' '.$data['last_name'];
			$full_path_cover = site_url('cover_pic').'/'.$this->session->userdata('first_name') .' '.$data['last_name'];

			// function below updates the databse of profile with updated value of profile picture directory
			$this->notification_model->update_cover_dir($new_cover, $full_path_cover,  $data['user_id']);

			$old_name = $this->session->userdata('first_name') .' ' . $this->session->userdata('last_name');
			$new_name = $this->session->userdata('first_name') .' ' . $data['last_name'];

			//along with that we need to update the image table
			$this->notification_model->update_image_dir($old_name, $new_name, $data['user_id']);

			// function to rename cover picture directory
			rename($temp_profile, $new_cover);

			$temp_upload = 'uploaded_image/'.$this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			$new_uploaded_dir = 'uploaded_image/'.$this->session->userdata('first_name') .' '.$data['last_name'];

			// function to rename uploaded image dorectory
			rename($temp_upload, $new_uploaded_dir);

			// update session data
			$this->session->set_userdata('last_name', $data['last_name']);
			$this->session->set_userdata('user_name', $this->session->userdata('first_name') . ' ' . $data['last_name']);
		}
	}

	// function to update gender
	function update_gender(){
		$data['gender']     = $_POST['gender'];
		$data['user_id'] = $_POST['user_id'];

		$result = $this->notification_model->update_user_settings_gender($data);
	}

	// function to update gender
	function update_district(){
		$data['district']     = $_POST['district'];
		$data['user_id'] = $_POST['user_id'];

		$result = $this->notification_model->update_user_settings_district($data);
	}

	function update_user_chowk_name(){
		$data['chowk_name']  = $_POST['chowk_name'];
		$data['user_id']     = $_POST['user_id'];

		$result = $this->notification_model->update_user_settings_chowk($data);
	}

	// function to deactivate the account
	function deactivate_account(){
		$user_id = $this->session->userdata('user_id');

		$result = $this->notification_model->deactivate_user($user_id);

		if($result){
			$this->session->sess_destroy();
			redirect('login');
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
}?>