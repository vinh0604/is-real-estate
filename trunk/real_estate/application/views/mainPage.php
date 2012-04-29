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
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/GeoJSON.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.mousewheel.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.lionbars.0.3.min.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	var SALE = 'Bán';
	var LEASE = 'Thuê';
	var map = null;
	var aMarker = [];
	var distance = 1000;
	function success(position) {
		var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		map.setCenter(myLatlng);
		$.getJSON('<?=base_url()?>index.php/home/getnear',
				  {lat: position.coords.latitude, lng: position.coords.longitude, distance: distance},
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
		var myLatlng = new google.maps.LatLng(10.75, 106.67);
		var myOptions = {zoom: 16,
						 center: myLatlng,
						 mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		if (navigator.geolocation) {
		  	navigator.geolocation.getCurrentPosition(success, error);
		} else{
			error();
		}
	})
	</script>
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDS5bb-pXbt4N27kkA9y1AS0nGxgciqTiU&sensor=true&language=vi">
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
								<select name="city" id="city">
									<option value="0">Tỉnh/Thành phố</option>
								</select>
							</td>
							<td>
								<select name="district" id="district">
									<option value="0">Quận/ Huyện</option>
								</select>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="hot-area" class="main-area span-16">
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
								<a href="<?=base_url()?>index.php/realestate/<?=$r['realestateid']?>">
									<img src="<?=$r['url'] ? base_url('images/thumbnails/'.$r['realestateid'].'/'.$r['url']) : base_url('images/noimage.jpg')?>" alt="Hình địa ốc" width="64"/>
								</a>
							</div>
							<div class="right-news">
								<div class="news-title">
									<a href="<?=base_url()?>index.php/realestate/<?=$r['realestateid']?>"><?=$r['title']?></a>
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