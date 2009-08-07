<?php
class User extends Controller {
   public function __construct() {
	   parent::__construct();
   }

   public function index() {
	   if($this->session->userdata('username') == FALSE) {
		   header("Location: ". site_url('user/login'));
		   exit(1);
	   }

	   $header_data['page_title'] = $this->session->userdata('username');
	   $this->load->view('header_view', $header_data);
	   $this->load->view('user/index_view');
	   $this->load->view('footer_view');
   }
   
   public function login() {
	   // if user login location to home page
	   if (!$this->session->userdata('username') == FALSE) {
		   header("Location: ". site_url('user'));
		   exit(1);
	   }

	   // form Valid
	   $this->load->helper(array('form'));
	   $this->load->library('form_validation');
	   $this->form_validation->set_rules('username', 'Username', 'required');
	   $this->form_validation->set_rules('password', 'Password', 'required|callback__login_check');
	   
	   $header_data['page_title'] = 'User Login';
	   $this->load->view('header_view', $header_data);

	   if ($this->form_validation->run() == FALSE) {
		   $this->load->view('user/login_view');
	   } else {
		   // Add user to session
		   $data = array(
						 'username' => $_POST['username'],
						 'email' => $_POST['password'],
						 );
		   $this->session->set_userdata($data);
		   header("Location: ". site_url('user'));
	   }
	   $this->load->view('footer_view');
   }


   /**
	* User logout
	*/
   public function logout() {
	   $items = array(
					  'username' => '',
					  'email' => '',
					  );
	   $this->session->unset_userdata($items);
	   header("Location: ". base_url('user/login'));
   }

   /**
	* User Signup
	*/
   public function signup() {
	   // Form Valid
	   $this->load->helper(array('form'));
	   $this->load->library('form_validation');
	   $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash|min_length[3]|max_length[50]|xss_clean|callback__username_check');
	   $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|md5');
	   $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
	   $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|callback__email_check');

	   $header_data['page_title'] = 'User Signup';
	   $this->load->view('header_view', $header_data);
	   if($this->form_validation->run() == FALSE) {
		   $this->load->view('user/signup_view');
	   } else {
		   // Add new user to database
		   $data = array(
						 'username' => $_POST['username'],
						 'password' => $_POST['password'],
						 'nickname' => '',
						 'email' => $_POST['email'],
						 'created' => time(),
						 'changed' => time(),
						 'last_login' => time(),
						 );
		   $this->db->insert('users', $data);
		   // Set session for login
		   $data = array(
						 'username' => $_POST['username'],
						 );
		   $this->session->set_userdata($data);

		   // Let user complete infomation
		   header("Location: ". site_url('user/'));
	   }
	   $this->load->view('footer_view');
	   
   }
   
   /**
	* Check username is ready eixts
	*/
   public function _username_check($str) {
	   $count = $this->db->from('users')->where('username', $str)->
		   count_all_results();
	   if ($count > 0) {
		   $this->form_validation->set_message('_username_check', 'Username have already eixts, please use another one.');
		   return FALSE;
	   }else {
		   return TRUE;

	   }
   }

   /**
	* Check email is ready eixts
	*/
   public function _email_check($str) {
	   $count = $this->db->from('users')->where('email', $str)->
		   count_all_results();
	   if ($count > 0) {
		   $this->form_validation->set_message('_email_check', 'E-mail address have already use, please use another one.');
		   return FALSE;
	   } else {
		   return TRUE;
	   }
	   
   }

   /**
	* Login Check
	*/
   public function _login_check($str) {
	   $username = $_POST['username'];
	   $password = md5($_POST['password']);
	   $user = $this->db->get_where('users', array('username' => $username, 'password' => $password), 1)->result();
	   if (empty($user[0]->id)) {
		   $this->form_validation->set_message('_login_check', 'Username or Password wrong!');
		   return FALSE;
	   } else {
		   // Add user infomation to session.
		   $data =  array(
						  'user_id' => $user[0]->id,
						  'username' => $user[0]->username,
						  'email' => $user[0]->email,						  
						  );
			   
		   $this->session->set_userdata($data);
		   return TRUE;
	   }
	   
   }
   
}