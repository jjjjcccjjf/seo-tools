<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends Admin_core_controller { # see application/core/MY_Controller.php
  function __construct()
  {
    parent::__construct();
    $this->load->model('cms/admin_model','admin_model');
  }
 
  public function update($id)
  {
    if($this->admin_model->update($id, $this->input->post())){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item updated successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error updating item', 'color' => 'red']);
    }
    redirect('cms/dashboard');
  }
  public function add()
  {
    if($this->admin_model->add($this->input->post())){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item added successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error adding user. Email already exists.', 'color' => 'red']);
    }
    redirect('cms/dashboard');
  }
  public function delete($id)
  {
    if($this->admin_model->delete($this->input->post('id'))){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item deleted successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error deleting item', 'color' => 'red']);
    }
    redirect('cms/dashboard');
  }
  
} # end class
