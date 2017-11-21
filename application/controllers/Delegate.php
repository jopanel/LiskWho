<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delegate extends CI_Controller {

	public function index($profile=null)
	{
		$this->load->view('header');
		if ($profile == null) {
			$this->load->view('welcome_message');
		} else {
			$data["comment_thread"] = $this->Lsk_model->generatePageDateIdentifier();
			$this->load->view('open_delegate', $data);
		}
		$this->load->view('footer');
	}
}
