<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maps extends CI_Controller {

	public function index() {
		$this->load->view('maps/index');
		$this->load->view('maps/jaringan_jalan');
		$this->load->view('maps/kontur');
		$this->load->view('maps/perairan');

		$this->load->view('maps/get_data');

		$this->load->view('maps/footer');
	}
}
