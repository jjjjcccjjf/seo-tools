<?php

class Link_builds_model extends Admin_core_model
{

  function __construct()
  {
    parent::__construct();

    $this->table = 'link_builds'; # Replace these properties on children
    $this->upload_dir = 'uploads/link_builds/'; # Replace these properties on children
    $this->per_page = 15;

    $this->load->model('api/scripts_model');
  }


  function allRes($user_id)
  {
  	$this->db->where('user_id', $user_id);
  	$res = $this->db->get('link_builds')->result();
    return $this->formatRes($res);
  }

  function  getStatusCount($user_id)
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

  function formatRes($data)
  {
    $res = [];
    foreach ($data as $key => $value) {
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
