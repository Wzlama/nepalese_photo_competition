<?php 
	class photo extends MX_Controller{
		function __construct() {
		    parent::__construct();
		    $this->load->model('photo_model');
		    $this->load->model('home/home_model');
		    // $sad = $this->session->all_userdata();
		    // if (!$sad['logged_in'] == true) {
		    //   redirect(base_url());
		    // }
  		}

  		function index() {
  			// etremely important to encrypt and decrypt the image id
  			// ?who is this guy commenting about encryption
  			$encryped_id      = $_GET['id'];
    		$photo_id = $this->encrypt_decrypt('decrypt', $encryped_id);

  			// get photo detail according to photo id
		    $photo_dtl      = $this->photo_model->get_photo_list($photo_id);
		    // select only the likes from this particular user. 
    		$likes_in_image = $this->home_model->get_all_likes_by_user();
		    //users of our application
    		$user_list      = $this->home_model->get_all_users();
    		//recent activity list
    		$activity_list             = $this->home_model->get_all_activities();
    		// get comments by image_id
    		$comments       = $this->photo_model->get_comments_by_image_id($photo_id);
    		// gets all profile pictures
    		$profile_pics              = $this->home_model->get_all_profile_pic();
    		// gets likes of the image by photo id 
    		$likes_list     = $this->photo_model->get_likes_on_images($photo_id);

		    $view = array(
		    	'controller'     => $this,
		        'content'        => 'photo_view',
		        'user_list'      => $user_list,
		        'comment_list'   => $comments,
		        'likes'          => $likes_in_image,
        		'profile_pics'   => $profile_pics,
        		'activity_list'  => $activity_list,
		        'likes_list'     => $likes_list,
		        'photo_dtl'      => $photo_dtl,
		        'title'          => 'Follow'
		    );
		    $this->load->view('/includes/content', $view);
		}

		public function delete_photo(){
			// we need to encrypt and edcrypt it.
			$photo_id   = $_POST['id'];
			// post the photo id to the delete function to remove the image
			$result = $this->photo_model->delete_photo($photo_id);
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
	//end of class profile
?>