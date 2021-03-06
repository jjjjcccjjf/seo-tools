<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Admin_core_controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('cms/login_model', 'login');
    $this->load->model('cms/login_users_model', 'login_lb');
  }

  public function index()
  {
    $this->login();
  }

  public function login()
  {
    $this->load->view('cms/login');
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('cms/login');
    die();
  }

  public function attempt() # attempt to login
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $res = $this->login->getByEmail($email);
    if($res && password_verify($password, $res->password)){
      $this->session->set_userdata(['role' => 'administrator', 'id' => $res->id, 'name' => $res->name, 'profile_pic' => base_url(). 'uploads/admin/' . $res->profile_pic]);
      redirect('cms/dashboard');
    } else {
      $this->session->set_flashdata('login_msg', ['message' => 'Incorrect email or password', 'color' => 'red']);
      redirect('cms/login');
    }

  }

  public function attempt_lb() # attempt to login
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $res = $this->login_lb->getByEmail($email);

    if($res && password_verify($password, $res->password)){
      $this->session->set_userdata(['role' => 'link_builder', 'id' => $res->id, 'name' => $res->name, 'profile_pic' => base_url(). 'uploads/users/' . $res->profile_pic]);
      redirect('cms/link_builds');
    } else {
      $this->session->set_flashdata('login_msg_lb', ['message' => 'Incorrect email or password', 'color' => 'red']);
      redirect('cms/login');
    }

  }

  public function forgot_password() 
  {
    $email = $this->input->post('email');
    $type = $this->input->post('type');
    $res = $this->login->forgotPassword($email, $type);

    if($res){
      $this->session->set_flashdata('login_msg_lb', ['message' => 'Password reset link was sent to ' . $email, 'color' => 'green']);
      redirect('cms/login');
    } else {
      $this->session->set_flashdata('login_msg_lb', ['message' => 'Sorry, ' . $this->input->post('email') . ' doesn\'t exist in ' . $this->input->post('type'), 'color' => 'red']);
      redirect('cms/login');
    }

  }


}
