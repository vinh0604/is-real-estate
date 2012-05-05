<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Realestate extends CI_Controller {

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

    function index($realEstateId) {
        $data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->model('realEstate_Model');
		$this->load->model('photo_Model');
		$data['realEstate'] = $this->realEstate_Model->FindByID($realEstateId);
		
		if($data['realEstate']) {
			$data['photos'] =  $this->photo_Model->GetByRealEstateID($realEstateId);
			$this->load->view('detailPage',$data);
		} else {
			show_404();
		}
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetCities() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetCategories() {
        
    }

    /*
     * Author: VinhBSD
     * Summary: get district by city id
     * Return:
     */

    function GetDistrictByCityID() {
        $cityId = $this->input->get('id');
		
		$this->load->model('district_Model');
		$districts = $this->district_Model->GetDistrictsByCityID($cityId);
		$this->output->set_output(json_encode($districts));
    }

    /*
     * Author: VinhBSD
     * Summary: load new real estate form
     * Return:
     */

    function AddNewItem() {
        $data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->model('city_Model');
		$data['cities'] = $this->city_Model->GetCities();
		
		$this->load->model('category_Model');
		$data['categories'] = $this->category_Model->GetCategories();
		
		$this->load->model('user_Model');
		$data['user'] = $this->user_Model->FindByID($this->session->userdata('user_id'));
		
		$this->load->view('createRealEstatePage',$data);
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function UpdateItem() {
        $this->load->library('form_validation');
		$this->lang->load('form_validation', 'vietnamese');
		
		$this->form_validation->set_rules('title', 'Tiêu đề tin', 'required');
		$this->form_validation->set_rules('transaction', 'Loại giao dịch', 'required');
		$this->form_validation->set_rules('category', 'Loại BĐS', 'required');
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
		$this->form_validation->set_rules('price', 'Giá', 'required|is_numeric');
		$this->form_validation->set_rules('area', 'Diện tích', 'required|is_numeric');
		$this->form_validation->set_rules('contactname', 'Người liên hệ', 'required');
		$this->form_validation->set_rules('contacttel', 'Điện thoại liên hệ', 'required');
		$this->form_validation->set_rules('contactadd', 'Địa chỉ liên hệ', 'required');
		
		if ($this->form_validation->run() == FALSE)
	    {
	    	// reload new real estate form
			$this->Edit();
			return false;
	    }
		
		// initializing real estate onbject
		$realEstateId = $this->input->post('realestateid');
		$realEstate = array();
		$realEstate['title'] = $this->input->post('title');
		$realEstate['transaction'] = $this->input->post('transaction');
		$realEstate['categoryid'] = $this->input->post('category');
		$realEstate['address'] = $this->input->post('address');
		
		// find and replace district and city in new address
		$this->load->model('district_Model');
		$this->load->model('city_Model');
		$this->load->model('realEstate_Model');
		$city = $this->city_Model->GetNameByID($this->input->post('city'));
		if($this->input->post('district')){
			$district = $this->district_Model->GetNameByID($this->input->post('district'));
			$realEstate['districtid'] = $this->input->post('district');
			// check if new address contain district name
			if (!stripos($realEstate['address'],$district)) {
				if (($pos = stripos($realEstate['address'],'quận')) || ($pos = stripos($realEstate['address'],'huyện'))) {
					$realEstate['address'] = substr_replace($realEstate['address'],$district.', '.$city,$pos);
				} else {
					$realEstate['address'] .= ', '.$district.', '.$city;
				}
			}
		// check if new address contain city name
		} else if (!stripos($realEstate['address'],$city)) {
			if (($pos = stripos($realEstate['address'],'quận')) || ($pos = stripos($realEstate['address'],'huyện'))) {
				$realEstate['address'] = substr_replace($realEstate['address'],$city,$pos);
			} else if (($pos = stripos($realEstate['address'],'thành phố')) || ($pos = stripos($realEstate['address'],'tp'))){
				$realEstate['address'] = substr_replace($realEstate['address'],$city,$pos);
			} else {
				$realEstate['address'] .= ', '.$city;
			}
		}
		
		$realEstate['currency'] = $this->input->post('currency');
		if($realEstate['currency'] == 'VND') {
			$realEstate['price'] = floatval($this->input->post('price')) * 1000000;
		} else {
			$realEstate['price'] = floatval($this->input->post('price'));
		}
		$realEstate['unit'] = $this->input->post('unit');
		$realEstate['area'] = $this->input->post('area');
		$size = array();
		if ($this->input->post('width')) {
			$size[] = $this->input->post('width').'m';
		}
		if ($this->input->post('length')) {
			$size[] = $this->input->post('length').'m';
		}
		$realEstate['size'] = implode(' x ', $size);
		$realEstate['direction'] = $this->input->post('direction');
		if ($this->input->post('alley')) {
			$realEstate['alley'] = $this->input->post('alley');
		}
		$realEstate['legalstatus'] = $this->input->post('legalstatus');
		$realEstate['description'] = $this->input->post('description');
		$realEstate['contactname'] = $this->input->post('contactname');
		$realEstate['contacttel'] = $this->input->post('contacttel');
		$realEstate['contactadd'] = $this->input->post('contactadd');
		$realEstate['remark'] = $this->input->post('remark');
		// get latitude and longitude
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
		
		$affected_rows = $this->realEstate_Model->UpdateItem($realEstateId,$realEstate,$lat,$lng);
		
		if ($affected_rows) {
			$this->session->set_flashdata('notice', 'Thao tác cập nhật tin thực hiện thành công!');
			redirect(base_url('index.php/realestate/edit/'.$realEstateId));
		} else {
			show_error("Không tìm thấy tin bất động sản yêu cầu!");
		}
    }

    /*
     * Author: VinhBSD
     * Summary: delete real estates
     * Return:
     */

    function DeleteItem() {
        $aRealEstateIds = $this->input->post('a_id');
		
		$this->load->model('realEstate_Model');
		$affected_rows = $this->realEstate_Model->DeleteItem($aRealEstateIds);
		
		if ($affected_rows) {
			$this->session->set_flashdata('notice', 'Thao tác xóa thực hiện thành công!');
			redirect(base_url('index.php/realestate/manage'));
		} else {
			show_error("Không tìm thấy tin bất động sản yêu cầu!");
		}
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function Accept() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function Deny() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function GetDetailForReview() {
        
    }

    /*
     * Author:
     * Summary: 
     * Parameter 1:
     * Parameter 2:
     * Return:
     */

    function SendReviewEmail() {
        
    }
	
	 /*
	 * Author: VinhBSD
	 * Summary: load real estate management page
	 * Return:
	 */

    function Manage() {
    	$data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->model('realEstate_Model');
		$this->load->view('manageRealEstatePage',$data);
    }

	/*
     * Author: VinhBSD
     * Summary: update data for datatable in real estate management page
     * Return:
     */
    
    function UpdateDataTable() {
    	$iLimit = $this->input->get('iDisplayLength');
		$iOffset = $this->input->get('iDisplayStart');
		$sFilter = $this->input->get('sSearch');
		$iSort = null;
		$sSortDir = null;
		for ( $i=0 ; $i<intval($this->input->get('iSortingCols')) ; $i++ )
		{
			if ($this->input->get('bSortable_'.intval($this->input->get('iSortCol_'.$i))) == "true" )
			{
				$iSort = $this->input->get('iSortCol_'.$i);
				$sSortDir = $this->input->get('sSortDir_'.$i);
			}
		}
		$this->load->model('realEstate_Model');
		$result = $this->realEstate_Model->GetRealEstateForDataTable($sFilter, $iSort, $sSortDir, $iLimit, $iOffset);
		$result['sEcho'] = $this->input->get('sEcho');
		$this->output->set_output(json_encode($result));
	}

	/*
     * Author: VinhBSD
     * Summary: create new real estate
     * Return:
     */
    
    function Create() {
    	$this->load->library('form_validation');
		$this->lang->load('form_validation', 'vietnamese');
		
		$this->form_validation->set_rules('title', 'Tiêu đề tin', 'required');
		$this->form_validation->set_rules('transaction', 'Loại giao dịch', 'required');
		$this->form_validation->set_rules('category', 'Loại BĐS', 'required');
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
		$this->form_validation->set_rules('price', 'Giá', 'required|is_numeric');
		$this->form_validation->set_rules('area', 'Diện tích', 'required|is_numeric');
		$this->form_validation->set_rules('contactname', 'Người liên hệ', 'required');
		$this->form_validation->set_rules('contacttel', 'Điện thoại liên hệ', 'required');
		$this->form_validation->set_rules('contactadd', 'Địa chỉ liên hệ', 'required');
		
		if ($this->form_validation->run() == FALSE)
	    {
	    	// reload new real estate form
			$this->AddNewItem();
			return false;
	    }
		
		// initializing real estate onbject
		$realEstate = array();
		$realEstate['title'] = $this->input->post('title');
		$realEstate['transaction'] = $this->input->post('transaction');
		$realEstate['categoryid'] = $this->input->post('category');
		$realEstate['address'] = $this->input->post('address');
		
		// append district name to address
		$this->load->model('district_Model');
		if($this->input->post('district')){
			$district = $this->district_Model->GetNameByID($this->input->post('district'));
			$realEstate['districtid'] = $this->input->post('district');
			if ($district) {
				$realEstate['address'] .= ', '.$district;
			}
		}
		// append city name to address
		$this->load->model('city_Model');
		$city = $this->city_Model->GetNameByID($this->input->post('city'));
		if ($city) {
			$realEstate['address'] .= ', '.$city;
		}
		
		$realEstate['currency'] = $this->input->post('currency');
		if($realEstate['currency'] == 'VND') {
			$realEstate['price'] = floatval($this->input->post('price')) * 1000000;
		} else {
			$realEstate['price'] = floatval($this->input->post('price'));
		}
		$realEstate['unit'] = $this->input->post('unit');
		$realEstate['area'] = $this->input->post('area');
		$size = array();
		if ($this->input->post('width')) {
			$size[] = $this->input->post('width').'m';
		}
		if ($this->input->post('length')) {
			$size[] = $this->input->post('length').'m';
		}
		$realEstate['size'] = implode(' x ', $size);
		$realEstate['direction'] = $this->input->post('direction');
		if ($this->input->post('alley')) {
			$realEstate['alley'] = $this->input->post('alley');
		}
		$realEstate['legalstatus'] = $this->input->post('legalstatus');
		$realEstate['description'] = $this->input->post('description');
		$realEstate['contactname'] = $this->input->post('contactname');
		$realEstate['contacttel'] = $this->input->post('contacttel');
		$realEstate['contactadd'] = $this->input->post('contactadd');
		$realEstate['remark'] = $this->input->post('remark');
		$realEstate['userid'] = $this->session->userdata('user_id');
		// get latitude and longitude
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
		
		$this->load->model('realEstate_Model');
		$data['realEstateId'] = $this->realEstate_Model->AddNewItem($realEstate,$lat,$lng);
		
		$data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);

		$this->load->view('addImagePage',$data);
	}

	/*
     * Author: VinhBSD
     * Summary: complete adding new real estate
     * Return:
     */
    
    function Complete() {
    	$this->session->set_flashdata('notice', 'Thao tác tạo tin thực hiện thành công!');
		redirect(base_url('index.php/realestate/manage'));
    }
	
	/*
     * Author: VinhBSD
     * Summary: load edit real estate form
     * Return:
     */
    
    function Edit($realEstateId) {
    	$data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$this->load->model('city_Model');
		$data['cities'] = $this->city_Model->GetCities();
		
		$this->load->model('category_Model');
		$data['categories'] = $this->category_Model->GetCategories();
		
		$this->load->model('realEstate_Model');
		if ($data['realEstate'] = $this->realEstate_Model->FindByIDForEdit($realEstateId)) {
			if ($data['realEstate']['currency'] == 'VND') {
				$data['realEstate']['price'] /= 1000000;
			}
			$data['realEstate']['width'] = '';
			$data['realEstate']['length'] = '';
			if ($data['realEstate']['size']) {
				$size = explode(' x ', $data['realEstate']['size']);
				if (array_key_exists(0, $size)) {
					$data['realEstate']['width'] = str_replace('m', '', $size[0]);
				} 
				if (array_key_exists(1, $size)) {
					$data['realEstate']['length'] = str_replace('m', '', $size[1]);;
				}
			}
			$data['districts'] = array();
			if ($data['realEstate']['cityid']) {
				$this->load->model('district_Model');
				$data['districts'] = $this->district_Model->GetDistrictsByCityID($data['realEstate']['cityid']);
			}
			$data['realEstate']['lat'] = '';
			$data['realEstate']['lng'] = '';
			if ($data['realEstate']['position']) {
				$position = substr($data['realEstate']['position'], strpos($data['realEstate']['position'], '('));
				$position = preg_replace('/[\(|\)]/', '', $position);
				$position = explode(' ', $position);
				if(count($position) > 1) {
					$data['realEstate']['lat'] = $position[1];
					$data['realEstate']['lng'] = $position[0];
				}
			}
			$this->load->view('editRealEstatePage',$data);
		} else {
			show_error("Không tìm thấy tin bất động sản yêu cầu!");
		}
		
    }

	/*
     * Author: VinhBSD
     * Summary: get real estates for showing by category and transaction
     * Return:
     */
    
    function View() {
    	$data['userdata'] = $this->session->userdata;
        $data['topBar'] = $this->load->view('topBar',$data,true);
		
		$categoryId = '';
		if($this->input->get('cat')) {
			$categoryId = $this->input->get('cat');
		}
		$transaction = '';
		if($this->input->get('trans')) {
			$transaction = $this->input->get('trans');
		}
		
		$this->load->model('realEstate_Model');
		$data['realEstates'] = $this->realEstate_Model->GetRealEstatesForListing(
															$categoryId,$transaction,10,0);
		$this->load->helper('utils');
		$data['content'] = $this->load->view('listContentPage',$data,true);
		
		$data['count'] = $this->realEstate_Model->CountAllRealEstates($categoryId,$transaction);
		$data['categoryId'] = $categoryId;
		$data['transaction'] = $transaction;
		
		$this->load->model('category_Model');
		$data['categories'] = $this->category_Model->GetCategories();
		$this->load->model('city_Model');
		$data['cities'] = $this->city_Model->GetCities();
		
		$this->load->view('listRealEstatePage',$data);
    }

	/*
     * Author: VinhBSD
     * Summary: get detail of specific real estates
     * Return: 
     */
    function GetDistrict() {
		$cityId = $this->input->get('id');
		
		$this->load->model('district_Model');
		$districts = $this->district_Model->GetDistrictsByCityID($cityId);
		$this->output->set_output(json_encode($districts));
	}

	/*
     * Author: VinhBSD
     * Summary: update content when changing page in list view
     * Return:
     */
    
    function UpdateView() {
    	$categoryId = '';
		if($this->input->get('cat')) {
			$categoryId = $this->input->get('cat');
		}
		$transaction = '';
		if($this->input->get('trans')) {
			$transaction = $this->input->get('trans');
		}
		$offset = 0;
		if($this->input->get('page')) {
			$offset = intval($this->input->get('page')) * 10;
		}
		
		$this->load->model('realEstate_Model');
		$data['realEstates'] = $this->realEstate_Model->GetRealEstatesForListing(
															$categoryId,$transaction,10,$offset);
		$this->load->helper('utils');
		$this->load->view('listContentPage',$data);
    }
}

?>
