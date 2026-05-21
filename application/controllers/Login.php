<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			redirect('request');
		}
		
		$this->load->view('header');
		$this->load->view('login');
	}

	public function check_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // ตัวอย่าง username/password
        if($username == 'admin' && $password == 'admin@zoom')
{
			$session_data = array(
				'username' => $username,
				'logged_in' => TRUE
			);

			$this->session->set_userdata($session_data);

			redirect('welcome');
		}
        else
        {
            echo "
            <script>
                alert('Username หรือ Password ไม่ถูกต้อง');
                window.location.href='".base_url('index.php/login')."';
            </script>
            ";
        }
    }

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('welcome');
	}

	// public function clear_session()
	// {
	// 	$this->session->sess_destroy();

	// 	echo "Session Cleared";
	// }
}
