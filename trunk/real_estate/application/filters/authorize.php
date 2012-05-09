<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Authorize_filter extends Filter {
	function before() {
		$CI =& get_instance();
		if(!$CI->session->userdata('is_admin')) {
		// if(false) {
			if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    			&& (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
    			$CI->output->set_status_header('401');	
    		} else {
    			show_error('Bạn không có quyền truy cập đến trang này!');
    		}
			return false;
		}
		return true;
	}
}
?>