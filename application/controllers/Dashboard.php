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
        // รับค่า filter
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        /*
        |--------------------------------------------------------------------------
        | BAR CHART
        |--------------------------------------------------------------------------
        */

        $this->db->select('zoom_number, COUNT(*) as total');
        $this->db->from('reserve');

        // filter created_at
        if(!empty($start_date)){
            $this->db->where('DATE(created_at) >=', $start_date);
        }

        if(!empty($end_date)){
            $this->db->where('DATE(created_at) <=', $end_date);
        }

        $this->db->group_by('zoom_number');
        $this->db->order_by('zoom_number', 'ASC');

        $results = $this->db->get()->result();

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
        | PIE CHART
        |--------------------------------------------------------------------------
        */

        $affiliations = [
            'สลก.',
            'กปอ.',
            'กลก.',
            'กยป.',
            'กสร.',
            'ศปส.',
            'กจธ.',
            'กพร.',
            'ตส.',
            'กกม.'
        ];

        $this->db->select('affiliation, COUNT(*) as total');
        $this->db->from('reserve');

        // filter created_at
        if(!empty($start_date)){
            $this->db->where('DATE(created_at) >=', $start_date);
        }

        if(!empty($end_date)){
            $this->db->where('DATE(created_at) <=', $end_date);
        }

        $this->db->group_by('affiliation');

        $affResults = $this->db->get()->result();

        $affLabels = [];
        $affTotals = [];

        foreach($affiliations as $aff){

            $affLabels[] = $aff;

            $found = 0;

            foreach($affResults as $row){

                if($row->affiliation == $aff){

                    $found = $row->total;
                    break;
                }
            }

            $affTotals[] = $found;
        }

        /*
        |--------------------------------------------------------------------------
        | SEND DATA
        |--------------------------------------------------------------------------
        */

        $data['labels'] = json_encode($labels);
        $data['totals'] = json_encode($totals);

        $data['affLabels'] = json_encode($affLabels);
        $data['affTotals'] = json_encode($affTotals);

        $this->load->view('header');
        $this->load->view('navbar');
        $this->load->view('dashboard', $data);
    }
}