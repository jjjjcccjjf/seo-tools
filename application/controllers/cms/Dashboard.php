<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_core_controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('cms/admin_model', 'admin_model');
    $this->load->model('cms/link_builds_model');
  }

  public function index()
  {
    $this->dashboard();
  }

  public function dashboard()
  {
    $res = $this->admin_model->all();

    $data['res'] = $res;
    $this->wrapper('cms/index', $data);
  }

  function filterHelper()
  {
    # Filters
    $from = $this->input->get('from') ?: '1970-01-01';
    $to = $this->input->get('to') ?: date('Y-m-d');
    if ($this->input->get('account_name')) {
      $this->db->where('account_name', $this->input->get('account_name'));
    }
    $this->db->where("(created_at > '$from' AND created_at < '$to' )");
    # / Filters
  }

  public function link_builder_tool()
  {
    $_GET['to'] =  $this->input->get('to') ?: date('Y-m-d', strtotime($this->input->get('to') . "+1 day"));

    $this->db->order_by('created_at', 'desc');

    $this->filterHelper();
    $res = $this->link_builds_model->allRes($this->session->id);

    $data['months'] = $this->link_builds_model->getMonthsy($this->session->id);

    $data['success_arr'] = $this->link_builds_model->getSeries($this->session->id, 'success');
    $data['failed_arr'] = $this->link_builds_model->getSeries($this->session->id, 'failed');
    $data['pending_arr'] = $this->link_builds_model->getSeries($this->session->id, '');

    // var_dump($data); die();

    $data['status_count'] = $this->link_builds_model->getStatusCount($this->session->id);
    $data['res'] = $res;

    $this->filterHelper();
    $data['total_pages'] = $this->link_builds_model->getTotalPages();

    $data['filters'] = 'from=' . $this->input->get('from') . '&to=' . $this->input->get('to') . "&account_name=" . $this->input->get('account_name');
    $data['accounts'] = $this->link_builds_model->getUniqueAccountsPerUser($this->session->id);

   $this->wrapper('cms/link-builder-tool', $data); 
  }
}
