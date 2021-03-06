<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_core_controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('cms/admin_model', 'admin_model');
    $this->load->model('cms/link_builds_model');
    $this->load->model('cms/users_model');
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
    $this->db->where("(link_builds.created_at > '$from' AND link_builds.created_at < '$to' )");
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
    $data['total_pages'] = $this->link_builds_model->getTotalPages2($this->session->id);

    $data['filters'] = 'from=' . $this->input->get('from') . '&to=' . $this->input->get('to') . "&account_name=" . $this->input->get('account_name');
    $data['accounts'] = $this->link_builds_model->getUniqueAccountsPerUser($this->session->id);

   $this->wrapper('cms/link-builder-tool', $data); 
  }


  public function link_builder_tool_admin()
  {
    $_GET['to'] =  $this->input->get('to') ?: date('Y-m-d', strtotime($this->input->get('to') . "+1 day"));
    $user_id =  $this->input->get('user_id') ?: null;

    $this->db->order_by('created_at', 'desc');

    $this->filterHelper();
    $res = $this->link_builds_model->allRes($user_id); # $user_id to get all

    $data['months'] = $this->link_builds_model->getMonthsy($user_id);

    $data['success_arr'] = $this->link_builds_model->getSeries($user_id, 'success');
    $data['failed_arr'] = $this->link_builds_model->getSeries($user_id, 'failed');
    $data['partial_arr'] = $this->link_builds_model->getSeries($user_id, 'partial');
    $data['pending_arr'] = $this->link_builds_model->getSeries($user_id, '');

    // var_dump($data); die();

    $data['status_count'] = $this->link_builds_model->getStatusCount($user_id);
    $data['res'] = $res;

    $this->filterHelper();
    $data['total_pages'] = $this->link_builds_model->getTotalPages2($user_id);

    $data['filters'] = 'from=' . $this->input->get('from') . '&to=' . $this->input->get('to') . "&account_name=" . $this->input->get('account_name') . "&user_id=" . $this->input->get('user_id');
    $data['accounts'] = $this->link_builds_model->getUniqueAccountsPerUser($user_id);
    $data['users'] = $this->users_model->all();

   $this->wrapper('cms/link-builder-tool-admin', $data); 
  }

}
