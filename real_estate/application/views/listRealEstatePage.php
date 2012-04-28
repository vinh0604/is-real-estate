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
	<link rel="stylesheet" href="<?=base_url()?>css/pagination.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.pagination.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	function pageselectCallback(){
        return false;
    }
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#pagination').pagination(562, {callback: pageselectCallback, 
        										    prev_text: '&lt',
        										    next_text: '&gt',
        										    num_display_entries: 5,
        										    num_edge_entries: 1,
        										    items_per_page: 10});
	})
	</script>
</head>
<body>
	<?=$topBar?>
	<div class="container">
		<div class="left-container span-24">
			<div id="search-area" class="main-area span-14">
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
		</div>
		<div class="main-wrapper span-24">
			<div class="filter-wrapper span-22">
				<span>Loại bất động sản: </span> 
				<select name="re_type" id="re_type">
					<option value="0">Tất cả</option>
				</select>
			</div>
			<div class="list-wrapper span-24">
				<div class="list-row span-24">
					<div class="left-news span-12">
						<table>
							<tr>
								<td class="news-image-wrap">
									<a href="<?=base_url()?>index.php/realestate"><img src="<?=base_url()?>images/thumbnails/1.jpg" alt="Hình bất động sản" width="132"/></a>
									<div class="news-operation">
										<span class="blue_btn" style="float: left;">
											<a href="#" class="left_btn" title="Thêm vào giỏ tin">
												<div class="shopping_cart"></div>
											</a>
										</span>
										<span class="blue_btn">
											<a href="<?=base_url()?>index.php/realestate" class="right_btn">Xem thêm
											</a>
										</span>
									</div>
								</td>
								<td class="news-detail-wrap">
									<div class="news-title"><a href="<?=base_url()?>index.php/realestate">Bán biệt thự ở Thủ Đức</a></div>
									<div>
										<b>Địa chỉ: </b>108/7, đường 11, phường Linh Xuân, quận Thủ Đức, TP Hồ Chí Minh
									</div>
									<div>
										<table>
											<tr>
												<td>
													<b>Giao dịch: </b>Cho thuê
												</td>
												<td>
													<b>Loại BĐS: </b> Biệt thự
												</td>
											</tr>
										</table>
									</div>
									<div>
										<table>
											<tr>
												<td>
													<b>Kích thước: </b> 20m x 15m
												</td>
												<td>
													<b>Diện tích: </b> 300 m2
												</td>
											</tr>
										</table>
									</div>
									<div>
										<b>Giá: </b> <span class="price_tag">15,000,000 VND/m2</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="nav-wrap span-24" style="margin-top: 30px;">
			<div id="pagination" class="pagination"></div>
		</div>
	</div>
</body>
</html>