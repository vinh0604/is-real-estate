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
			<div class="module-wrap advance-search-wrap">
					<div class="caption-area">
						Tìm kiếm nâng cao
					</div>
					<form action="<?=base_url()?>index.php/search/advanced" method="post" id="search_frm">
					  	<table class="top-table">
					  		<tr>
					  			<td colspan="2"> 
					  				<input type="text" name="k" id="keyword" placeholder="Nhập từ khóa..."/>
					  			</td>
					  			<td colspan="2">
					  				<select name="city" id="city">
										<option value="0">Tỉnh/Thành phố</option>
									</select>
					  			</td>
					  			<td colspan="2">
					  				<select name="district" id="district">
										<option value="0">Quận/ Huyện</option>
									</select>
					  			</td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<select name="transaction" id="transaction">
										<option value="0">Loại giao dịch</option>
									</select>
					  			</td>
					  			<td>
					  				<select name="re_type" id="re_type">
										<option value="0">Loại bất động sản</option>
									</select>
					  			</td>
					  			<td>
					  				<label for="area">Diện tích: </label>
					  			</td>
					  			<td>
					  				<select name="area" id="area">
										<option value="0">Tất cả</option>
									</select>
					  			</td>
					  			<td>
					  				<label for="direction">Phương hướng: </label>
					  			</td>
					  			<td>
					  				<select name="direction" id="direction">
										<option value="0">Tất cả</option>
									</select>
					  			</td>
					  		</tr>
					  		<tr>
					  			<td style="width: 108px;">
					  				<label for="start_price">Giá từ: </label>
					  			</td>
					  			<td style="width: 130px;">
					  				<input type="text" name="start_price" id="start_price" />
					  			</td>
					  			<td style="width: 50px;">
					  				<label for="end_price">Giá đến: </label>
					  			</td>
					  			<td style="width: 130px;">
					  				<input type="text" name="end_price" id="end_price" />
					  			</td>
					  			<td style="width: 92px;">
					  				<label for="unit">Đơn vị tính: </label>
					  			</td>
					  			<td style="width: 120px;">
					  				<select name="unit" id="unit">
										<option value="0">Chọn đơn vị tính</option>
									</select>
					  			</td>
					  		</tr>
					  	</table>
					  	<table class="low-table">
					  		<tr>
					  			<td style="width: 125px;">
					  				<input type="checkbox" name="hospital" id="hospital" />
					  				<label for="hospital">Cách bệnh viện </label>
					  			</td>
					  			<td style="width: 100px;">
					  				<input type="text" name="hospital_distance" id="hospital_distance" />
					  			</td>
					  			<td><label for=""> mét</label></td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<input type="checkbox" name="school" id="school" />
					  				<label for="school">Cách trường học </label>
					  			</td>
					  			<td>
					  				<input type="text" name="school_distance" id="school_distance" />
					  			</td>
					  			<td><label for=""> mét</label></td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<input type="checkbox" name="market" id="market" />
					  				<label for="market">Cách chợ/ siêu thị </label>
					  			</td>
					  			<td>
					  				<input type="text" name="market_distance" id="market_distance" />
					  			</td>
					  			<td><label for=""> mét</label></td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<input type="checkbox" name="street" id="street" />
					  				<label for="street">Cách đường </label>
					  			</td>
					  			<td colspan="2">
					  				<input type="text" name="street_name" id="street_name" placeholder="Tên đường..."/>
					  			</td>
					  			<td style="width: 50px;">
					  				<label for="street_distance">Phạm vi </label>
					  			</td>
					  			<td style="width: 100px;">
					  				<input type="text" name="street_distance" id="street_distance" />
					  			</td>
					  			<td><label for=""> mét</label></td>
					  		</tr>
					  		<tr>
					  			<td>
					  				<input type="submit" class="submit_btn" value="Tìm kiếm"/>
					  			</td>
					  		</tr>
					  	</table>
					</form>
				</div>
			<div class="left-side span-6">
				<div class="module-wrap">
					<div class="caption-area">
						Kết quả tìm kiếm
					</div>
					<div class="result-wrap">
						<ul>
							<li>
								<div class="news-wrap">
									<div class="left-news">
										<a href="#">
											<img src="<?=base_url()?>images/home.jpg" alt="Hình địa ốc" width="64"/>
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
				<div id="map_canvas" style="width: 100%; height: 550px;"></div>
			</div>
		</div>
	</div>
</body>
</html>
