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
	<link rel="stylesheet" href="<?=base_url()?>css/jqdialog.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.pagination.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jqdialog.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>js/jquery.cart.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	var url = '<?=base_url()?>index.php/realestate/view?';
	var TRANS = '<?=$transaction?>';
	var CAT = '<?=$categoryId?>';
	var trans_param = 'trans=' + TRANS;
	function pageselectCallback(index,jq){
        $.get('<?=base_url()?>index.php/realestate/updateview',
        	{cat: CAT, trans: TRANS, page: index},
        	function(data) {
        		$('#content').html(data);
        	});
    }
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#city').change(function(){
			$.getJSON('<?=base_url()?>index.php/realestate/getdistrict',
					 {id: $('#city').val()},
					 function(districts) {
					 	var htmlDistrict = ['<option value="">Quận/ Huyện</option>'];
					 	console.log(districts);
					 	for(i in districts) {
					 		htmlDistrict.push(''.concat('<option value="',districts[i].districtid,'">',districts[i].name,'</option>'));
					 	}
					 	$('#district').html(htmlDistrict.join(''));
					 });
		});
		$('#category').val('<?=$categoryId?>');
		$('#category').change(function(){
			var cat_param = 'cat=' + $('#category').val();
			window.location.href = url.concat(trans_param,'&',cat_param);
		});
		$('.add_cart_btn').spCart('<?=base_url()?>index.php/cart/add');
		<?php if($count):?>
		$('#pagination').pagination(<?=$count?>, {callback: pageselectCallback, 
        										    prev_text: '&lt',
        										    next_text: '&gt',
        										    num_display_entries: 5,
        										    num_edge_entries: 2,
        										    items_per_page: 10});
        <?php endif;?>
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
								<select name="city" id="city" style="width:250px;">
									<option value="">Tỉnh/Thành phố</option>
									<?php foreach($cities as $c):?>
									<option value="<?=$c->cityid?>"><?=$c->name?></option>
									<?php endforeach;?>
								</select>
							</td>
							<td style="width: 145px;">
								<select name="district" id="district">
									<option value="">Quận/ Huyện</option>
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
				<select name="category" id="category">
					<option value="">Tất cả</option>
					<?php foreach($categories as $c):?>
					<option value="<?=$c->categoryid?>"><?=$c->name?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div id="content" class="list-wrapper span-24">
				<?=$content?>
			</div>
		</div>
		<div class="nav-wrap span-24" style="margin-top: 30px;">
			<div id="pagination" class="pagination"></div>
		</div>
	</div>
</body>
</html>