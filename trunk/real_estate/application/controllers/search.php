<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Search extends CI_Controller {

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
        $data['topBar'] = $this->load->view('topBar', $data, true);
        $this->load->model('city_Model');
        $data['cities'] = $this->city_Model->GetCities();
        $this->load->model('category_Model');
        $data['categories'] = $this->category_Model->GetCategories();
        $this->load->view('searchPage', $data);
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function BasicSearch() {
        $aParameter = array(
            "keyword" => $this->input->get("keyword"),
            "cityID" => $this->input->get("cityID"),
            "districtID" => $this->input->get("districtID"),
            "categoryID" => $this->input->get("categoryID"),
            "transaction" => $this->input->get("transaction"),
            "limit" => $this->input->get("limit"),
            "offset" => $this->input->get("offset")
        );
        $this->load->model('RealEstate_Model');
        $realEstates = $this->RealEstate_Model->FindByBasic($aParameter);
        $this->output->set_output(json_encode($realEstates));
    }

    function GetAllForMap() {
        $aParameter = array(
            "keyword" => $this->input->get("keyword"),
            "cityID" => $this->input->get("cityID"),
            "districtID" => $this->input->get("districtID"),
            "categoryID" => $this->input->get("categoryID"),
            "transaction" => $this->input->get("transaction"),
            "y" => $this->input->get("northEastlat"),
            "x" => $this->input->get("northEastlng"),
            "t" => $this->input->get("southWestlat"),
            "z" => $this->input->get("southWestlng"),
            "limit" => $this->input->get("limit"),
            "offset" => $this->input->get("offset")
        );
        $this->load->model('RealEstate_Model');
        $realEstates = $this->RealEstate_Model->GetAllForMap($aParameter);
        $this->output->set_output(json_encode($realEstates));
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function Advanced() {
        $this->load->helper('xml');
        $data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar', $data, true);
        $this->load->model('city_Model');
        $data['cities'] = $this->city_Model->GetCities();
        $this->load->model('category_Model');
        $data['categories'] = $this->category_Model->GetCategories();
        $this->load->model('RealEstate_Model');
        $data['street'] = $this->RealEstate_Model->GetStreet();
        $this->load->view('AdvancedSearchPage', $data);
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function AdvancedSearch() {

        $aParameter = array(
            "keyword" => $this->input->get("keyword"),
            "cityID" => $this->input->get("cityID"),
            "districtID" => $this->input->get("districtID"),
            "categoryID" => $this->input->get("categoryID"),
            "transaction" => $this->input->get("transaction"),
            "direction" => $this->input->get("direction"),
            "area" => $this->input->get("area"),
            "startPrice" => $this->input->get('startPrice'),
            "endPrice" => $this->input->get('endPrice'),
            "currency" => $this->input->get('currency'),
            "hospitalDis" => $this->input->get('hospitalDis'),
            "schoolDis" => $this->input->get('schoolDis'),
            "marketDis" => $this->input->get('marketDis'),
            "streetDis" => $this->input->get('streetDis'),
            "streetName" => $this->input->get('streetName'),
            "spatialQuery" => "1",
            "limit" => $this->input->get("limit"),
            "offset" => $this->input->get("offset")
        );
        $this->load->model('RealEstate_Model');
        $realEstates = $this->RealEstate_Model->FindByAdvanced($aParameter);
        $this->output->set_output(json_encode($realEstates));
    }

    function GetAllForMapAdvancedSearch() {
        $aParameter = array(
                        "y" => $this->input->get("northEastlat"),
            "x" => $this->input->get("northEastlng"),
            "t" => $this->input->get("southWestlat"),
            "z" => $this->input->get("southWestlng"),
            "keyword" => $this->input->get("keyword"),
            "cityID" => $this->input->get("cityID"),
            "districtID" => $this->input->get("districtID"),
            "categoryID" => $this->input->get("categoryID"),
            "transaction" => $this->input->get("transaction"),
            "direction" => $this->input->get("direction"),
            "area" => $this->input->get("area"),
            "startPrice" => $this->input->get('startPrice'),
            "endPrice" => $this->input->get('endPrice'),
            "currency" => $this->input->get('currency'),
            "hospitalDis" => $this->input->get('hospitalDis'),
            "schoolDis" => $this->input->get('schoolDis'),
            "marketDis" => $this->input->get('marketDis'),
            "streetDis" => $this->input->get('streetDis'),
            "streetName" => $this->input->get('streetName'),
            "spatialQuery" => "1",
            "limit" => $this->input->get("limit"),
            "offset" => $this->input->get("offset")
        );
        $this->load->model('RealEstate_Model');
        $realEstates = $this->RealEstate_Model->GetAllForAdvancedMap($aParameter);
        $this->output->set_output(json_encode($realEstates));
    }



}

?>
