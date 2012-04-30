<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define("ACCEPT", 'Đã duyệt');

class RealEstate_Model extends CI_Model{

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
    function AddNewItem($newItem){
    
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function UpdateItem($item){
    
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function DeleteItem($realEstateID){
        
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function MoveToUncheck($realEstateID){
    
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function UpdateStatus($realEstateID,$status){
        
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function GetAllRealEstates(){
        
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function GetItemByCart($lstRealEstateID){
        
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function GetForMap(){
        
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function GetForList(){
        
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function GetAllForMap(){
        
    }
    
    /*
     * Author: VinhBSD
     * Summary: get newest accepted real estates 
     * Return: array of real estates object
     */
    function GetNewRealEstates(){
    	$sQuery = "SELECT realestateid,title,(SELECT url 
    										  FROM photo p 
    										  WHERE p.realestateid = r.realestateid 
    										  LIMIT 1) as url
    			   FROM realestate r
    			   WHERE r.status = ?
    			   ORDER BY datemodified DESC, date DESC
    			   LIMIT 10";
    	$result = $this->db->query($sQuery,array(ACCEPT))->result_array();
		
		return $result;
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function FindByAdvance(){
    
    }
    
    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function FindByBasic(){
    }
    
    /*
     * Author: VinhBSD
     * Summary: get detail of a real estate 
     * Parameter 1: id of real estate object
     * Return: real estate object if exists, null if not
     */
    function FindByID($realEstateID){
        $sQuery = 'SELECT r.*,c.name as category 
        		   FROM realestate r 
        		   JOIN category c ON r.categoryid = c.categoryid 
        		   WHERE status = ? AND realestateid = ?';
		$query = $this->db->query($sQuery,array(ACCEPT,$realEstateID));
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return null;
		}
    }
	
	/*
     * Author: VinhBSD
     * Summary: get near real estates of specific location within distance
     * Parameter 1: latitude
     * Parameter 2: longitude
	 * Parameter 3: distance
     * Return: array of real estates object
     */
    function GetNearRealEstates($lat, $lng, $distance){
    	$sQuery = 'SELECT realestateid, transaction, st_asgeojson(geom) as location
    			   FROM realestate 
    			   WHERE status = ?
    			   AND st_dwithin(st_transform(setsrid(st_makepoint(?,?),4326),900913),st_transform(geom,900913),?)=true';
		$result = $this->db->query($sQuery,array(ACCEPT,$lng,$lat,$distance))->result_array();
		
		return $result;
    }
}
?>
