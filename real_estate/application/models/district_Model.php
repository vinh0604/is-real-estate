<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class District_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * Author: Hiep
     * Summary: Get all of District By City
     * Parameter 1: ID of City
     * Parameter 2:
     * Return: list of district which is related to City
     */

    function GetDistrictsByCityID($cityID) {
        $query = "SELECT * FROM DISTRICT WHERE CITYID = ?";
        $result = $this->db->query($query, array($cityID))->result();
        return $result;
    }
	
	/*
     * Author: VinhBSD
     * Summary: Get name of district by id
	 * Parameter 1: ID of district
     * Return: Name of district
     */
	function GetNameByID($districtid) {
		$sQuery = 'SELECT name FROM district WHERE districtid = ?';
		$query = $this->db->query($sQuery,array($districtid));
		if ($query->num_rows() > 0) {
			return $query->row()->name;
		}
		return null;
	}
}

?>
