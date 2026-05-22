<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Sendemail extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        require FCPATH . 'vendor/autoload.php';

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
        $this->load->view('sendemail', $data);
    }

    public function send_email($id)
    {
        $this->load->database();

        $reserve = $this->db
            ->where('id', $id)
            ->get('reserve')
            ->row();

        if (!$reserve) {
            show_404();
        }

        $email   = $this->input->post('email');
        $subject = $this->input->post('subject');
        $details = $this->input->post('details');

        $files = $_FILES['attachments'];

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'deqpzoom2@gmail.com';

            // App Password 16 หลัก
            $mail->Password = 'mqnn frtn isci onbd';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';

            // ผู้ส่ง
            $mail->setFrom(
                'deqpzoom2@gmail.com',
                'Zoom Meeting'
            );

            // ผู้รับ
            $mail->addAddress($email);

            $mail->isHTML(true);

            $mail->Subject = $subject;

            $mail->Body = $details;

            // แนบไฟล์ (multiple)
            if (!empty($_FILES['attachments']['name'][0])) {

                $count = count($_FILES['attachments']['name']);

                for ($i = 0; $i < $count; $i++) {

                    $_FILES['file']['name']     = $files['name'][$i];
                    $_FILES['file']['type']     = $files['type'][$i];
                    $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['file']['error']    = $files['error'][$i];
                    $_FILES['file']['size']     = $files['size'][$i];

                    $mail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
                }
            }

            $mail->send();

            $this->session->set_flashdata(
                'success',
                'ส่งอีเมล์สำเร็จ'
            );

        } catch (Exception $e) {

            echo $mail->ErrorInfo;
            exit;
        }

        echo "
        <script>
            alert('ส่งอีเมล์แล้ว');
            window.location.href='".base_url('index.php/request')."';
        </script>
        ";
    }
}