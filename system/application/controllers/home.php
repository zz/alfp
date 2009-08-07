<?php
/**
 * Homepage
 */
class Home extends Controller {
   public function __construct() {
	   parent::__construct();
   }
   
   /**
	* Index Page
	*/
   public function index() {
	   
	   $data_header['page_title'] = 'Home Page | Find new friend fast and easy!';
	   $this->load->view('header_view', $data_header);
	   $this->load->view('home_view');
	   $this->load->view('footer_view');
   }
}