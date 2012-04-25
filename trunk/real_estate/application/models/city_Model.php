<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class City_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get all city
    //return list of city
    function GetCities() {
        $query = "SELECT * FROM CITY";
        $result = $this->db->query($query)->result();
        return $result;
    }

}

?>
