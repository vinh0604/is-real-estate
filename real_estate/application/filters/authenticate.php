<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Authenticate_filter extends Filter {
    function before() {
        $CI =& get_instance();
        if(!$CI->session->userdata('user_id')) {
            $CI->session->set_userdata('previous_page',  current_url());
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
                $CI->output->set_status_header('403');	
            } else {
                $CI->session->set_flashdata('error','Vui lòng đăng nhập để tiếp tục!');
                redirect(base_url('index.php/login'));
            }
            return false;
        }
        return true;
    }
}
?>