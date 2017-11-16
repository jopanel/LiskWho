<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{ 
		$this->Lsk_model->logout();
		redirect(base_url(), 'auto');
		
	}
}
