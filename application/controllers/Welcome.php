<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{  
		$data["res"] = $this->Lsk_model->getHomeData();
		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}
}
