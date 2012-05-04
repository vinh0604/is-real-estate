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
	<link rel="stylesheet" href="<?=base_url()?>css/prettyPhoto.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/context.menu.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.prettyPhoto.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/GeoJSON.js" type="text/javascript"></script>
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDS5bb-pXbt4N27kkA9y1AS0nGxgciqTiU&sensor=true&language=vi">
    </script>
    <script src="<?=base_url()?>js/context.menu.js" type="text/javascript"></script>
    <script src="<?=base_url()?>js/common.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	var SALE = 'Bán';
	var LEASE = 'Thuê';
	var BASE_URL = '<?=base_url()?>';
	var map = null;
	var directionsDisplay = new google.maps.DirectionsRenderer();
	var directionsService = new google.maps.DirectionsService();
	var fromMarker = null;
	var menu = null;
	var infoWindow = null;
	var marker = null;
	
	function getDirection() {
		if (fromMarker && marker) {
			var request = {
				origin: fromMarker.getPosition(),
      			destination: marker.getPosition(),
      			travelMode: google.maps.TravelMode.DRIVING
			};
			directionsService.route(request, function(response, status) {
			    if (status == google.maps.DirectionsStatus.OK) {
			    	directionsDisplay.setMap(map);
			      	directionsDisplay.setDirections(response);
			      	$('#map_canvas').width(270);
			      	$('#directionsPanel').show();
			    }
			});
		}
	}
	$(document).ready(function(){
		$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:'',deeplinking: false});
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		
		var icon = '<?=base_url()?>images/house_sale.png';
		if ('<?=$realEstate['transaction']?>' == LEASE) {
	  		icon = '<?=base_url()?>images/house_lease.png';
	  	}
		<?php if ($realEstate['location']):?>
		marker = new GeoJSON(<?=$realEstate['location']?>, {"icon": icon});
		<?php endif;?>
		var myLatlng = new google.maps.LatLng(10.75, 106.67);
		var myOptions = {zoom: 16,
						center: myLatlng,
						  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		if (marker) {
			marker.setMap(map);
			map.panTo(marker.getPosition());
		}
		
		directionsDisplay.setMap(map);
		directionsDisplay.setPanel(document.getElementById("directionsPanel"));
		
		menu = new contextMenu({map:map});
		
		menu.addItem('Tìm đường từ đây', function(map, latLng){
			if (!fromMarker) {
				fromMarker = new google.maps.Marker({icon: '<?=base_url()?>images/from_marker.png'});
				fromMarker.setMap(map);
			}
			fromMarker.setPosition(latLng);
			getDirection();
		});
		
		menu.addSep();
		
		menu.addItem('Phóng to', function(map, latLng){
			map.setZoom( map.getZoom() + 1);
			map.panTo( latLng );
		});

		menu.addItem('Thu nhỏ', function(map, latLng){
			map.setZoom( map.getZoom() - 1 );
			map.panTo(latLng);
		});

		menu.addSep();

		menu.addItem('Chuyển đến', function(map, latLng){
			map.panTo(latLng);
		});
		
		menu.addItem('Làm mới', function(){
      		directionsDisplay.setMap(null);
      		fromMarker.setMap(null);
      		fromMarker = null;
      		$('#directionsPanel').hide();
      		$('#map_canvas').width(470);
		});
		var price = formatPrice('<?=$realEstate['price']?>') + ' ' + '<?=$realEstate['currency']?>';
		$('.price').text(price);
	})
	</script>
</head>
<body>
	<?=$topBar?>
	<div class="container">
		<div class="main-content span-24" style="padding-left: 20px;width: 930px;">
			<div class="news_title"><?=$realEstate['title']?></div>
			<div class="news_detail">
				<div class="span-11">
					<table>
						<tr>
							<td class="title" style="width: 55px;">Mã BĐS:</td>
							<td style="color: #FA7003;font-weight: bold;"><?=$realEstate['realestateid']?></td>
							<td class="title" style="width: 55px;">Giao dịch:</td>
							<td style="width: 67px;"><a href="#"><?=$realEstate['transaction']?></a></td>
							<td class="title" style="width: 55px;">Loại BĐS:</td>
							<td><a href="<?=base_url()?>index.php/realestate/category/<?=$realEstate['categoryid']?>"><?=$realEstate['category']?></a></td>
						</tr>
						<tr>
							<td class="title">Địa chỉ:</td>
							<td colspan="5"><?=$realEstate['address']?></td>
						</tr>
						<tr>
							<td class="title">Diện tích:</td>
							<td colspan="2"><?=$realEstate['area']?> m2</td>
							<td class="title">Kích thước:</td>
							<td colspan="2"><?=$realEstate['size']?></td>
						</tr>
						<tr>
							<td class="title" style="vertical-align: bottom;">Giá: </td>
							<td colspan="3" class="price"></td>
							<td class="title" style="vertical-align: bottom;">Đơn vị:</td>
							<td style="vertical-align: bottom;"><?=$realEstate['unit']?></td>
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
								<td class="title"><?=$realEstate['contactname']?></td>
							</tr>
							<tr>
								<td>Điện thoại:</td>
								<td class="title"><?=$realEstate['contacttel']?></td>
							</tr>
							<tr>
								<td>Địa chỉ: </td>
								<td><?=$realEstate['contactadd']?></td>
							</tr>
							<tr>
								<td>Ghi chú:</td>
								<td><?=$realEstate['remark']?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="span-12">
					<div class="span-12">
					  	<div id="map_canvas" class="span-12" style="height: 350px;"></div>
					  	<div id="directionsPanel" style="margin-right:5px;float:right;width:180px;height:350px;overflow-y:auto;display:none;background-color:#fff"></div>
					</div>
					<div class="span-12" style="padding: 5px;">
						<?php foreach($photos as $p):?>
						<a href="<?=base_url()?>images/files/<?=$realEstate['realestateid']?>/<?=$p['url']?>" rel="prettyPhoto[pp_gal]"><img src="<?=base_url()?>images/thumbnails/<?=$realEstate['realestateid']?>/<?=$p['url']?>" width="60" height="60"/></a>
						<?php endforeach;?>
					</div>
				</div>
				<div class="span-22">
					<div class="sub-title">
						Thông tin bổ sung
					</div>
					<table>
						<tr>
							<td class="title" style="width: 105px;">Tình trạng pháp lý:</td>
							<td><?=$realEstate['legalstatus']?></td>
							<td class="title" style="width: 95px;">Phương hướng:</td>
							<td><?=$realEstate['direction']?></td>
							<td class="title" style="width: 75px;">Đường hẻm:</td>
							<td><?=$realEstate['alley'] ? $realEstate['alley'].' mét' : ''?> </td>
						</tr>
					</table>
					<div style="padding-left: 10px;">
					  	<p><?=$realEstate['description']?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>