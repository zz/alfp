<?php
class Photo extends Controller {
   public function __construct() {
	   parent::__construct();
   }

   /**
	* List all photos
	*/
   public function index( ) {
	   
   }

   /**
	* Show photo
	*/
   public function show( ) {
		     
   }

   /**
	* List photos by user
	*/
   public function user($id = null) {
	   $id = (int) $id;
	   $photos = $this->db->get_where('files', 
									  array('user_id'=>$id))->result();
	   $header_data['page_title'] = "User's photo";
	   $body_data['photos'] = $photos;
	   $this->load->view('header_view', $header_data);
	   $this->load->view('photo/user_view', $body_data);
	   $this->load->view('footer_view');
   }

   /**
	* List photos by tag
	*/
   public function tag () {
	   
   }

   /**
	* Upload Photo
	*/
   public function upload() {
	   if (!$this->session->userdata('user_id')) {
		   header("Location: ". site_url('user/login'));
		   exit(1);
	   }
	   
	   $upload_path = 'files/' . date("Ym");
	   if (!is_dir($upload_path)) {
		   mkdir($upload_path);
	   }
	   
	   // upload config
	   $config['upload_path'] = $upload_path;
	   $config['allowed_types'] = 'gif|jpg|png';
	   $config['max_size'] = '1024';
	   $config['max_width'] = '1280';
	   $config['max_height'] = '1024';
	   $config['encrypt_name'] = TRUE;

	   $this->load->library('upload', $config);
	   if (!$this->upload->do_upload()) {
		   echo 'error';
	   } else {
		   $upload_data = $this->upload->data();
		   $data = array(
						 'type' => 'photo',
						 'created' => time(),
						 'user_id' => $this->session->userdata('user_id'),
						 'path' => $upload_path . '/' . $upload_data['file_name'],
						 );

		   $this->_thumb($upload_data['file_name'], $upload_path);
		   $this->db->insert('files', $data);
		   // get the new photo's id
		   $this->db->limit(1);
		   $this->db->orderby("id DESC");
		   $photo = $this->db->get_where('files', array('user_id'=>$this->session->userdata('user_id')))->result();
		   $photo_id = $photo[0]->id;

		   // Add tags to photo uploaded
		   if (!empty($_POST['tags'])) {
			   $tags = explode(',', $_POST['tags']);
			   foreach ($tags as $tag) {
				   // remove black
				   $tag = preg_replace('/\s+/', '', $tag);
				   $count = $this->db->from('tags')->where('name', $tag)
					   ->count_all_results();
				   if ($count < 1) {					   
					   // add new tag to tag's table
					   $data = array('name' => $tag);
					   $this->db->insert('tags', $data);
					   $this->db->limit(1);
					   $this->db->orderby("id DESC");
					   $tag = $this->db->get('tags')->result();
					   $tag_id = $tag[0]->id;
				   } else {
				   	   $this->db->limit(1);
				   	   $tag = $this->db->get_where('tags', array('name'=> $tag))->result();
				   	   $tag_id = $tag[0]->id;
				   }
   				   $this->db->insert('filehavetags', array('file_id'=>$photo_id, 'tag_id'=>$tag_id));
			   }
		   }
		   

		   header("Location: " . site_url('photo/user/' . $this->session->userdata('user_id')));
	   }
	   
   }


   private function _thumb($file_name, $file_path) {
	   $config['image_library'] = 'gd2';
	   $config['source_image'] = $file_path . '/' . $file_name;
	   $config['create_thumb'] = TRUE;
	   $config['maintain_ratio'] = TRUE;
	   $config['new_image'] = $file_path .'/'. $file_name;
	   $config['width'] = 120;
	   $config['height'] = 120;

	   $this->load->library('image_lib', $config);
	   $this->image_lib->resize();
   }
}
