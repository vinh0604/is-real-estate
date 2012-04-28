<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Category_Model extends CI_Model{

    function __construct() {
        parent::__construct();
    }
    
    /*
     * Author: Hiep
     * Summary: Get all of categories of RealEstate
     * Return: list of Categories
     */
    function GetCategories(){
        $query = "SELECT * FROM CATEGORY";
        $result = $this->db->query($query)->result();
        return $result;
    }
}
?>
