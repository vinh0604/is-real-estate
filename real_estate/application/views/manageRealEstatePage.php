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
	<link rel="stylesheet" href="<?=base_url()?>css/demo_table_jui.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/redmond/jquery-ui-1.8.18.custom.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#account_table').dataTable({
			"bJQueryUI": true,
			"aoColumns": [{"bSortable": false,"bSearchable": false,"sWidth" :"40px"},
						  {"bSortable": false,"bSearchable": false,"sWidth" :"30px"},
						  null,
						  null,
						  null,
						  null,
						  {"bSortable": false,"bSearchable": false,"sWidth" :"30px"}]
		});
		$('#ck_all').click(function() {
			var checked_status = this.checked;
			$("input[name='a_id[]']").each(function()
			{
				this.checked = checked_status;
			});
		});
		$("input[name='a_id[]']").click(function() {
			$('#ck_all').attr('checked', false);
			var flag = true;
			if (this.checked) {
				$("input[name='a_id[]']").each(function()
				{
					if (!this.checked) {
						flag = false;
						return flag;
					}
				});
				if (flag) {
					$('#ck_all').attr('checked', true);
				}
			}
		});
		$('.edit_btn').hover(function(){
			$(this).children('img').attr('src','<?=base_url()?>images/edit_hover.png');
		}, function(){
			$(this).children('img').attr('src','<?=base_url()?>images/edit.png');
		});
		$('#confirm_view').dialog({ buttons:[
			    {text: "Có",click: function() { } },
			    {text: "Không",click: function() { $(this).dialog("close"); } }
			],
			autoOpen: false,
			modal: true,
			resizable: false,
			draggable: false
		});
		$('#notice_view').dialog({ buttons:[
			    {text: "Đóng",click: function() { $(this).dialog("close"); } }
			],
			autoOpen: false,
			modal: true,
			resizable: false,
			draggable: false
		});
		
		$('#del_btn').click(function() {
			var not_checked = true;
			$("input[name='a_id[]']").each(function()
			{
				if (this.checked) {
					not_checked = false;
					return not_checked;
				}
			});
			if (not_checked) {
				$('#notice_view').dialog('open');
			} else {
				$('#confirm_view').dialog('open');
			}
		});
	})
	</script>
</head>
<body>
	<div id="confirm_view" title="Quản lý tin BĐS" style="display: none;">
		<p>Bạn có chắc muốn xóa (những) tin được chọn?</p>
	</div>
	<div id="notice_view" title="Quản lý tin BĐS" style="display: none;">
		<p>Không có tin nào được chọn!</p>
	</div>
	<?=$topBar?>
	<div class="container">
		<div class="main-content span-24">
			<div class="breadcrumbs">
				<ul>
					<li class="crumb-first"><a href="<?=base_url()?>index.php"><img src="<?=base_url()?>images/home.png" alt="Trang chủ" width="21"/></a></li>
					<li class="crumb-last"><a href="<?=base_url()?>index.php/realestate/">Quản lý tin BĐS</a></li>
				</ul>
			</div>
			<div style="margin: 0 auto;width: 870px;">
				<div class="btn_wrap">
					<button class="del_btn" id="del_btn"><img src="<?=base_url()?>images/trash.png" />Xóa tin BĐS</button>
					<button class="add_btn" id="add_btn"><img src="<?=base_url()?>images/plus.png" />Viết tin mới</button>
				</div>
				<div class="table_wrap">
					<table border="0" cellspacing="0" cellpadding="0" id="account_table" class="display">
						<thead>
							<tr>
								<th class="fixed_column">STT</th>
								<th class="fixed_column"><input type="checkbox" name="c_all" id="ck_all" /></th>
								<th>Tiêu đề</th>
								<th>Ngày đăng</th>
								<th>Loại giao dịch</th>
								<th>Loại BĐS</th>
								<th class="fixed_column"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td><input type="checkbox" name="a_id[]" value="1"/></td>
								<td>Bán biệt thự tại Thủ Đức</td>
								<td>2012-04-26</td>
								<td>Cần bán</td>
								<td>Biệt thự</td>
								<td><a href="#" class="edit_btn"><img src="<?=base_url()?>images/edit.png" height="24" width="24" title="Chỉnh sửa tin BĐS"/></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>