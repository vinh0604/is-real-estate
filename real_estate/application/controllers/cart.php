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
        $data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->model('realEstate_Model');
		if ($this->session->userdata('cart')) {
			$data['realEstates'] = $this->realEstate_Model->GetItemByCart($this->session->userdata('cart'));
		} else {
			$data['realEstates'] = array();
		}
		$this->load->view('cartPage',$data);
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
