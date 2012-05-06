<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cart extends CI_Controller {

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
        
    }
	
	/*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
	
	function Add() {
		if($this->input->post('id')) {
			$realEstateId = $this->input->post('id');
			$this->load->model('realEstate_Model');
			if ($this->realEstate_Model->Exist($realEstateId)) {
				$cart = array();
				if (!$this->session->userdata('cart')) {
					$this->session->set_userdata('cart',$cart);
				}
				$cart = $this->session->userdata('cart');
				$result = array();
				if (!in_array($realEstateId, $cart)) {
					$cart[] = $realEstateId;
					$this->session->set_userdata('cart',$cart);
					$result['status'] = 'OK';
					$result['count'] = count($cart);
				} else {
					$result['status'] = 'EXISTED';
				}
				$this->output->set_output(json_encode($result));
				return true;
			}
		}
		$this->output->set_output('');
	}

}

?>
