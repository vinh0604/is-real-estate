<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>RE2Y - Real Estate to You</title>
	<!--[if IE]>
		<link rel="stylesheet" href="<?=base_url()?>css/blueprint/ie.css" type="text/css" media="screen"/>
	<![endif]-->
	<link rel="stylesheet" href="<?=base_url()?>css/blueprint/screen.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/blueprint/print.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?=base_url()?>css/style.css" type="text/css" media="screen"/>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?=base_url()?>css/validationEngine.jquery.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.validationEngine-vi.js" type="text/javascript"></script>
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDS5bb-pXbt4N27kkA9y1AS0nGxgciqTiU&sensor=true&language=vi">
    </script>
	<script type="text/javascript" charset="utf-8">
	var geocoder;
	function getLatLng() {
		if ($('#address').val() && $('#city').val()) {
			var address = $('#address').val();
			if ($('#district').val()) {
				address += ', ' + $("#district option:selected").text();
			}
			address += ', ' + $("#city option:selected").text();
			geocoder.geocode( { 'address': address}, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {
				$('#lat').val(results[0].geometry.location.lat());
				$('#lng').val(results[0].geometry.location.lng());
		      }
		    });
		}
	}
	$(document).ready(function(){
		geocoder = new google.maps.Geocoder();
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#city').change(function(){
			$.getJSON('<?=base_url()?>index.php/realestate/getdistrictbycityid',
					 {id: $('#city').val()},
					 function(districts) {
					 	var htmlDistrict = ['<option value="">Quận/ Huyện</option>'];
					 	console.log(districts);
					 	for(i in districts) {
					 		htmlDistrict.push(''.concat('<option value="',districts[i].districtid,'">',districts[i].name,'</option>'));
					 	}
					 	$('#district').html(htmlDistrict.join(''));
					 });
			getLatLng();
		});
		$('#district').change(function(){
			getLatLng();
		});
		$('#address').blur(function(){
			getLatLng();
		});
		$('#re_frm').validationEngine('attach');
		$('#map_marker').click(function(){
			window.open ("<?=base_url()?>public/mapMarkerPage.html","mymap",'width=840,height=600,toolbar=0,resizable=0');
		});
	})
	</script>
</head>
<body>
	<?=$topBar?>
	<div class="container">
		<div class="main-content span-24">
			<div class="breadcrumbs">
				<ul>
					<li class="crumb-first"><a href="<?=base_url()?>index.php"><img src="<?=base_url()?>images/home.png" alt="Trang chủ" width="21"/></a></li>
					<li class="crumb-sub"><a href="<?=base_url()?>index.php/realestate/manage">Quản lý tin BĐS</a></li>
					<li class="crumb-last"><a href="<?=base_url()?>index.php/realestate/addnewitem#">Tạo tin BĐS</a></li>
				</ul>
			</div>
			<div class="form_title">Thông tin BĐS</div>
			<?=validation_errors('<div class="error" style="width: 450px;margin: 4px auto;">','</div>');?>
			<div class="form_wrapper span-18">
				<form action="<?=base_url()?>index.php/realestate/create" method="post" id="re_frm">
				<table>
					<tr>
						<td colspan="3" style="text-align: center">
							<label>(*): Các trường bắt buộc</label>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="title">Tiêu đề tin (*):</label></td>
						<td colspan="2"><input type="text" name="title" id="title" placeholder="Nhập tiêu đề..." class="validate[required]"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label>Loại giao dịch (*):</label></td>
						<td colspan="2">
							<input type="radio" name="transaction" id="transaction_0" value="Bán" checked class="validate[required]"/>
							<label for="transaction_0">Bán</label>
							<input type="radio" name="transaction" id="transaction_1" value="Thuê" class="validate[required]"/>
							<label for="transaction_1">Cho thuê</label>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="category">Loại BĐS (*):</label></td>
						<td colspan="2">
							<select name="category" id="category" class="validate[required]">
								<option value="">Chọn loại BĐS</option>
								<?php foreach($categories as $c):?>
								<option value="<?=$c->categoryid?>"><?=$c->name?></option>	
								<?php endforeach;?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="address">Địa chỉ (*):</label></td>
						<td colspan="2"><input type="text" name="address" id="address" placeholder="Nhập số nhà, đường, phường xã..." class="validate[required]"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"></td>
						<td style="width: 169px;">
							<select name="city" id="city" class="validate[required]">
								<option value="">Tỉnh / Thành phố</option>
								<?php foreach($cities as $c):?>
								<option value="<?=$c->cityid?>"><?=$c->name?></option>	
								<?php endforeach;?>
							</select>
						</td>
						<td>
							<select name="district" id="district">
								<option value="">Quận / Huyện</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="price">Giá (*):</label></td>
						<td style="width: 169px;">
							<input type="text" name="price" id="price" style="width: 78px;" class="validate[required,custom[number]]"/>
							<select name="currency" id="currency" style="width: 85px;">
								<option value="VND">triệu VNĐ</option>
								<option value="USD">USD</option>
								<option value="lượng">lượng</option>
								<option value="lượng">chỉ</option>
							</select>
						</td>
						<td>
							<label for="unit">Đơn vị tính :</label>
							<input type="text" name="unit" id="unit" style="width: 71px;"/>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="area">Diện tích (*):</label></td>
						<td colspan="2">
							<input type="text" name="area" id="area" style="width: 169px;"  class="validate[required,custom[number]]"/>
							<b>mét vuông</b>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="width">Kích thước:</label></td>
						<td style="width: 169px;">
							<input type="text" name="width" id="width" style="width: 142px;" placeholder="Nhập chiều rộng..." class="validate[optional,custom[number]]"/>
							<b>mét</b>
						</td>
						<td>
							<input type="text" name="length" id="length" style="width: 142px;" placeholder="Nhập chiều dài..." class="validate[optional,custom[number]]"/>
							<b>mét</b>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="direction">Phương hướng:</label></td>
						<td colspan="2">
							<select name="direction" id="direction">
								<option value="">Chọn hướng nhà</option>
								<option value="Đông">Đông</option>
								<option value="Tây">Tây</option>
								<option value="Nam">Nam</option>
								<option value="Bắc">Bắc</option>
								<option value="Đông Bắc">Đông Bắc</option>
								<option value="Tây Nam">Tây Nam</option>
								<option value="Đông Nam">Đông Nam</option>
								<option value="Tây Bắc">Tây Bắc</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="alley">Độ rộng lối vào:</label></td>
						<td colspan="2">
							<input type="text" name="alley" id="alley" class="validate[optional,custom[number]]" style="width: 142px;"/>
							<b>mét</b>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="legal_status">Tình trạng pháp lý:</label></td>
						<td colspan="2">
							<select name="legalstatus" id="legalstatus">
								<option value="">Chọn Tình trạng pháp lý</option>
								<option value="Sổ đỏ">Sổ đỏ</option>
								<option value="Sổ hồng">Sổ hồng</option>
								<option value="Giấy tờ hợp lệ">Giấy tờ hợp lệ</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="description">Mô tả chi tiết:</label></td>
						<td colspan="2">
							<textarea name="description" id="description" placeholder="Thông tin về cơ sở vật chất, tiện nghi, phòng ốc..."/></textarea>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"></td>
						<td colspan="2">
							<a href="#" id="map_marker" class="popup_link">Nhấp vào để chọn vị trí bất động sản trên bản đồ</a>
						</td>
					</tr>
				</table>
				<input type="hidden" name="lat" id="lat"/>
				<input type="hidden" name="lng" id="lng"/>
				<div class="section_header">Thông tin liên hệ</div>
				<table>
					<tr>
						<td class="label_wrapper"><label for="contactname">Người liên hệ (*):</label></td>
						<td colspan="2"><input type="text" name="contactname" id="contactname" class="validate[required]" value="<?=$user? $user->name : ''?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="contacttel">Số điện thoại (*):</label></td>
						<td colspan="2"><input type="text" name="contacttel" id="contacttel" class="validate[required,custom[onlyNumber]]" value="<?=$user? $user->tel : ''?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="contactadd">Địa chỉ (*):</label></td>
						<td colspan="2"><input type="text" name="contactadd" id="contactadd" class="validate[required]" value="<?=$user? $user->address : ''?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="remark">Ghi chú:</label></td>
						<td colspan="2"><textarea name="remark" id="remark"></textarea></td>
					</tr>
					<tr>
						<td colspan="3" style="text-align: center;"><input type="submit" value="Tạo tin" class="submit_btn"/></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>