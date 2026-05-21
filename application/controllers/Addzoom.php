<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addzoom extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // โหลด session
        $this->load->library('session');

        // เช็ค login
        if(!$this->session->userdata('logged_in'))
        {
            redirect('login');
        }
    }

    public function index($id = null)
    {
        $this->load->database();

        // ดึงข้อมูลตาม id
        $data['reserve'] = $this->db
            ->where('id', $id)
            ->get('reserve')
            ->row();

        // ถ้าไม่พบข้อมูล
        if(!$data['reserve']){
            show_404();
        }

        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('addzoom', $data);
    }

    public function update($id)
    {
        $this->load->database();

        $data = array(
            'zoom_number' => $this->input->post('zoom_number'),
            'zoom_password' => $this->input->post('zoom_password')
        );

        $this->db->where('id', $id);
        $this->db->update('reserve', $data);

        redirect('request');
    }
}