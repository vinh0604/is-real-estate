<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Register extends CI_Controller {

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

    function index() {
        $data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar', $data, true);
        $this->load->view('registerPage', $data);
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function DoRegister() {
        $account = array
            ("username" => $this->input->post("username"),
            "password" => ($this->input->post("password")),
            "email" => $this->input->post("email"),
            "name" => $this->input->post("fullname"),
            "gender" => ($this->input->post('gender') == 1) ? "Nam" : "Nữ",
            "tel" => $this->input->post("phone"),
            "idnumber" => $this->input->post("identity"),
            "address" => $this->input->post("address"),
            "birthday" => $this->input->post("birthdate"),
            "duty" => "Người dùng"
        );

        $this->load->model("User_Model");
        if ($this->User_Model->ValidateDataFormat($account)) {
            if ($this->User_Model->ValidateUnique($account)) {
                echo $this->User_Model->AddNewUser($account);
                $this->SendEmail($account['email']);
            }
            else
                echo "Tên đăng nhập hoặc email đã được sử dụng";
        }
        else
            echo "Tuổi không phù hợp";
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function SendEmail($email) {
        
    }

}

?>
