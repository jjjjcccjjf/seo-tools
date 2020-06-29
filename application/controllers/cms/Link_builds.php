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
    $this->db->order_by('created_at', 'desc');
    $res = $this->link_builds_model->allRes($this->session->id);

    $data['status_count'] = $this->link_builds_model->getStatusCount($this->session->id);
    $data['res'] = $res;
    $data['total_pages'] = $this->link_builds_model->getTotalPages2($this->session->id);
    $data['accounts'] = $this->link_builds_model->getUniqueAccountsPerUser($this->session->id);
    $this->wrapper('cms/link_builds', $data);
  }
 
  public function update($id)
  {
    $last_page = $_POST['page']; 
    unset($_POST['page']);
    $page_str = "?page={$last_page}";

    $data = $this->input->post();
    $data['status'] = null;
    // var_dump( $id, $data); die();
    if($this->link_builds_model->update($id, $data)){
      $this->session->set_flashdata('flash_msg', ['message' => 'Item updated successfully', 'color' => 'green']);
    } else {
      $this->session->set_flashdata('flash_msg', ['message' => 'Error updating item', 'color' => 'red']);
    }
    redirect('cms/link_builds/' . $page_str);
  }
  public function add()
  {
    unset($_POST['page']);
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

  function recheck($user_id)
  {
    $this->link_builds_model->recheckLinks($user_id);
    $this->session->set_flashdata('flash_msg', ['message' => 'Links rechecked', 'color' => 'green']);
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

  function import_append($user_id)
  {
     $file = @$this->link_builds_model->upload('lb_upload_links_append')['lb_upload_links_append'];
     $row = 1;
     $records_added = 0;
     $records_rejected = 0;

      if (($handle = fopen("uploads/link_builds/{$file}", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          
          # skip first header
          if ($row == 1) {
            $row++;
            continue;
          }

          $this->db->where('webpage_link', $data[1]);
          $this->db->where('landing_page_link', $data[2]);
          $is_existing_already = $this->db->count_all_results('link_builds');
          
          if ($is_existing_already) {
            $records_rejected++;
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
          $records_added++;

        }
        fclose($handle);
      }

      $this->session->set_flashdata('flash_msg', ['message' => 'Import success', 'color' => 'green', 'records_added' => $records_added, 'records_rejected' => $records_rejected]);
      redirect('cms/link_builds');
  }


  function import_update($user_id)
  {
     $file = @$this->link_builds_model->upload('lb_upload_links_update')['lb_upload_links_update'];
      $row = 1;

      if (($handle = fopen("uploads/link_builds/{$file}", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          
          # skip first header
          if ($row == 1) {
            $row++;
            continue;
          }

          $this->db->where('id', $data[0]);
          $lb_row = $this->db->get('link_builds')->row();

          # skip if there was no change
          if (
            $lb_row->account_name == $data[1] &&
            $lb_row->webpage_link == $data[2] && 
            $lb_row->landing_page_link == $data[3] &&
            $lb_row->keywords == $data[4] &&
            $lb_row->strategies == $data[5] &&
            $lb_row->notes == $data[6]
          ) {
            continue;
          }

          # otherwise, mark row for rechecking
          $this->db->where('id', $data[0]);
          $this->db->update('link_builds', [
            'account_name' => $data[1],
            'webpage_link' => $data[2],
            'landing_page_link' => $data[3],
            'keywords' => $data[4],
            'strategies' => $data[5],
            'notes' => $data[6],
            'status' => null,
            'verified_at' => null
          ]);
        }
        fclose($handle);
      }
      $this->session->set_flashdata('flash_msg', ['message' => 'Update success', 'color' => 'green']);
      redirect('cms/link_builds');
  }

  function export($user_id)
  {
    $this->db->where('id', $user_id);
    $user = $this->db->get('users')->row(); 

    $this->db->where('user_id', $user_id);
    $res = $this->db->get('link_builds')->result(); 
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header("Content-Disposition: attachment; filename=" . time(). "_". $user->name . "_export" . ".csv");
    header('Last-Modified: ' . date('D M j G:i:s T Y'));
    $outss = fopen("php://output", "w");

    fputcsv($outss, ['id', 'account_name', 'webpage_link', 'landing_page_link', 'keywords', 'strategies', 'notes']);
    foreach ($res as $value) {
        fputcsv($outss, 
          [$value->id, $value->account_name, $value->webpage_link, $value->landing_page_link, $value->keywords, $value->strategies, $value->notes]
        );
    }
    fclose($outss);
    return;
  }

  function export_report($user_id)
  {
    $this->db->where('id', $user_id);
    $user = $this->db->get('users')->row(); 

    $this->db->where('user_id', $user_id);
    $res = $this->db->get('link_builds')->result(); 
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header("Content-Disposition: attachment; filename=" . time(). "_". $user->name . "_report" . ".csv");
    header('Last-Modified: ' . date('D M j G:i:s T Y'));
    $outss = fopen("php://output", "w");

    fputcsv($outss, ['id', 'name', 'account_name', 'webpage_link', 'landing_page_link', 'status', 'keywords', 'notes', 'verified_at', 'created_at', 'updated_at']);
    foreach ($res as $value) {
        fputcsv($outss, 
          [$value->id, $user->name, $value->account_name, $value->webpage_link, $value->landing_page_link, $value->status, $value->keywords, $value->notes, date('F j, Y', strtotime($value->verified_at)), date('F j, Y', strtotime($value->created_at)), date('F j, Y', strtotime($value->updated_at))]
        );
    }
    fclose($outss);
    return;
  }

  function export_report_all()
  {

    $this->db->select('link_builds.id, users.name, link_builds.account_name, link_builds.webpage_link, link_builds.landing_page_link, link_builds.status, link_builds.keywords, link_builds.notes, link_builds.verified_at, link_builds.created_at, link_builds.updated_at' );
    $this->db->join('users', 'users.id = link_builds.user_id', 'left');
    $res = $this->db->get('link_builds')->result(); 
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header("Content-Disposition: attachment; filename=" . time(). "_complete_report" . ".csv");
    header('Last-Modified: ' . date('D M j G:i:s T Y'));
    $outss = fopen("php://output", "w");

    fputcsv($outss, ['id', 'name', 'account_name', 'webpage_link', 'landing_page_link', 'keywords', 'status', 'notes', 'verified_at', 'created_at', 'updated_at']);
    foreach ($res as $value) {
        fputcsv($outss, 
          [$value->id, $value->name, $value->account_name, $value->webpage_link, $value->landing_page_link, $value->status, $value->keywords, $value->notes, date('F j, Y', strtotime($value->verified_at)), date('F j, Y', strtotime($value->created_at)), date('F j, Y', strtotime($value->updated_at))]
        );
    }
    fclose($outss);
    return;
  }
  
} # end class
