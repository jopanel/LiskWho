<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delegate extends CI_Controller {

	public function profile($profile=null)
	{
		$this->load->view('header');
		if ($profile == null) {
			$this->load->view('welcome_message');
		} else {
			$data["comment_thread"] = $profile."-".$this->Lsk_model->generatePageDateIdentifier();
			$data["delegate"] = $profile;
			$data["delegateinfo"] = $this->Lsk_model->getDelegateData($profile);
			$this->load->view('open_delegate', $data);
		}
		$this->load->view('footer');
	}
}
