<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->database();

        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }
    }

	public function index()
    {
        // filter
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $where = "";

        if($start_date && $end_date){

            $where = "WHERE created_at BETWEEN '$start_date 00:00:00' 
                    AND '$end_date 23:59:59'";
        }

        /*
        |--------------------------------------------------------------------------
        | จำนวนการจองทั้งหมด
        |--------------------------------------------------------------------------
        */

        $totalQuery = $this->db->query("
            SELECT COUNT(*) as total_booking
            FROM reserve
            $where
        ");

        $data['total_booking'] = $totalQuery->row()->total_booking;

        /*
        |--------------------------------------------------------------------------
        | Bar Chart
        |--------------------------------------------------------------------------
        */

        $query = $this->db->query("
            SELECT zoom_number, COUNT(*) as total
            FROM reserve
            $where
            GROUP BY zoom_number
            ORDER BY zoom_number ASC
        ");

        $results = $query->result();

        $labels = [];
        $totals = [];

        for($i = 1; $i <= 11; $i++){

            $zoomName = 'Zoom '.$i;

            $labels[] = $zoomName;

            $found = 0;

            foreach($results as $row){

                if($row->zoom_number == $zoomName){

                    $found = $row->total;
                    break;
                }
            }

            $totals[] = $found;
        }

        /*
        |--------------------------------------------------------------------------
        | Pie Chart
        |--------------------------------------------------------------------------
        */

        $affQuery = $this->db->query("
            SELECT affiliation, COUNT(*) as total
            FROM reserve
            $where
            GROUP BY affiliation
        ");

        $affResults = $affQuery->result();

        $affLabels = [];
        $affTotals = [];

        foreach($affResults as $row){

            $affLabels[] = $row->affiliation;
            $affTotals[] = $row->total;
        }

        $data['labels'] = json_encode($labels);
        $data['totals'] = json_encode($totals);

        $data['affLabels'] = json_encode($affLabels);
        $data['affTotals'] = json_encode($affTotals);

        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('dashboard', $data);
    }
}