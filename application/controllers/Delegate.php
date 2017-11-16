<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delegate extends CI_Controller {

	public function index($profile=null)
	{
		$this->load->view('header');
		if ($profile == null) {
			$this->load->view('welcome_message');
		} else {
			$this->load->view('open_delegate');
		}
		$this->load->view('footer');
	}
}
