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
	<link rel="stylesheet" href="<?=base_url()?>css/lionbars.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/context.menu.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/GeoJSON.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.mousewheel.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.lionbars.0.3.min.js" type="text/javascript"></script>
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
	var aMarker = [];
	var distance = 1000;
	var fromMarker = null;
	var toPosition = null;
	var menu = null;
	var infoWindow = null;
	function addEvent(marker,realestateid) {
		google.maps.event.addListener(marker, 
									  'click', 
									  function(event){
									  	showInfo(marker,realestateid);
									  });
	}
	function showInfo(marker,realEstateId) {
		$.getJSON('<?=base_url()?>index.php/home/getdetail',
				  {id: realEstateId},
				  function(realEstate) {
				  	var url = '<?=base_url()?>index.php/realestate/' + realEstate.realestateid;
				  	var price = '';
				  	if (parseFloat(realEstate.price)) {
				  		price = price.concat('<span class="info_price">',formatPrice(realEstate.price),realEstate.currency,'</span>');
					  	if (realEstate.unit) {
					  		price = price.concat(' / ',realEstate.unit);
					  	}
				  	}
				  	var direction_url = ''.concat('<a href="#" class="direction_link" lat="',marker.getPosition().lat(),'" lng="',marker.getPosition().lng(),'" style="float: left">Tìm đường đến đây</a>');
				  	var cart_url = ''.concat('<a href="#" class="add_cart" reid="',realEstate.realestateid,'" style="float: right">Thêm vào giỏ tin</a>');
				  	infoWindow.setContent('<div class="info_window">'.concat(
				  						  '<div class="info_title"><a href="',url,'">',realEstate.title,'</a></div>', 
				  						  '<div><b>Địa chỉ: </b>',realEstate.address,'</div>',
				  						  '<div><b>Diện tích: </b>',realEstate.area,' m2','</div>',
				  						  '<div><b>Loại BĐS: </b>',realEstate.category,'</div>',
				  						  '<div><b>Giá: </b> ',price,'</div>',
				  						  '<div><b>Điện thoại: </b>',realEstate.contacttel,'</div>',
				  						  '<div style="width: 100%; margin-top: 10px;">',direction_url,cart_url,'</div>',
				  						  '</div>'));
				  	infoWindow.open(map,marker);
				  });
	}
	function getDirection() {
		if (fromMarker && toPosition) {
			var request = {
				origin: fromMarker.getPosition(),
      			destination: toPosition,
      			travelMode: google.maps.TravelMode.DRIVING
			};
			directionsService.route(request, function(response, status) {
			    if (status == google.maps.DirectionsStatus.OK) {
			    	directionsDisplay.setMap(map);
			      	directionsDisplay.setDirections(response);
			      	$('#map_canvas').width(420);
			      	$('#directionsPanel').show();
			    }
			});
		}
	}
	function success(position) {
		var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		map.setCenter(myLatlng);
		$.getJSON('<?=base_url()?>index.php/home/getnear',
				  {lat: position.coords.latitude, lng: position.coords.longitude, distance: distance},
				  function(realEstates){
				  	for(i in realEstates) {
				  	  	var icon = '<?=base_url()?>images/house_sale.png';
				  	  	var location = JSON.parse(realEstates[i].location);
				  	  	if (realEstates[i].transaction == LEASE) {
				  	  		icon = '<?=base_url()?>images/house_lease.png';
				  	  	}
				  	  	var marker = new GeoJSON(location, {"icon": icon});
				  	  	marker.setMap(map);
				  	  	addEvent(marker,realEstates[i].realestateid);
				  	  	aMarker.push(marker);
				  	}
				  });
	}
	function error() {
		$.getJSON('<?=base_url()?>index.php/home/getnear',
				  {lat: 10.75, lng: 106.67, distance: distance},
				  function(realEstates){
				  	var marker;
				  	for(i in realEstates) {
				  	  	var icon = '<?=base_url()?>images/house_sale.png';
				  	  	var location = JSON.parse(realEstates[i].location);
				  	  	if (realEstates[i].transaction == LEASE) {
				  	  		icon = '<?=base_url()?>images/house_lease.png';
				  	  	}
				  	  	marker = new GeoJSON(location, {"icon": icon});
				  	  	marker.setMap(map);
				  	  	addEvent(marker,realEstates[i].realestateid);
				  	  	aMarker.push(marker);
				  	}
				  });
	}
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#news-list-box').lionbars();
		$('#city').change(function(){
			$.getJSON('<?=base_url()?>index.php/home/getdistrict',
					 {id: $('#city').val()},
					 function(districts) {
					 	var htmlDistrict = ['<option value="0">Quận/ Huyện</option>'];
					 	console.log(districts);
					 	for(i in districts) {
					 		htmlDistrict.push(''.concat('<option value="',districts[i].districtid,'">',districts[i].name,'</option>'));
					 	}
					 	$('#district').html(htmlDistrict.join(''));
					 });
		});
		
		$('.direction_link').live('click',function() {
			toPosition = new google.maps.LatLng($(this).attr('lat'),$(this).attr('lng'));
			infoWindow.close();
			getDirection();
		});
		
		var myLatlng = new google.maps.LatLng(10.75, 106.67);
		var myOptions = {zoom: 15,
						 center: myLatlng,
						 mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		directionsDisplay.setMap(map);
		directionsDisplay.setPanel(document.getElementById("directionsPanel"));
		
		// get current location using HTML5 geolocation
		if (navigator.geolocation) {
		  	navigator.geolocation.getCurrentPosition(success, error);
		} else{
			error();
		}
		
		infoWindow = new google.maps.InfoWindow();
		
		// add right-click context menu
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
      		toPosition = null;
      		$('#directionsPanel').hide();
      		$('#map_canvas').width(650);
		});
	})
	</script>
</head>
<body>
	<?=$topBar?>
	<div class="container">
		<div class="left-container span-16">
			<div id="search-area" class="main-area span-16">
				<form id="search_frm" method="get" action="<?=base_url()?>index.php/search/basicsearch">
					<table>
						<tr>
							<td colspan="2" style="width: 70%"><input type="text" name="k" id="keyword" placeholder="Nhập từ khóa..."/></td>
							<td rowspan="2">
								<button id="search_btn">
									<span id="search_icon"></span>
								</button>
							</td>
						</tr>
						<tr>
							<td>
								<select name="city" id="city" style="width:250px;">
									<option value="0">Tỉnh/Thành phố</option>
									<?php foreach ($cities as $c):?>
										<option value="<?=$c->cityid?>"><?=$c->name?></option>
									<?php endforeach;?>
								</select>
							</td>
							<td>
								<select name="district" id="district" style="width:160px;">
									<option value="0">Quận/ Huyện</option>
								</select>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="hot-area" class="main-area span-16">
				<div id="directionsPanel" style="margin-right:5px;float:left;width:200px;height:450px;overflow-y:auto;display:none;background-color:#fff"></div>
				<div id="map_canvas" style="height: 450px;width: 650px;"></div>
			</div>
		</div>
		<div id="new-area" class="main-area span-7 last">
			<div class="caption">
				<a href="#">
					<img src="<?=base_url()?>images/blue_new.png" alt=""/>
					<span>Tin mới</span>
				</a>
			</div>
			<div id="news-list-box" class="span-7">
				<ul>
					<?php foreach ($realEstates as $r):?>
					<li>
						<div class="news-wrap">
							<div class="left-news">
								<a href="<?=base_url()?>index.php/realestate/index/<?=$r['realestateid']?>">
									<img src="<?=$r['url'] ? base_url('images/thumbnails/'.$r['realestateid'].'/'.$r['url']) : base_url('images/noimage.jpg')?>" alt="Hình địa ốc" width="64"/>
								</a>
							</div>
							<div class="right-news">
								<div class="news-title">
									<a href="<?=base_url()?>index.php/realestate/index/<?=$r['realestateid']?>"><?=$r['title']?></a>
								</div>
							</div>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>