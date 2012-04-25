<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get User by ID
    //Parameter $userID
    //return User
    function GetUser($userID) {
        $query = 'SELECT * FROM "user" WHERE USERID = ?';
        $result = $this->db->query($query, array($userID))->result();
        return $result;
    }

    //Get All of User
    //return list of user whose duty is normal user
    function GetALlUsers() {
        $query = 'SELECT * FROM "user" WHERE DUTY = \'Người dùng\'';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //Get All of Admin
    //return list of user whose duty is admin
    function GetALlAdmins() {
        $query = 'SELECT * FROM "user" WHERE DUTY = \'Quản trị\'';
        $result = $this->db->query($query)->result();
        return $result;
    }

    //Add New User
    //$newUser is an array contains attributes of new user
    //return the result of executing of query
    function AddNewUser($newUser){
        $query = $this->db->insert('"user"',$newUser);
        return $query;
    }
    
    //Delete User
    //parameter $userID
    //return the result of executing of query
    function DeleteUser($userID){
        $query = 'DELETE FROM "user" WHERE USERID = ?';
        $result = $this->db->query($query, array($userID));
        return $result;
    }
    
    //Update User
    function UpdateUser(){
    
    }
    
    //Change Password
    //parameter $userID, $password is the new password and is encoded with MD5
    //return the result of executing of query
    function ChangePassword($userID,$password){
        $query = "UPDATE USER SET PASSWORD = ? WHERE USERID = ?";
        $result = $this->db->query($query,array ($password, $userID));
        return $result;
    }
    
    
    function CheckOldPassword($userID,$oldPassword){
    
    }
    
    //Validate Data Format
    function ValidateDataFormat(){
        
    }
    
    //Validate User
    function ValidateUser(){
    
    }
    
    //Validate Unique
    function ValidateUnique(){
    
    }
    
    //Find By ID
    function FindByID(){
    }
}

?>
