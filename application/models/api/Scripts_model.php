<?php

class Scripts_model extends CI_model
{
  
  function __construct()
  {
    parent::__construct();
     
  }


  function isValidUrl($url)
  {
  	if(!$url || !is_string($url) || ! preg_match('/^http(s)?:\/\/[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url)){
	    return false;
	} else {
		return true;
	}
  }

  function getPageObj($url)
  {
  	$c = curl_init($url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
	//curl_setopt(... other options you want...)
	$html = curl_exec($c);
	if (curl_error($c))
	    die(curl_error($c));

	// Get the status code
	$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);

	return (object)['status' => $status, 'html' => $html];
  }

  function auditHtml($html, $link_to_be_verified)
  {
  	$DOM = new DOMDocument();
	//load the html string into the DOMDocument
	@$DOM->loadHTML($html);
	//get a list of all <A> tags
	$a = $DOM->getElementsByTagName('a');

	$links = [];
	//loop through all <A> tags
	foreach($a as $link){
	    //echo out the href attribute of the <A> tag.
	    $links[] = $link->getAttribute('href');
	}

	return $this->delegateLink($links, $link_to_be_verified);
  }

  function delegateLink($links, $link_to_be_verified)
  {
  	if (in_array($link_to_be_verified, $links)) {
  		return 'success';
  	}

  	if (!in_array($link_to_be_verified, $links)) {
  		return 'fail';
  	}
  }


}
