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
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
	<link rel="stylesheet" href="<?=base_url()?>css/pagination.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.pagination.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	var map;
	function pageselectCallback(){
        return false;
    }
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		var myOptions = {
          center: new google.maps.LatLng(10.75, 106.67),
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
        $('#pagination').pagination(100, {callback: pageselectCallback, 
        										    prev_text: '&lt',
        										    next_text: '&gt',
        										    num_display_entries: 3,
        										    num_edge_entries: 1,
        										    items_per_page: 10});
	})
	</script>
	<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDS5bb-pXbt4N27kkA9y1AS0nGxgciqTiU&sensor=true&language=vi">
    </script>
    
</head>
<body>
	<?=$topBar?>
	<div class="container">
		<div class="span-24 search-area-wrap">
			<div class="left-side span-6">
				<div class="search-frm-wrap module-wrap">
					<div class="caption-area">
						Tìm kiếm bất động sản
					</div>
					<form action="#" method="get" id="search_frm">
					  	<table>
					  		<tr>
					  			<td> 
					  				<input type="text" name="k" id="keyword" placeholder="Nhập từ khóa..."/>
					  			</td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<select name="city" id="city">
										<option value="0">Tỉnh/Thành phố</option>
									</select>
					  			</td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<select name="district" id="district">
										<option value="0">Quận/ Huyện</option>
									</select>
					  			</td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<input type="submit" class="submit_btn" value="Tìm kiếm"/>
					  			</td>
					  		</tr>
					  	</table>
					</form>
				</div>
				<div class="module-wrap">
					<div class="caption-area">
						Kết quả tìm kiếm
					</div>
					<div class="result-wrap">
						<ul>
							<li>
								<div class="news-wrap">
									<div class="left-news">
										<a href="<?=base_url()?>index.php/realestate">
											<img src="<?=base_url()?>images/thumbnails/1.jpg" alt="Hình địa ốc" width="64"/>
										</a>
									</div>
									<div class="right-news">
										<div class="news-title">
											<a href="<?=base_url()?>index.php/realestate">Bán biệt thự tại Thủ Đức</a>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="nav-wrap">
						<div id="pagination" class="pagination"></div>
					</div>
				</div>
			</div>
			<div class="right-side span-18 last">
				<div id="map_canvas" style="width: 100%; height: 710px;"></div>
			</div>
		</div>
	</div>
</body>
</html>