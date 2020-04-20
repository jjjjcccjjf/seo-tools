<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Link_builds extends Admin_core_controller { # see application/core/MY_Controller.php
  function __construct()
  {
    parent::__construct();
    $this->load->model('cms/link_builds_model');
  }

  public function index()
  {
    $res = $this->link_builds_model->allRes($this->session->id);

    $data['res'] = $res;
    $this->wrapper('cms/link_builds', $data);
  }
 
  public function update($id)
  {
    $data = $this->input->post();

    if($this->link_builds_model->update($id, $data)){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item updated successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error updating item', 'color' => 'red']);
    }
    redirect('cms/link_builds');
  }
  public function add()
  {
    if($this->link_builds_model->add($this->input->post())){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item added successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error adding user. Email already exists.', 'color' => 'red']);
    }
    redirect('cms/link_builds');
  }
  public function delete($id)
  {
    if($this->link_builds_model->delete($this->input->post('id'))){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item deleted successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error deleting item', 'color' => 'red']);
    }
    redirect('cms/link_builds');
  }

  function import($user_id)
  {
      $file = @$this->link_builds_model->upload('lb_upload_links')['lb_upload_links'];
      $row = 1;

      $this->db->where('user_id', $user_id);
      $this->db->delete('link_builds');

      if (($handle = fopen("uploads/link_builds/{$file}", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          
          # skip first header
          if ($row == 1) {
            $row++;
            continue;
          }

          $this->db->insert('link_builds', [
            'account_name' => $data[0],
            'webpage_link' => $data[1],
            'landing_page_link' => $data[2],
            'keywords' => $data[3],
            'notes' => $data[4],
            'user_id' => $user_id
          ]);
        }
        fclose($handle);
      }

      $this->session->set_flashdata('flash_msg', ['message' => 'Import success', 'color' => 'green']);
      redirect('cms/link_builds');
  }
  
} # end class
