<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		redirect('cms/dashboard');
	}

	function reset_password($hash)
	{
		$hashy = base64_decode($hash);
		$harr = explode(':', $hashy);
		$data['email'] =  $harr[0];
		$data['type'] =  substr($harr[1], 0, 5);
        
		$this->load->view('cms/reset_password', $data);
	}

	function change_password()
	{
		$new_pass = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$res = $this->db->update($this->input->post('type'), ['password' => $new_pass]);

	   if($res){
	      $this->session->set_flashdata('login_msg_lb', ['message' => 'Password was reset successfully', 'color' => 'green']);
	      redirect('cms/login');
	    } else {
	      $this->session->set_flashdata('login_msg_lb', ['message' => 'Failed updating password', 'color' => 'red']);
	      redirect('cms/login');
	    }
	}
}
