<?php

class Admin_model extends Admin_core_model
{

  function __construct()
  {
    parent::__construct();

    $this->table = 'admin'; # Replace these properties on children
    $this->upload_dir = 'uploads/admin/'; # Replace these properties on children
    $this->per_page = 15;
  }

  public function all()
  {
    $res = $this->db->get($this->table)->result();
    return $this->formatRes($res);
  }

  public function get($id)
  {
     $res = $this->db->get_where($this->table, array('id' => $id))->row();
     return $this->formatRes([$res]);
  }

  public function add($data)
  {
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    return $this->db->insert($this->table, $data);
  }

  public function update($id, $data)
  {
    if (!$data['password']) {
      unset($data['password']);
    } else {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }
    
    if ($this->session->id == $id && $_FILES['profile_pic']['size'] && $this->session->role == 'administrator') {
      $this->session->set_userdata('profile_pic', base_url().  $this->upload_dir . $data['profile_pic']);
    }
    
    $this->db->where('id', $id);
    return $this->db->update($this->table, $data);
  }

  function formatRes($res)
  {
    $data = [];

    foreach ($res as $key => $value) {
      $value->profile_pic = base_url() . $this->upload_dir . $value->profile_pic;
      $data[] = $value;
    }
    return $data;
  }
}
