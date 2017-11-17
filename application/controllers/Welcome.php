<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{ 
		$data["res"] = $this->Lsk_model->getDelegateList(5,0,null);
		$this->load->view('header');
		$this->load->view('welcome_message', $data);
		$this->load->view('footer');
	}
}
