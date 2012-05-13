<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Logout extends CI_Controller {

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
    	$this->session->unset_userdata('user_id');
        $this->session->unset_userdata('is_admin');
        $this->session->unset_userdata('cart');
        
        redirect(base_url());
    }
}

