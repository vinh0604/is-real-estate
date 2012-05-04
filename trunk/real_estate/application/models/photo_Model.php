<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Photo_Model extends CI_Model {

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

    function GetByRealEstateID($realEstateID) {
        $sQuery = 'SELECT * FROM photo 
        		   WHERE realestateid = ?';
		return $this->db->query($sQuery,array($realEstateID))->result_array();
    }

}

?>
