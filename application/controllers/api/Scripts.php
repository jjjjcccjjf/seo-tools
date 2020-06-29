<?php

class Scripts extends \Restserver\Libraries\REST_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('api/scripts_model');
    $this->load->model('cms/link_builds_model');
  }

  function verify_post()
  {
  	$url = $this->input->post('url');

  	# make sure URL is valid, syntax-wise
  	$is_valid_url = $this->scripts_model->isValidUrl($url);
  	if (!$is_valid_url) {
  		$this->response(['code' => 'invalid_url', 'message' => 'Invalid url'], 200);
  	}

  	# get page object (status code, html contents)
  	$page_obj = $this->scripts_model->getPageObj($url);
  	# make sure status code is 200 OK, otherwise, print error
  	if ($page_obj->status != 200) {
  		$this->response(['code' => 'page_error', 'message' => 'Something went wrong on the client\'s end'], 400);
  	}

  	$result = $this->scripts_model->auditHtml($page_obj->html, $this->input->post('link_to_be_verified'));

  	switch ($result) {
  		case 'success':
  		$this->response(['code' => 'success', 'message' => 'Success'], 200);
  		break;
  		
  		default:
  		case 'failed':
  		$this->response(['code' => 'fail', 'message' => 'Fail'], 200);
  		break;
  	}

  }

  function check_user_links_post($user_id, $options = '')
  {
  	if ($options == 'unchecked_only') {
  		$this->db->where('status', null);
  	  $links = $this->link_builds_model->allResApi($user_id);
      
      $this->db->where('status', null);
      $collection = $this->link_builds_model->allResCollection($user_id);
      // $this->db->where('(status IS NULL OR status = "") AND verified_at is NULL');

  	} else if ($options == 'failed_only'){
      $this->db->where('status', 'failed');
      $links = $this->link_builds_model->allResApi($user_id);

      $this->db->where('status', 'failed');
      $collection = $this->link_builds_model->allResCollection($user_id);

  	} else {
      $links = $this->link_builds_model->allResApi($user_id);
      $collection = $this->link_builds_model->allResCollection($user_id);
    }

    $pages_arr = []; 

    foreach ($links as $key => $value) {
      $pages_arr[$value->webpage_link] = $this->scripts_model->getPageObj($value->webpage_link)->html; 
  	}

    foreach ($collection as $key => $value) {
      $auditRes = $this->scripts_model->auditHtml($pages_arr[$value->webpage_link], $value->landing_page_link);
      $this->db->where('id', $value->id);
      $this->db->update('link_builds', ['status' => $auditRes, 'verified_at' => date('Y-m-d H:i:s')]);
    }

    $this->session->set_flashdata('flash_msg', ['message' => 'Links rechecked', 'color' => 'green']);
    $this->response(['code' => 'success', 'message' => 'Success'], 200);
  }

}
