<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define("ACCEPT", 'Đã duyệt');
define("ADDNEW", 'Chưa duyệt');
define("DENIED", 'Từ chối');

class RealEstate_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * Author: VinhBSD
     * Summary: add new real estate 
     * Parameter 1: real estate object
     * Parameter 2: latitude of real estate
     * Parameter 3: longitude of real estate
     * Return: id of new real estate
     */

    function AddNewItem($realEstate, $lat, $lng) {
        $realEstate['status'] = ADDNEW;
        $this->db->set($realEstate);
        $lat = floatval($lat);
        $lng = floatval($lng);
        if ($lat && $lng) {
            $this->db->set('geom', "setsrid(st_makepoint($lng,$lat),4326)", false);
        }
        $this->db->set('date', "now()", false);
        $this->db->insert('realestate');
        return $this->db->insert_id();
    }

    /*
     * Author: VinhBSD
     * Summary: update exist real estate
     * Parameter 1: id of real estate 
     * Parameter 2: real estate object
     * Parameter 3: latitude of real estate
     * Parameter 4: longitude of real estate
     * Return: num of rows updated
     */

    function UpdateItem($realEstateId, $realEstate, $lat, $lng) {
        $realEstate['status'] = ADDNEW;
        $this->db->where('realestateid', $realEstateId);
        if (!$this->session->userdata('is_admin')) {
            $this->db->where('userid', $this->session->userdata('user_id'));
        }
        $lat = floatval($lat);
        $lng = floatval($lng);
        if ($lat && $lng) {
            $this->db->set('geom', "setsrid(st_makepoint($lng,$lat),4326)", false);
        }
        $this->db->set('datemodified', "now()", false);
        $this->db->update('realestate', $realEstate);
        return $this->db->affected_rows();
    }

    /*
     * Author: VinhBSD
     * Summary: delete real estates
     * Parameter 1: array of real estate IDs 
     * Return:
     */

    function DeleteItem($aRealEstateIDs) {
        if (!$this->session->userdata('is_admin')) {
            $this->db->where('userid', $this->session->userdata('user_id'));
        }
        $this->db->where_in('realestateid', $aRealEstateIDs);
        $this->db->delete(array('photo', 'realestate'));
        $affectedRows = $this->db->affected_rows();
        if ($affectedRows) {
            foreach ($aRealEstateIDs as $id) {
                $dir = FCPATH . 'images/files/' . $id . '/';
                if (is_dir($dir)) {
                    foreach (glob($dir . '*.*') as $v) {
                        unlink($v);
                    }
                    rmdir($dir);
                }
                $dir = FCPATH . 'images/thumbnails/' . $id . '/';
                if (is_dir($dir)) {
                    foreach (glob($dir . '*.*') as $v) {
                        unlink($v);
                    }
                    rmdir($dir);
                }
            }
        }
        return $affectedRows;
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function MoveToUncheck($realEstateID) {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function UpdateStatus($realEstateIDs, $isAccepted) {
        $this->db->where_in('realestateid', $realEstateIDs);
        if ($isAccepted) {
            $this->db->update('realestate', array('status' => ACCEPT));
        } else {
            $this->db->update('realestate', array('status' => DENIED));
        }

        return $this->db->affected_rows();
    }

    /*
     * Author: VinhBSD
     * Summary: get of real estates
     * Return: array of real estate objects
     */

    function GetAllRealEstates() {
        $sQuery = 'SELECT realestateid, title, date, transaction, c.name as category, status, u.username, u.userid
        		   FROM realestate r 
        		   JOIN "user" u ON u.userid = r.userid
        		   LEFT JOIN category c ON r.categoryid = c.categoryid 
        		   LIMIT ? OFFSET ?';
        $result = $this->db->query($sQuery, array(10, 0))->result_array();

        return $result;
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetItemByCart($aRealEstateIds) {
        $this->db->select('realestateid, title, date, transaction, c.name as category, u.name as user');
        $this->db->from('realestate r');
        $this->db->join('user u', 'u.userid = r.userid');
        $this->db->join('category c', 'c.categoryid = r.categoryid', 'left');
        $this->db->where_in('realestateid', $aRealEstateIds);

        return $this->db->get()->result_array();
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetForMap() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetForList() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetAllForMap($aParameter) {
        $this->load->library('querybuilder');
        $query = $this->querybuilder->BuildQueryStatementForSeachWithGeom($aParameter);
        $query2 = $this->querybuilder->GenerateQueryStatementForSearch($query, $aParameter['limit'], $aParameter['offset']);
        $result = $this->db->query($query);
        $result2 = $this->db->query($query2);
        $aResult["items"] = $result2->result_array();
        $aResult["count"] = $result->num_rows();
        return $aResult;
    }
    
    function GetStreet(){
        $query = "select distinct(ten_dgt) as ten_dgt from dgt where ten_dgt is not NULL";
        $result = $this->db->query($query);
        return $result->result();
    }

    /*
     * Author: VinhBSD
     * Summary: get newest accepted real estates 
     * Return: array of real estates object
     */

    function GetNewRealEstates() {
        $sQuery = "SELECT realestateid,title,(SELECT url 
    										  FROM photo p 
    										  WHERE p.realestateid = r.realestateid 
    										  LIMIT 1) as url
    			   FROM realestate r
    			   WHERE r.status = ?
    			   ORDER BY datemodified DESC, date DESC
    			   LIMIT 10";
        $result = $this->db->query($sQuery, array(ACCEPT))->result_array();

        return $result;
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function FindByAdvanced($aParameter) {
        $this->load->library('querybuilder');
        $query = $this->querybuilder->BuildQueryStatementForAdvancedSearch($aParameter);
        $query2 = $this->querybuilder->GenerateQueryStatementForSearch($query, $aParameter['limit'], $aParameter['offset']);
        $result = $this->db->query($query);
        $result2 = $this->db->query($query2);
        $aResult["items"] = $result2->result_array();
        $aResult["count"] = $result->num_rows();
        return $aResult;
    }
    
    
    function GetAllForAdvancedMap($aParameter) {
        $this->load->library('querybuilder');
        $query = $this->querybuilder->BuildQueryStatementForAdvancedSeachWithGeom($aParameter);
        $query2 = $this->querybuilder->GenerateQueryStatementForSearch($query, $aParameter['limit'], $aParameter['offset']);
        $result = $this->db->query($query);
        $result2 = $this->db->query($query2);
        $aResult["items"] = $result2->result_array();
        $aResult["count"] = $result->num_rows();
        return $aResult;
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function FindByBasic($aParameter) {
        $this->load->library('querybuilder');
        $query = $this->querybuilder->BuildQueryStatementForSearch($aParameter);
        $query2 = $this->querybuilder->GenerateQueryStatementForSearch($query, $aParameter['limit'], $aParameter['offset']);
        $result = $this->db->query($query);
        $result2 = $this->db->query($query2);
        $aResult["items"] = $result2->result_array();
        $aResult["count"] = $result->num_rows();
        return $aResult;
    }

    /*
     * Author: VinhBSD
     * Summary: get detail of a real estate 
     * Parameter 1: id of real estate object
     * Return: real estate object if exists, null if not
     */

    function FindByID($realEstateID) {
        $sQuery = 'SELECT r.*,c.name as category, st_asgeojson(geom) as location 
        		   FROM realestate r 
        		   JOIN "user" u ON u.userid = r.userid
        		   LEFT JOIN category c ON r.categoryid = c.categoryid 
        		   WHERE status = ? AND realestateid = ?';
        $query = $this->db->query($sQuery, array(ACCEPT, $realEstateID));

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

    function GetNearRealEstates($lat, $lng, $distance) {
        $sQuery = 'SELECT realestateid, transaction, st_asgeojson(geom) as location
    			   FROM realestate 
    			   WHERE status = ?
    			   AND st_dwithin(st_transform(setsrid(st_makepoint(?,?),4326),900913),st_transform(geom,900913),?)=true';
        $result = $this->db->query($sQuery, array(ACCEPT, $lng, $lat, $distance))->result_array();

        return $result;
    }

    /*
     * Author: VinhBSD
     * Summary: Get all real estates of specific user
     * Parameter 1: user id
     * Return: array of real estate objects
     */

    function GetAllRealEstatesByUser($userId) {
        $sQuery = 'SELECT realestateid, title, date, transaction, c.name as category, status, u.username, u.userid
        		   FROM realestate r 
        		   JOIN "user" u ON u.userid = r.userid
        		   LEFT JOIN category c ON r.categoryid = c.categoryid 
        		   WHERE r.userid = ?
        		   LIMIT ? OFFSET ?';
        $result = $this->db->query($sQuery, array($userId, 10, 0))->result_array();

        return $result;
    }

    function GetRealEstateForDataTable($sFilter, $iSort, $sSortDir, $iLimit, $iOffset) {
        $aColumns = array(1 => 'title',
            2 => 'u.username',
            3 => 'date',
            4 => 'transaction',
            5 => 'category',
            6 => 'status');
        $aParams = array();
        $aResult = array();
        $sSelect = 'SELECT realestateid, title, date, transaction, c.name as category, status, u.username, u.userid ';
        $sQuery = 'FROM realestate r 
        		   JOIN "user" u ON u.userid = r.userid
        		   LEFT JOIN category c ON r.categoryid = c.categoryid 
        		   WHERE 1=1 ';
        if ($sFilter) {
            $sQuery .= 'AND (title LIKE ? OR transaction LIKE ? OR c.name LIKE ? OR u.username LIKE ? OR status LIKE ?) ';
            for ($i = 0; $i < 5; ++$i) {
                $aParams[] = '%' . $sFilter . '%';
            }
        }
        if (!$this->session->userdata('is_admin')) {
            $sQuery .= 'AND r.userid = ? ';
            $aParams[] = $this->session->userdata('user_id');
        }
        $query = $this->db->query("SELECT count(*) as count " . $sQuery, $aParams);
        $aResult['iTotalDisplayRecords'] = $query->row()->count;
        ;

        if (array_key_exists($iSort, $aColumns)) {
            $sSortDir = addslashes($sSortDir);
            $sQuery .= "ORDER BY $aColumns[$iSort] $sSortDir ";
        }
        if ($iLimit) {
            $sQuery .= 'LIMIT ? ';
            $aParams[] = $iLimit;
        }
        if ($iOffset) {
            $sQuery .= 'OFFSET ?';
            $aParams[] = $iOffset;
        }
        $query = $this->db->query($sSelect . $sQuery, $aParams);
        $aResult['aaData'] = $query->result_array();

        $aCountParams = array();
        $sQuery = 'SELECT count(*) as count FROM realestate r';
        if (!$this->session->userdata('is_admin')) {
            $sQuery .= ' WHERE r.userid = ? ';
            $aCountParams[] = $this->session->userdata('user_id');            
        }
        $aResult['iTotalRecords'] = $this->db->query($sQuery, $aCountParams)->row()->count;

        
        return $aResult;
    }

    /*
     * Author: VinhBSD
     * Summary: get detail of a real estate for editing
     * Parameter 1: id of real estate object
     * Return: real estate object if exists, null if not
     */

    function FindByIDForEdit($realEstateID) {
        $sQuery = 'SELECT r.*,st_astext(r.geom) as position, c.name as category, d.cityid, st_asgeojson(geom) as location 
        		   FROM realestate r 
        		   LEFT JOIN category c ON r.categoryid = c.categoryid 
        		   LEFT JOIN district d ON r.districtid = d.districtid
        		   WHERE realestateid = ?';
        if (!$this->session->userdata('is_admin')) {
            $sQuery .= ' AND userid = ?';
            $query = $this->db->query($sQuery, array($realEstateID, $this->session->userdata('user_id')));
        } else {
            $query = $this->db->query($sQuery, array($realEstateID));
        }

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    /*
     * Author: VinhBSD
     * Summary: get accepted real estates for listing
     * Return: array of real estates object
     */

    function GetRealEstatesForListing($categoryId, $transaction, $limit, $offset) {
        $sQuery = 'SELECT realestateid,title,address,transaction,size,area,price,currency,unit,
    					  (SELECT url 
						   FROM photo p 
						   WHERE p.realestateid = r.realestateid 
						   LIMIT 1) as url,
						  c.name as category
    			   FROM realestate r
    			   LEFT JOIN category c ON r.categoryid = c.categoryid
    			   WHERE r.status = ?';
        $aParams = array(ACCEPT);
        if ($categoryId) {
            $sQuery .= ' AND r.categoryid = ?';
            $aParams[] = $categoryId;
        }
        if ($transaction) {
            $sQuery .= ' AND transaction = ?';
            $aParams[] = $transaction;
        }
        $sQuery .= 'LIMIT ? OFFSET ?';
        $aParams[] = $limit;
        $aParams[] = $offset;

        $result = $this->db->query($sQuery, $aParams)->result_array();
        return $result;
    }

    /*
     * Author: VinhBSD
     * Summary: count all real estates for pagination in listing
     * Return: num of real estates
     */

    function CountAllRealEstates($categoryId, $transaction) {
        $sQuery = 'SELECT count(*) as count
    			   FROM realestate r
    			   WHERE r.status = ?';
        $aParams = array(ACCEPT);
        if ($categoryId) {
            $sQuery .= ' AND r.categoryid = ?';
            $aParams[] = $categoryId;
        }
        if ($transaction) {
            $sQuery .= ' AND transaction = ?';
            $aParams[] = $transaction;
        }

        return $this->db->query($sQuery, $aParams)->row()->count;
    }

    /*
     * Author: VinhBSD
     * Summary: check if an real estate with provided ID exist
     * Return: TRUE if exist, FALSE if not
     */

    function Exist($realEstateId) {
        $sQuery = 'SELECT 1 FROM realestate
    			   WHERE status = ? and realestateid = ?';
        $query = $this->db->query($sQuery, array(ACCEPT, $realEstateId));

        return $query->num_rows() ? true : false;
    }

    /*
     * Author: VinhBSD
     * Summary: get real estates data for data table in reivew page 
     * Return: 
     */

    function GetRealEstateForReview($sFilter, $iSort, $sSortDir, $iLimit, $iOffset) {
        $aColumns = array(1 => 'title',
            2 => 'u.username',
            3 => 'date',
            4 => 'transaction',
            5 => 'category');
        $aParams = array(ADDNEW);
        $aResult = array();
        $sSelect = 'SELECT realestateid, title, date, transaction, c.name as category, u.username, u.userid ';
        $sQuery = 'FROM realestate r 
        		   JOIN "user" u ON u.userid = r.userid
        		   LEFT JOIN category c ON r.categoryid = c.categoryid 
        		   WHERE r.status = ? ';
        if ($sFilter) {
            $sQuery .= 'AND (title LIKE ? OR transaction LIKE ? OR c.name LIKE ? OR u.username LIKE ? OR status LIKE ?) ';
            for ($i = 0; $i < 5; ++$i) {
                $aParams[] = '%' . $sFilter . '%';
            }
        }
        $query = $this->db->query("SELECT count(*) as count " . $sQuery, $aParams);
        $aResult['iTotalDisplayRecords'] = $query->row()->count;
        ;

        if (array_key_exists($iSort, $aColumns)) {
            $sSortDir = addslashes($sSortDir);
            $sQuery .= "ORDER BY $aColumns[$iSort] $sSortDir ";
        }
        if ($iLimit) {
            $sQuery .= 'LIMIT ? ';
            $aParams[] = $iLimit;
        }
        if ($iOffset) {
            $sQuery .= 'OFFSET ?';
            $aParams[] = $iOffset;
        }
        $query = $this->db->query($sSelect . $sQuery, $aParams);
        $aResult['aaData'] = $query->result_array();

        $aCountParams = array(ADDNEW);
        $sQuery = 'SELECT count(*) as count FROM realestate WHERE status = ?';
        $aResult['iTotalRecords'] = $this->db->query($sQuery, $aCountParams)->row()->count;

        return $aResult;
    }

}

?>
