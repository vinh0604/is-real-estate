<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
     * Author: VinhBSD
     * Summary: display main page
     * Return:
     */
    function index() {
    	$data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->model('realEstate_Model');
		$this->load->model('city_Model');
		$data['realEstates'] = $this->realEstate_Model->GetNewRealEstates();
		$data['cities'] = $this->city_Model->GetCities();
		
		$this->load->view('mainPage',$data);
    }
	
	/*
     * Author: VinhBSD
     * Summary: get near real estates with specific location.
     * Return: 
     */
    function GetNear() {
    	$lat = $this->input->get('lat');
		$lng = $this->input->get('lng');
		$distance = $this->input->get('distance');
		
		$this->load->model('realEstate_Model');
		$realEstates = $this->realEstate_Model->GetNearRealEstates($lat, $lng, $distance);
		$this->output->set_output(json_encode($realEstates));
	}
	
	/*
     * Author: VinhBSD
     * Summary: get detail of specific real estates
     * Return: 
     */
    function GetDetail() {
		$realEstateId = $this->input->get('id');
		
		$this->load->model('realEstate_Model');
		$realEstate = $this->realEstate_Model->FindById($realEstateId);
		$this->output->set_output(json_encode($realEstate));
	}

	/*
     * Author: VinhBSD
     * Summary: get detail of specific real estates
     * Return: 
     */
    function GetDistrict() {
		$cityId = $this->input->get('id');
		
		$this->load->model('district_Model');
		$districts = $this->district_Model->GetDistrictsByCityID($cityId);
		$this->output->set_output(json_encode($districts));
	}
}

?>
