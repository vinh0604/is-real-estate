<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class City_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    /*
     * Author: Hiep
     * Summary: Get all of cities
     * Return: list of Cities
     */
    function GetCities() {
        $query = "SELECT * FROM CITY";
        $result = $this->db->query($query)->result();
        return $result;
    }
	
	/*
     * Author: VinhBSD
     * Summary: Get name of city by id
     * Return: Name of city
     */
	function GetNameByID($cityid) {
		$sQuery = 'SELECT name FROM city WHERE cityid = ?';
		$query = $this->db->query($sQuery,array($cityid));
		if ($query->num_rows() > 0) {
			return $query->row()->name;
		}
		return null;
	}
}

?>
