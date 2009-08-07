<?php
class topic extends Controller {
   public function __construct() {
	   parent::__construct();
   }
   
   /**
	* Show topic
	*/
   public function show ($id = null) {
	   $id = (int) $id;
	   $this->db->limit(1);
	   $topic = $this->db->get_where('topics', array('id'=> $id, 'status >' => -1))
		   ->result();
	   if (isset($topic[0]) && $topic[0]->id > 0) {	  	   	   
		   $header_data['page_title'] = $topic[0]->title;
		   $body_data['topic'] = $topic[0];
		   $this->load->view('header_view', $header_data);
		   $this->load->view('topic/show_view', $body_data);
		   $this->load->view('footer_view');
	   } else {
		   $this->load->view('404_view');
	   }
   }
   
   /**
	* List topics by user
	*/
   public function user($id = null) {
	   // show topics
	   $id = (int) $id;
	   $this->db->order_by("created", "DESC");
	   $topics = $this->db->get_where('topics',
									  array(
											'user_id'=>$id,
											'status >' => -1,
											))->result();
	   
	   $body_data['topics'] = $topics;
	   $header_data['page_title'] = 'User Topics List';
	   $this->load->view('header_view', $header_data);
	   $this->load->view('topic/user_view', $body_data);
	   $this->load->view('footer_view');

   }

   /**
	* List all topics
	*/
   public function index() {
	   
   }

   /**
	* List topics by tag
	*/
   public function tag() {
	   
   }

   /**
	* Post topic
	*/
   public function upload() {
   }

   /**
	* Post Topic
	*/
   public function post() {
	   // post topic
	   $data = array(
					 'title' => $_POST['title'],
					 'content' => $_POST['content'],
					 'created' => time(),
					 'user_id' => $this->session->userdata('user_id')
					 );
	   if(!$this->db->insert('topics', $data)) {
		   
	   } else {
		   // get the lastest topic's id
		   $this->db->limit(1);
		   $this->db->orderby("id DESC");
		   $topic = $this->db->get_where('topics', array('user_id'=>$this->session->userdata('user_id')))->result();
		   $topic_id = $topic[0]->id;	   
	   	   // Add tags to topic post
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
   				   $this->db->insert('topichavetags', array('topic_id'=>$topic_id, 'tag_id'=>$tag_id));
			   }
		   }	  
		    
		   header("Location: ". site_url("topic/user/".$this->session->userdata('user_id')));
		   exit(1);
	   }
	   
   }

   /**
	* Delete topic
	*/
   public function delete( ) {
	   
   }
   

   
   
}