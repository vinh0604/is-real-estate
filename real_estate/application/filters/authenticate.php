<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Authenticate_filter extends Filter {
    function before() {
        $CI =& get_instance();
        // if(!$CI->session->userdata('user_id')) {
        if(false) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
                $CI->output->set_status_header('403');	
            } else {
                redirect(base_url('index.php/login'));
            }
            return false;
        }
        return true;
    }
}
?>