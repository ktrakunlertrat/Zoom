<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // โหลด session
        $this->load->library('session');

        // ตรวจสอบ login
        if(!$this->session->userdata('logged_in')){

            redirect('login');

        }
    }

    public function index()
    {
        $this->load->database();

        // จำนวนต่อหน้า
        $limit = 10;

        // หน้าปัจจุบัน
        $page = $this->input->get('page');

        if(!$page || $page < 1){
            $page = 1;
        }

        // offset
        $offset = ($page - 1) * $limit;

        // keyword ค้นหา
        $keyword = $this->input->get('keyword');

        /*
        |--------------------------------------------------------------------------
        | Query สำหรับนับจำนวนทั้งหมด
        |--------------------------------------------------------------------------
        */

        if(!empty($keyword)){

            $this->db->group_start();
            $this->db->like('name', $keyword);
            $this->db->or_like('meeting_topic', $keyword);
            $this->db->group_end();

        }

        $total_rows = $this->db->count_all_results('reserve');

        // จำนวนหน้าทั้งหมด
        $total_pages = ceil($total_rows / $limit);

        /*
        |--------------------------------------------------------------------------
        | Query สำหรับดึงข้อมูล
        |--------------------------------------------------------------------------
        */

        if(!empty($keyword)){

            $this->db->group_start();
            $this->db->like('name', $keyword);
            $this->db->or_like('meeting_topic', $keyword);
            $this->db->group_end();

        }

        $data['reserve'] = $this->db
            ->order_by('id', 'DESC')
            ->limit($limit, $offset)
            ->get('reserve')
            ->result();

        // ส่งค่าไป view
        $data['current_page'] = $page;
        $data['total_pages'] = $total_pages;
        $data['keyword'] = $keyword;

        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('request', $data);
    }

    public function delete($id)
    {
        $this->load->database();

        // เช็คข้อมูลก่อน
        $reserve = $this->db
            ->where('id', $id)
            ->get('reserve')
            ->row();

        if(!$reserve){

            show_404();
        }

        // ลบข้อมูล
        $this->db->where('id', $id);

        $delete = $this->db->delete('reserve');

        if($delete){

            echo "
            <script>
                alert('ลบข้อมูลสำเร็จ');
                window.location.href='".base_url('index.php/request')."';
            </script>
            ";

        } else {

            echo "
            <script>
                alert('ลบข้อมูลไม่สำเร็จ');
                history.back();
            </script>
            ";
        }
    }
}