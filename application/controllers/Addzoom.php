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

    private function thaiDateFormat($date)
    {
        if(empty($date)){
            return '';
        }

        $timestamp = strtotime($date);

        $day = date('d', $timestamp);
        $month = date('m', $timestamp);
        $year = date('Y', $timestamp) + 543;

        return $day.'/'.$month.'/'.$year;
    }

    private function convertThaiDate($date)
    {
        $explode = explode('/', $date);

        $day = $explode[0];
        $month = $explode[1];
        $year = $explode[2] - 543;

        return $year . '-' . $month . '-' . $day;
    }

    private function generateZoomNumber(
        $room_size,
        $start_date,
        $end_date,
        $exclude_id = null
    )
    {
        /*
        |--------------------------------------------------------------------------
        | ห้อง 100 คน
        |--------------------------------------------------------------------------
        */

        if($room_size == '100'){

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

            $sql = "
                SELECT zoom_number
                FROM reserve
                WHERE room_size = '100'
            ";

            $params = [];

            // ไม่เช็ค record ตัวเอง
            if($exclude_id){

                $sql .= " AND id != ?";
                $params[] = $exclude_id;
            }

            /*
            |--------------------------------------------------------------------------
            | เช็ควันชนกัน
            |--------------------------------------------------------------------------
            | NOT (
            |     end_date < start ใหม่
            |     OR
            |     start_date > end ใหม่
            | )
            */

            $sql .= "
                AND NOT (
                    end_date < ?
                    OR start_date > ?
                )
            ";

            $params[] = $start_date;
            $params[] = $end_date;

            $query = $this->db->query($sql, $params);

            $used_zoom = [];

            foreach($query->result() as $row){

                $used_zoom[] = $row->zoom_number;
            }

            $available_zoom = array_diff(
                $all_zoom,
                $used_zoom
            );

            if(empty($available_zoom)){

                return false;
            }

            return array_values($available_zoom)[0];
        }

        /*
        |--------------------------------------------------------------------------
        | ห้อง 500 คน
        |--------------------------------------------------------------------------
        */

        if($room_size == '500'){

            $sql = "
                SELECT id
                FROM reserve
                WHERE room_size = '500'
                AND zoom_number = 'Zoom 11'
            ";

            $params = [];

            if($exclude_id){

                $sql .= " AND id != ?";
                $params[] = $exclude_id;
            }

            $sql .= "
                AND NOT (
                    end_date < ?
                    OR start_date > ?
                )
            ";

            $params[] = $start_date;
            $params[] = $end_date;

            $query = $this->db->query($sql, $params);

            if($query->num_rows() > 0){

                return false;
            }

            return 'Zoom 11';
        }

        return false;
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

        // แปลงวันที่เป็น พ.ศ.
        $data['reserve']->start_date = $this->thaiDateFormat($data['reserve']->start_date);

        $data['reserve']->end_date = $this->thaiDateFormat($data['reserve']->end_date);

        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('addzoom', $data);
    }

    public function update($id)
    {
        $this->load->database();

        // รับค่าจาก form
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone_number = $this->input->post('phone_number');
        $affiliation = $this->input->post('affiliation');
        $meeting_topic = $this->input->post('meeting_topic');
        $room_size = $this->input->post('room_size');

        $start_date = $this->convertThaiDate(
            $this->input->post('start_date')
        );

        $start_time = $this->input->post('start_time');

        $end_date = $this->convertThaiDate(
            $this->input->post('end_date')
        );

        $end_time = $this->input->post('end_time');

        $details = $this->input->post('details');

        $zoom_number = $this->generateZoomNumber(
            $room_size,
            $start_date,
            $end_date,
            $id
        );

        if(!$zoom_number){

            echo "
            <script>
                alert('ไม่มีห้อง Zoom ว่างในช่วงวันดังกล่าว');
                history.back();
            </script>
            ";

            return;
        }

        // รวมข้อมูล
        $data = array(
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'affiliation' => $affiliation,
            'meeting_topic' => $meeting_topic,
            'room_size' => $room_size,
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_date' => $end_date,
            'end_time' => $end_time,
            'zoom_number' => $zoom_number,
            'details' => $details
        );

        // update
        $this->db->where('id', $id);

        $update = $this->db->update('reserve', $data);

        // เช็คสำเร็จ
        if($update){

            echo "
            <script>
                alert('บันทึกข้อมูลสำเร็จ');
                window.location.href='".base_url('index.php/request')."';
            </script>
            ";

        } else {

            echo "
            <script>
                alert('บันทึกข้อมูลไม่สำเร็จ');
                history.back();
            </script>
            ";
        }
    }
}