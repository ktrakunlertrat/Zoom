<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{

		$this->load->database();

        $data['unread_count'] = 0;

        if($this->session->userdata('logged_in')){

            $data['unread_count'] = $this->db
                ->where('is_read', 0)
                ->count_all_results('reserve');
        }

		$this->load->view('header');
		$this->load->view('navbar');
		$this->load->view('welcome', $data);
	}
}
