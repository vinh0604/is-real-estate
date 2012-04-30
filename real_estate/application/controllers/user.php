<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
     * Author: Hiep
     * Summary: Load Manage User Page
     * Return:
     */

    function index() {
        $this->load->model('User_Model');
        $data['topBar'] = $this->load->view('topBar', null, true);
        $data['lstAdmin'] = $this->User_Model->GetALlAdmins();
        $this->load->view('manageUserPage', $data);
    }

    /*
     * Author: Hiep
     * Summary: Get User Information
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetUser() {
        $this->load->model("User_Model");
        $username=$this->input->post("username");
        $res["row"] = $this->User_Model->GetUser($username);
        echo '{"res":' . json_encode($res) . '}';
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function AddNewUser() {
        $account = array
            ("username" => $this->input->post("username"),
            "password" => md5($this->input->post("password")),
            "email" => $this->input->post("email"),
            "name" => $this->input->post("fullname"),
            "tel" => $this->input->post("phone"),
            "address" => $this->input->post("address"),
            "birthday" => $this->input->post("birthdate"),
            "duty" => "Quản trị"
        );

        $this->load->model("User_Model");
        if ($this->User_Model->ValidateDataFormat($account)) {
            if ($this->User_Model->ValidateUnique($account)) {
                $result = $this->User_Model->AddNewUser($account);
                if ($result == 1) {
                    $res["message"] = "1";
                    $res["row"] = $this->User_Model->GetUser($account["username"]);
                    echo '{"res":' . json_encode($res) . '}';
                }
            } else {
                $res["message"] = 'Tên đăng nhập hoặc email đã được sử dụng';
                echo '{"res":' . json_encode($res) . '}';
            }
        } else {
            $res["message"] = "Tuổi không phù hợp";
            echo '{"res":' . json_encode($res) . '}';
        }
    }

    /*
     * Author: Hiep
     * Summary: Delete List Of User
     * Return: result of deleting.
     */

    function DeleteUser() {
        $this->load->model('User_Model');
        $list = $this->input->post("list");
        $res = array();
        for ($i = 0; $i < count($list); $i++) {
            $res[$i]["userid"] = (string)$list[$i];
            $res[$i]["result"] = (string)$this->User_Model->DeleteUser((int) $list[$i]);
        }
        $json['result'] = $res;
        echo '{"res":' . json_encode($json) . '}';
    }

        /*
     * Author: Hiep
     * Summary: Update User
     * Parameter 1:
     * Parameter 2:
     * Return:
     */
    function UpdateUser(){
         $account = array
            ("username" => $this->input->post("username"),
            "email" => $this->input->post("email"),
            "name" => $this->input->post("fullname"),
            "tel" => $this->input->post("phone"),
            "address" => $this->input->post("address"),
            "birthday" => $this->input->post("birthdate"),
        );
         $this->load->model('User_Model');
         echo $this->User_Model->UpdateUser($account);
    }
    
    /*
     * Author: Hiep
     * Summary: Load view of changing password
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function Change() {
        $data['topBar'] = $this->load->view('topBar', null, true);
        $this->load->view('changePasswordPage', $data);
    }

    /*
     * Author: Hiep
     * Summary: Check old password
     * Return: 1 if oldpassword id correct
     */

    function CheckOldPassword() {
        $userID = 2;
        $this->load->model('User_Model');
        $oldPassword = md5($this->input->post("oldPassword"));
        echo $this->User_Model->CheckOldPassword($userID, $oldPassword);
    }

    /*
     * Author: Hiep
     * Summary: Change password
     * Return: 1 if change successfully
     */

    function ChangePassword() {
        $userID = 2;
        $this->load->model('User_Model');
        $newPassword = md5($this->input->post("newPassword"));
        echo $this->User_Model->ChangePassword($userID, $newPassword);
    }

}

?>
