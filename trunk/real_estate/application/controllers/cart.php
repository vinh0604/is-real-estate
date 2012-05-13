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
	
	/*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
	
	function DeleteItem() {
		if ($this->session->userdata('cart') && $this->input->post('a_id')) {
			$cart = $this->session->userdata('cart');
			$realEstateIds = $this->input->post('a_id');
			foreach($realEstateIds as $realEstateId) {
				$key = array_search($realEstateId, $cart);
				if($key!==FALSE) {
					unset($cart[$key]);
				}
			}
			$this->session->set_userdata('cart',$cart);
			$this->session->set_flashdata('notice','Thao tác xóa tin khỏi giỏ thực hiện thành công!');
		}
		redirect(base_url('index.php/cart/'));
	}
	
	/*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
	
	function Compare($realEstateIdA, $realEstateIdB) {
		$data['userdata'] = $this->session->userdata;
		
		$this->load->model('realEstate_Model');
		$data['realEstateA'] = $this->realEstate_Model->FindByID($realEstateIdA);
		$data['realEstateB'] = $this->realEstate_Model->FindByID($realEstateIdB);
		if ($data['realEstateA'] && $data['realEstateB']) {
			$this->load->helper('utils');
			$this->load->view('comparePage',$data);
		} else {
			show_error('Không tìm thấy tin bất động sản yêu cầu!');
		}
	}

}

?>
