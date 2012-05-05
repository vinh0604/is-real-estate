<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('formatPrice'))
{
    function formatPrice($price)
    {
    	$remain = '';
    	if (strpos($price,'.')!==false) {
			$remain = substr($price,strpos($price,'.'));
			$price = str_replace($remain,'',$price);
    	}
        $sPrice = '';
		$num = null;
		$index = 9;
		if (strlen($price) > $index) {
			$num = substr($price,0,0-$index);
			if (intval($num)) {
				$sPrice .= $num.' tỷ ';
			}
            $price = substr($price,strlen($price) - $index);
		}
		
		$index = 6;
		if (strlen($price) > $index) {
			$num = substr($price,0,0-$index);
			if (intval($num)) {
				$sPrice .= $num.' triệu ';
			}
            $price = substr($price,strlen($price) - $index);
		}
		
		$index = 3;
		if (strlen($price) > $index) {
			$num = substr($price,0,0-$index);
			if (intval($num)) {
				$sPrice .= $num.' nghìn ';
			}
            $price = substr($price,strlen($price) - $index);
		}
		if (intval($price)) {
			$sPrice .= $price.$remain.' ';
		}
		return $sPrice;
	}   
}