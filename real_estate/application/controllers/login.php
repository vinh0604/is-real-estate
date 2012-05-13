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

	/*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function ForgetPass() {
    	$data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->view('recoverPasswordPage',$data);
    }

	/*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function RecoverPass() {
    	$email = $this->input->post('email');
		
    	$this->load->model('user_Model');
    	$userId = $this->user_Model->GetUserIDByEmail($email);
		
		if($userId!==FALSE) {
			$password = $this->user_Model->GenerateRandomPassword($userId);
			if ($password !== FALSE) {
				$data['password'] = $password;
				$content = $this->load->view('recover_template',$data,true);
				$this->SendRecoverEmail($email, $content);
				$this->session->set_flashdata('success','Khôi phục mật khẩu thành công. Mật khẩu mới đã được gửi về email của bạn.');
			} else {
				$this->session->set_flashdata('error','Có lỗi xảy ra. Vui lòng thử lại!');
			}
		} else {
			$this->session->set_flashdata('error','Không có tài khoản phù hợp với email!');
		}
		redirect('notice');
    }

	/*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    private function SendRecoverEmail($email,$content) {
    	$this->load->library('email');  
		$this->email->from('re2yteam@gmail.com','Review');  
		$this->email->to($email);  
		$this->email->subject('Thông tin khôi phục mật khẩu');  
		$this->email->message($content);  
		$this->email->send();
    }

}

?>
