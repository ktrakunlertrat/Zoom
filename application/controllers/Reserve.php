<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserve extends CI_Controller {

    private function convertThaiDate($date)
    {
        $explode = explode('/', $date);

        $day = $explode[0];
        $month = $explode[1];
        $year = $explode[2] - 543;

        return $year . '-' . $month . '-' . $day;
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('reserve');
    }

    public function save()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone_number' => $this->input->post('phone_number'),
            'affiliation' => $this->input->post('affiliation'),
            'meeting_topic' => $this->input->post('meeting_topic'),
            'room_size' => $this->input->post('room_size'),
            'start_date' => $this->convertThaiDate($this->input->post('start_date')),
            'start_time' => $this->input->post('start_time'),
            'end_date' => $this->convertThaiDate($this->input->post('end_date')),
            'end_time' => $this->input->post('end_time')
        );

        $this->db->insert('reserve', $data);

        echo "
        <script>
            alert('บันทึกข้อมูลสำเร็จ');
            window.location.href='".base_url('index.php/welcome')."';
        </script>
        ";
    }
}