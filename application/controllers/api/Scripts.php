<?php

class Scripts extends \Restserver\Libraries\REST_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model('api/scripts_model');
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
		case 'fail':
		$this->response(['code' => 'fail', 'message' => 'Fail'], 200);
		break;
	}

  }

}
