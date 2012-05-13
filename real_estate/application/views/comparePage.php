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
	<style type="text/css" media="screen">
		tbody tr:nth-child(even) td, tbody tr.even td {background:#e5ecf9;}
	</style>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
</head>
<body>
	<div class="container" style="padding-top: 0px;">
		<div class="main-content span-24 news_detail" style="padding-left: 20px;width: 930px;">
			<table>
				<tbody>
				<tr>
					<td style="width: 80px;"></td>
					<td style="width: 410px;"><div class="news_title"><?=$realEstateA['title']?></div></td>
					<td style="width: 410px;"><div class="news_title"><?=$realEstateB['title']?></div></td>
				</tr>
				<tr>
					<td class="title"><b>Giao dịch:</b></td>
					<td style="color: #FA7003;font-weight: bold;"><?=$realEstateA['transaction']?></td>
					<td style="color: #FA7003;font-weight: bold;"><?=$realEstateB['transaction']?></td>
				</tr>
				<tr>
					<td class="title"><b>Loại:</b></td>
					<td><a href="<?=base_url()?>index.php/realestate/view?cat=<?=$realEstateA['categoryid']?>"><?=$realEstateA['category']?></a></td>
					<td><a href="<?=base_url()?>index.php/realestate/view?cat=<?=$realEstateB['categoryid']?>"><?=$realEstateB['category']?></a></td>
				</tr>
				<tr>
					<td class="title"><b>Địa chỉ:</b></td>
					<td><?=$realEstateA['address']?></td>
					<td><?=$realEstateB['address']?></td>
				</tr>
				<tr>
					<td class="title">Diện tích:</td>
					<td><?=$realEstateA['area']?> m2</td>
					<td><?=$realEstateB['area']?> m2</td>
				</tr>
				<tr>
					<td class="title">Kích thước:</td>
					<td><?=$realEstateA['size']?></td>
					<td><?=$realEstateB['size']?></td>
				</tr>
				<tr>
					<td class="title">Giá:</td>
					<td class="price"><?=formatPrice($realEstateA['price']).$realEstateA['currency']?><?=($realEstateA['unit'])? ' / '.($realEstateA['unit']) : ''?></td>
					<td class="price"><?=formatPrice($realEstateB['price']).$realEstateB['currency']?><?=($realEstateB['unit'])? ' / '.($realEstateB['unit']) : ''?></td>
				</tr>
				<tr>
					<td class="title">Thông tin pháp lý:</td>
					<td><?=$realEstateA['legalstatus']?></td>
					<td><?=$realEstateB['legalstatus']?></td>
				</tr>
				<tr>
					<td class="title">Phương hướng:</td>
					<td><?=$realEstateA['direction']?></td>
					<td><?=$realEstateB['direction']?></td>
				</tr>
				<tr>
					<td class="title">Đường hẻm:</td>
					<td><?=$realEstateA['alley'] ? $realEstateA['alley'].' m' : ''?></td>
					<td><?=$realEstateB['alley'] ? $realEstateB['alley'].' m' : ''?></td>
				</tr>
				<tr>
					<td class="title">Chi tiết:</td>
					<td><?=$realEstateA['description']?></td>
					<td><?=$realEstateB['description']?></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>