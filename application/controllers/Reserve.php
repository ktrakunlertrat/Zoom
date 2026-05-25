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
        $start_date = $this->convertThaiDate(
            $this->input->post('start_date')
        );

        $end_date = $this->convertThaiDate(
            $this->input->post('end_date')
        );

        $room_size = $this->input->post('room_size');

        /*
        |--------------------------------------------------------------------------
        | เช็คห้อง 500 คน
        |--------------------------------------------------------------------------
        | ถ้ามีการจองช่วงวันซ้อนกัน จะไม่ให้จอง
        */

        if($room_size == '500'){

            $sql = "
                SELECT *
                FROM reserve
                WHERE room_size = '500'
                AND (
                    start_date <= ?
                    AND end_date >= ?
                )
            ";

            $check = $this->db->query($sql, [
                $end_date,
                $start_date
            ]);

            if($check->num_rows() > 0){

                echo "
                <script>
                    alert('ห้อง Zoom ขนาด 500 คน ถูกจองในช่วงวันดังกล่าวแล้ว');
                    window.history.back();
                </script>
                ";

                return;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone_number' => $this->input->post('phone_number'),
            'affiliation' => $this->input->post('affiliation'),
            'meeting_topic' => $this->input->post('meeting_topic'),
            'room_size' => $room_size,
            'start_date' => $start_date,
            'start_time' => $this->input->post('start_time'),
            'end_date' => $end_date,
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