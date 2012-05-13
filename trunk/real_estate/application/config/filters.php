<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Filters configuration
| -------------------------------------------------------------------
|
| Note: The filters will be applied in the order that they are defined
|
| Example configuration:
|
| $filter['auth'] = array('exclude', array('login/*', 'about/*'));
| $filter['cache'] = array('include', array('login/index', 'about/*', 'register/form,rules,privacy'));
|
*/
$filter['authenticate'] = array(
	'include', array('realestate/addnewitem,updateitem,deleteitem,accept,deny,getdetailforreview,sendreviewemail,manage,updatedatatable,create,complete,edit,review,updatedatareview',
					 'user/*',
					 'imageupload/*')
);
$filter['authorize'] = array(
	'include', array('realestate/accept,deny,getdetailforreview,sendreviewemail,review,updatedatareview',
	  				 'user/addnewuser,deleteuser')
);
?>