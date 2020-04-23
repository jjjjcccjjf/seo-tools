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

  function formatRes($data)
  {
    $res = [];
    foreach ($data as $key => $value) {
      if ($value->status == null && $value->verified_at == null) {
        $value->status = 'pending';
      } 

      $res[] = $value;
    }
    return $res;
  }
 
}
