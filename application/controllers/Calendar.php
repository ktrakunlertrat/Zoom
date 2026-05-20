<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

    public function index()
    {
        $query = $this->db->get('reserve');

        $data['reserve'] = $query->result();

        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('calendar', $data);
    }
}
