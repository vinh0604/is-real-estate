<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>RE2Y - Real Estate to You</title>
	<!--[if IE]>
		<link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen"/>
	<![endif]-->
	<link rel="stylesheet" href="<?=base_url()?>css/blueprint/screen.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/blueprint/print.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?=base_url()?>css/style.css" type="text/css" media="screen"/>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?=base_url()?>css/prettyPhoto.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.prettyPhoto.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	var map;
	$(document).ready(function(){
		var myLatlng = new google.maps.LatLng(10.75, 106.67);
		var myOptions = {zoom: 16,
						  center: myLatlng,
						  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:''});
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	})
	</script>
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDS5bb-pXbt4N27kkA9y1AS0nGxgciqTiU&sensor=true&language=vi">
    </script>
</head>
<body>
	<?=$topBar?>
	<div class="container">
		<div class="main-content span-24" style="padding-left: 20px;width: 930px;">
			<div class="news_title">Bán biệt thự tại Thủ Đức</div>
			<div class="news_detail">
				<div class="span-11">
					<table>
						<tr>
							<td class="title" style="width: 55px;">Mã BĐS:</td>
							<td style="color: #FA7003;font-weight: bold;">000154</td>
							<td class="title">Giao dịch:</td>
							<td><a href="#">Cần bán</a></td>
							<td class="title">Loại BĐS:</td>
							<td><a href="#">Biệt thự</a></td>
						</tr>
						<tr>
							<td class="title">Địa chỉ:</td>
							<td colspan="5">108/7, đường 11, phường Linh Xuân, quận Thủ Đức, thành phố Hồ Chí Minh</td>
						</tr>
						<tr>
							<td class="title">Diện tích:</td>
							<td colspan="2">200 m2</td>
							<td class="title">Kích thước:</td>
							<td colspan="2">40m x 50m</td>
						</tr>
						<tr>
							<td class="title" style="vertical-align: bottom;">Giá: </td>
							<td colspan="3" class="price">2 tỷ 500 triệu VNĐ</td>
							<td class="title" style="vertical-align: bottom;">Đơn vị:</td>
							<td style="vertical-align: bottom;">căn</td>
						</tr>
						<tr>
							<td colspan="6">
								<div style="height: 30px;text-align: right;">
									<button class="submit_btn">
										<img src="<?=base_url()?>images/shopping_cart.png" alt="" style="vertical-align: middle;"/>
										Thêm vào giỏ tin
									</button>
								</div>
							</td>
						</tr>
					</table>
					<div class="module">
						<div class="caption-area">Liên hệ</div>
						<table>
							<tr>
								<td style="width: 65px;">Họ tên:</td>
								<td class="title">Bạch Sỹ Đức Vinh</td>
							</tr>
							<tr>
								<td>Điện thoại:</td>
								<td class="title">0123 456 789</td>
							</tr>
							<tr>
								<td>Địa chỉ: </td>
								<td>108/7, đường 11, phường Linh Xuân, quận Thủ Đức, thành phố Hồ Chí Minh</td>
							</tr>
							<tr>
								<td>Ghi chú:</td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="span-12">
					<div id="map_canvas" class="span-12" style="height: 350px;"></div>
					<div class="span-12" style="padding: 5px;">
						<a href="<?=base_url()?>images/files/1.jpg" rel="prettyPhoto[pp_gal]"><img src="<?=base_url()?>images/thumbnails/1.jpg" width="60" height="60"/></a>
					</div>
				</div>
				<div class="span-22">
					<div class="sub-title">
						Thông tin bổ sung
					</div>
					<table>
						<tr>
							<td class="title" style="width: 105px;">Tình trạng pháp lý:</td>
							<td>Có sổ hồng</td>
							<td class="title" style="width: 95px;">Phương hướng:</td>
							<td>Đông Tây</td>
							<td class="title" style="width: 75px;">Đường hẻm:</td>
							<td>là gì vậy?</td>
						</tr>
					</table>
					<div style="padding-left: 10px;">
					  	<p>Đoạn mô tả thứ nhất</p>
						<p>Đoạn mô tả tiếp theo</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>