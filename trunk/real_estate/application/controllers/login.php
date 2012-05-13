<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends CI_Controller {

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
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->view('loginPage',$data);
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function SubmitLogin() {
        $username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$this->load->model('user_Model');
		$user = $this->user_Model->GetUserForLogin($username,$password);
		if ($user) {
			$this->session->set_userdata('user_id',$user['userid']);
                        if ($user['is_admin'] == 't') {
                            $this->session->set_userdata('is_admin',true);
                        } else {
                            $this->session->set_userdata('is_admin',false);
                        }
                        if ($this->session->userdata('previous_page')) {
                            $previous_page = $this->session->userdata('previous_page');
                            $this->session->unset_userdata('previous_page');
                            redirect($previous_page);
                        }else {
                            redirect(base_url());
                        }
		} else {
			$this->session->set_flashdata('error','Tên đăng nhập hoặc mật khẩu không chính xác');
			redirect(base_url('index.php/login'));
		}
    }

}

?>
