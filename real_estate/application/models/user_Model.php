<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * Author: Hiep
     * Summary: Get User by ID
     * Parameter 1: UserID
     * Return: Record of User by ID
     */

    function GetUser($userID) {
        $query = 'SELECT * FROM "user" WHERE USERID = ?';
        $result = $this->db->query($query, array($userID))->result();
        return $result;
    }

    /*
     * Author: Hiep
     * Summary: Get All of User
     * Parameter 1:
     * Parameter 2:
     * Return: list of user whose duty is normal user
     */

    function GetALlUsers() {
        $query = 'SELECT * FROM "user" WHERE DUTY = \'Người dùng\'';
        $result = $this->db->query($query)->result();
        return $result;
    }

    /*
     * Author: Hiep
     * Summary: Get all of Admins
     * Return: list of user whose duty is admin
     */

    function GetALlAdmins() {
        $query = 'SELECT * FROM "user" WHERE DUTY = \'Quản trị\'';
        $result = $this->db->query($query)->result();
        return $result;
    }

    /*
     * Author: Hiep
     * Summary: Add New User
     * Parameter 1: $newUser is an array contains attributes of new user
     * Return: the result of executing of query
     */

    function AddNewUser($newUser) {
        $query = $this->db->insert('"user"', $newUser);
        return $query;
    }

    /*
     * Author: Hiep
     * Summary:  Delete User
     * Parameter 1: user ID
     * Return: the result of Executing of query
     */

    function DeleteUser($userID) {
        $query = 'DELETE FROM "user" WHERE USERID = ?';
        $result = $this->db->query($query, array($userID));
        return $result;
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function UpdateUser() {
        
    }

    /*
     * Author: Hiep
     * Summary: Change Password
     * Parameter 1: $userID
     * Parameter 2: $password is the new password and is encoded with MD5
     * Return: the result of executing of query
     */

    function ChangePassword($userID, $password) {
        $query = "UPDATE USER SET PASSWORD = ? WHERE USERID = ?";
        $result = $this->db->query($query, array($password, $userID));
        return $result;
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function CheckOldPassword($userID, $oldPassword) {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function ValidateDataFormat() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function ValidateUser() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function ValidateUnique() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function FindByID() {
        
    }

}

?>
