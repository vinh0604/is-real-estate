<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Authorize_filter extends Filter {
	function before() {
		if(!$this->session->userdata('is_admin')) {
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    			&& (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    			$this->output->set_status_header('401');	
    		} else {
    			show_error('Bạn không có quyền truy cập đến trang này!');
    		}
			return false;
		}
		return true;
	}
}
?>