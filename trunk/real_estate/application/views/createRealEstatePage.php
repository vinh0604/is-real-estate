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
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#news_frm').validationEngine('attach');
		$('#map_marker').click(function(){
			window.open ("<?=base_url()?>public/mapMarkerPage.html","mymap",'width=840,height=600,toolbar=0,resizable=0');
		})
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
					<li class="crumb-sub"><a href="<?=base_url()?>index.php/realestate">Quản lý tin BĐS</a></li>
					<li class="crumb-last"><a href="<?=base_url()?>index.php/realestate">Tạo tin BĐS</a></li>
				</ul>
			</div>
			<div class="form_title">Thông tin BĐS</div>
			<div class="form_wrapper span-18">
				<form action="<?=base_url()?>index.php/realestate" method="post" id="news_frm">
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
							<input type="radio" name="transaction" id="transaction_0" value="0" checked class="validate[required]"/>
							<label for="transaction_0">Bán</label>
							<input type="radio" name="transaction" id="transaction_1" value="1" class="validate[required]"/>
							<label for="transaction_1">Cho thuê</label>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="re_type">Loại BĐS (*):</label></td>
						<td colspan="2">
							<select name="re_type" id="re_type" class="validate[required]">
								<option value="">Chọn loại BĐS</option>
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
							<select name="district" id="district" class="validate[required]">
								<option value="">Quận / Huyện</option>
							</select>
						</td>
						<td>
							<select name="city" id="city" class="validate[required]">
								<option value="">Tỉnh / Thành phố</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="price">Giá (*):</label></td>
						<td style="width: 169px;">
							<input type="text" name="price" id="price" style="width: 110px;" class="validate[required,custom[number]]"/>
							<b>triệu VNĐ</b>
						</td>
						<td>
							<label for="unit">Đơn vị tính (*):</label>
							<input type="text" name="unit" id="unit" style="width: 71px;"  class="validate[required]"/>
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
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="alley">Đường hẻm:</label></td>
						<td colspan="2">
							<input type="text" name="alley" id="alley"/>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="legal_status">Tình trạng pháp lý (*):</label></td>
						<td colspan="2">
							<select name="legal_status" id="legal_status" class="validate[required]">
								<option value="">Chọn Tình trạng pháp lý</option>
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
				<input type="hidden" name="lat" id="lng"/>
				<div class="section_header">Thông tin liên hệ</div>
				<table>
					<tr>
						<td class="label_wrapper"><label for="c_person">Người liên hệ (*):</label></td>
						<td colspan="2"><input type="text" name="c_person" id="c_person" class="validate[required]"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="c_phone">Số điện thoại (*):</label></td>
						<td colspan="2"><input type="text" name="c_phone" id="c_phone" class="validate[required,custom[onlyNumber]]"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="c_address">Địa chỉ (*):</label></td>
						<td colspan="2"><input type="text" name="c_address" id="c_address" class="validate[required]"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="c_note">Ghi chú:</label></td>
						<td colspan="2"><textarea name="c_note" id="c_note"></textarea></td>
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