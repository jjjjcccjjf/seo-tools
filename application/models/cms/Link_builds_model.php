<?php

class Link_builds_model extends Admin_core_model
{

  function __construct()
  {
    parent::__construct();

    $this->table = 'link_builds'; # Replace these properties on children
    $this->upload_dir = 'uploads/link_builds/'; # Replace these properties on children
    $this->page = $this->input->get('page') ?: 1;
    $this->per_page = $this->input->get('per_page') ? $this->input->get('per_page') : 100;

    $this->load->model('api/scripts_model');
  }

  public function getTotalPages2($user_id)
  {

    if ($user_id) {
      $this->db->where('user_id', $user_id);
    }
    if ($this->input->get('account_name')) {
      $this->db->where('account_name', $this->input->get('account_name'));
    }
    return ceil(count($this->db->get($this->table)->result()) / $this->per_page);
  }

  public function getUniqueAccountsPerUser($user_id)
  { 
    if ($user_id) {
        $this->db->where('user_id', $user_id);
    }
    $this->db->distinct();
    $this->db->select('account_name');
    return $this->db->get($this->table)->result();
  }

 public function paginate()
  {
    $offset = ($this->page - 1) * $this->per_page;
    $this->db->limit($this->per_page, $offset);
  }

  function allRes($user_id)
  {
    $this->paginate();
    if ($this->input->get('account_name')) {
      $this->db->where('link_builds.account_name', $this->input->get('account_name'));
    }
    if ($user_id) {
  	   $this->db->where('link_builds.user_id', $user_id);
    }
    $this->db->select('link_builds.id, link_builds.account_name, link_builds.webpage_link, link_builds.landing_page_link, link_builds.status, link_builds.keywords, link_builds.notes, link_builds.created_at, link_builds.verified_at, link_builds.updated_at, users.name as owner');
    $this->db->join('users', 'link_builds.user_id = users.id', 'left');
  	$res = $this->db->get('link_builds')->result();
    return $this->formatRes($res);
  }

  function allResCollection($user_id)
  {
    $this->db->where('user_id', $user_id);
    $res = $this->db->get('link_builds')->result();
    return $this->formatRes($res);
  }

  function allResApi($user_id)
  {
    $this->db->distinct('webpage_link');
    $this->db->select('webpage_link');
    $this->db->where('user_id', $user_id);
    $res = $this->db->get('link_builds')->result();
    return $res;
  }

  function getStatusCount($user_id)
  {
    $res = [];

    $this->db->where('user_id', $user_id);
    $this->db->where('status', 'success');
    $res['success'] = $this->db->count_all_results('link_builds');

    $this->db->where('user_id', $user_id);
    $this->db->where('status', 'failed');
    $res['failed'] = $this->db->count_all_results('link_builds');

    $this->db->where('user_id', $user_id);
    $this->db->where('(status IS NULL OR status = "")');
    $res['pending'] = $this->db->count_all_results('link_builds');

    return $res;
  }

  function getMonthsy($user_id = null)
  {
    if ($user_id) {
      $where_str = "user_id = $user_id";
    } else {
      $where_str = 1;
    }

    # account name filter    
    if ($this->input->get('account_name')) {
      $account_name = $this->input->get('account_name');
      $where_str2 = "account_name = '$account_name'";
    } else {
      $where_str2 = 1;
    }

    # date filter
    $from = $this->input->get('from') ?: '1970-01-01';
    $to = $this->input->get('to') ?: date('Y-m-d');
    $where_str3 = "(created_at > '$from' AND created_at < '$to')";
    // var_dump($where_str3); die();
    $data = $this->db->query("SELECT DISTINCT YEAR(created_at) AS year, MONTH(created_at) AS month FROM link_builds
      WHERE $where_str AND $where_str2 AND $where_str3
      ORDER BY year, month ASC
      ")->result();
    $res = [];
    foreach ($data as $value) {
      $m   = DateTime::createFromFormat('!m', $value->month);
      $res[] = $m->format('M') . " " . $value->year;
    }
    return $res;
  }

  function getSeries($user_id = null, $status)
  {
    if ($user_id) {
      $where_str = "user_id = $user_id";
    } else {
      $where_str = 1;
    }
    # account name filter    
    if ($this->input->get('account_name')) {
      $account_name = $this->input->get('account_name');
      $where_str2 = "account_name = '$account_name'";
    } else {
      $where_str2 = 1;
    }

    # date filter
    $from = $this->input->get('from') ?: '1970-01-01';
    $to = $this->input->get('to') ?: date('Y-m-d');
    $where_str3 = "(created_at > '$from' AND created_at < '$to')";

    if ($status) {
      $where_str4 = "status = '$status'";
    } else if ($status == '') {
      $where_str4 = "status IS NULL";
    } else {
      $where_str4 = "1";
    }
    

    $data = $this->db->query("SELECT DISTINCT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(id) as county FROM link_builds
      WHERE $where_str AND $where_str2 AND $where_str3 AND $where_str4
      GROUP BY year, month ASC
      -- ORDER BY year, month ASC
      ")->result();

    // var_dump($this->db->last_query()); 
    $res = [];
    foreach ($data as $value) {
      $res[] = $value->county;
    }
    return $res;

  }

  // -----

  function formatRes($data)
  {
    $res = [];
    foreach ($data as $key => $value) {
      $value->created_at_f = date('F j, Y', strtotime($value->created_at));
      if ($value->status == null && $value->verified_at == null) {
        $value->status = 'pending';
      } else if ($value->status == null) {
        $value->status = 'pending';
      }

      $res[] = $value;
    }
    return $res;
  }
 
}
