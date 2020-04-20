<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends Admin_core_controller { # see application/core/MY_Controller.php
  function __construct()
  {
    parent::__construct();
    $this->load->model('cms/users_model');
  }

  public function index()
  {
    $res = $this->users_model->all();

    $data['res'] = $res;
    $this->wrapper('cms/users', $data);
  }
 
  public function update($id)
  {
    $data = array_merge($this->input->post(), $this->users_model->upload('profile_pic'));

    if($this->users_model->update($id, $data)){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item updated successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error updating item', 'color' => 'red']);
    }
    redirect('cms/users');
  }
  public function add()
  {
    $data = array_merge($this->input->post(), $this->users_model->upload('profile_pic'));

    if($this->users_model->add($this->input->post())){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item added successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error adding user. Email already exists.', 'color' => 'red']);
    }
    redirect('cms/users');
  }
  public function delete($id)
  {
    if($this->users_model->delete($this->input->post('id'))){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item deleted successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error deleting item', 'color' => 'red']);
    }
    redirect('cms/users');
  }
  
} # end class
