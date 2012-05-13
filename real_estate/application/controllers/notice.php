<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Notice extends CI_Controller {

    function __construct() {
        parent::__construct();
    }


/*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function index() {
    	$data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->view('noticePage',$data);
    }
}