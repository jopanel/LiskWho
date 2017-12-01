<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function index()
	{
		echo json_encode(array("success" => 0, "error" => "You haven't successfuly tipped overlord supreme 1.337 Lisk (4287319913737945577L)"));
	}

	public function update($apikey=null) {
		if ($apikey == API_KEY) {
			$update = $this->Lsk_model->checkUpdate();
			echo json_encode(array("success" => $update["success"], "error" => $update["error"]));
		} else {
			echo json_encode(array("success" => 0, "error" => "You haven't successfuly tipped overlord supreme 1.337 Lisk (4287319913737945577L)"));

		}
	}

	public function giveKarma($delegate=null, $karma=null) {
		if ($delegate == null || $karma == null) {
			exit();
		}
		if ($this->input->is_ajax_request()) {
			echo $this->Lsk_model->giveKarma($delegate,$karma);
		}
	}
}
