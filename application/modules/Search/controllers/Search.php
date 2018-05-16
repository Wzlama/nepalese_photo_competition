<?php class search extends MX_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('search_model');
		$this->load->model('profile/profile_model');
		$this->load->model('home/home_model');
		$sad = $this->session->all_userdata();
		if( !$sad['logged_in'] == true){
			redirect(base_url());
		}
	}

	public function index(){		
		$sad = $this->session->all_userdata();
		// input data 
		$name      = $_POST['search'];
		// list of users got from database
		$user_info = $this->search_model->search_users($name); 
		//recent activity list
    	$activity_list  = $this->home_model->get_all_activities();
    	// select all the users i am following
    	$subscribed_photographers  = $this->profile_model->get_all_subscribed_photographer_list($sad['user_id']);

		$view = array(
			'controller'               => $this, 
			'user_info'                => $user_info,
			'activity_list'            => $activity_list,
			'content'                  => 'search_view',
			'subscribed_photographers' => $subscribed_photographers,
			'title'                    => 'Search Result'
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
} ?>