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
        | Auto Zoom Number
        |--------------------------------------------------------------------------
        */

        $zoom_number = '';

        /*
        |--------------------------------------------------------------------------
        | ห้อง 100 คน
        |--------------------------------------------------------------------------
        | มี Zoom 1 - Zoom 9
        */

        if($room_size == '100'){

            // zoom ที่มีทั้งหมด
            $all_zoom = [
                'Zoom 1',
                'Zoom 2',
                'Zoom 3',
                'Zoom 4',
                'Zoom 5',
                'Zoom 6',
                'Zoom 7',
                'Zoom 8',
                'Zoom 9'
            ];

            // ดึง zoom ที่ถูกใช้ไปแล้วในวันเดียวกัน
            $sql = "
                SELECT zoom_number
                FROM reserve
                WHERE room_size = '100'
                AND ? BETWEEN start_date AND end_date
            ";

            $query = $this->db->query($sql, [
                $start_date
            ]);

            $used_zoom = [];

            foreach($query->result() as $row){

                $used_zoom[] = $row->zoom_number;
            }

            // หา zoom ที่ยังว่าง
            $available_zoom = array_diff($all_zoom, $used_zoom);

            // ถ้าครบ 9 ห้องแล้ว
            if(empty($available_zoom)){

                echo "
                <script>
                    alert('วันนี้ห้อง Zoom ขนาด 100 คน ถูกใช้งานครบแล้ว');
                    window.history.back();
                </script>
                ";

                return;
            }

            // เอาห้องแรกที่ว่าง
            $zoom_number = array_values($available_zoom)[0];
        }

        /*
        |--------------------------------------------------------------------------
        | ห้อง 500 คน
        |--------------------------------------------------------------------------
        | มีได้แค่ Zoom 11
        */

        if($room_size == '500'){

            // เช็คว่ามี Zoom 11 วันนี้หรือยัง
            $sql = "
                SELECT *
                FROM reserve
                WHERE room_size = '500'
                AND zoom_number = 'Zoom 11'
                AND ? BETWEEN start_date AND end_date
            ";

            $check = $this->db->query($sql, [
                $start_date
            ]);

            if($check->num_rows() > 0){

                echo "
                <script>
                    alert('วันนี้ห้อง Zoom ขนาด 500 คน ถูกใช้งานแล้ว');
                    window.history.back();
                </script>
                ";

                return;
            }

            $zoom_number = 'Zoom 11';
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
            'zoom_number' => $zoom_number,
            'start_date' => $start_date,
            'start_time' => $this->input->post('start_time'),
            'end_date' => $end_date,
            'end_time' => $this->input->post('end_time'),
            'is_read' => 0
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