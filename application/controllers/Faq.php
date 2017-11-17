<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function index($page=null)
	{
		$this->load->view('header');
		if ($page == null) {
			
		} 
		$this->load->view('footer');
	}
}
