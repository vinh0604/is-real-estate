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
		reTable = $('#account_table').dataTable({
						"bJQueryUI": true,
						"aoColumns": [{"bSortable": false,"bSearchable": false,"sWidth" :"40px"},
									  {"bSortable": false,"bSearchable": false,"sWidth" :"30px"},
									  {"sWidth" :"200px"},
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
		$('#confirm_view').dialog({ buttons:[
			    {text: "Có",click: function() { $('#re_frm').submit();} },
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
		$('#notice_view_1').dialog({ buttons:[
			    {text: "Đóng",click: function() { $(this).dialog("close"); } }
			],
			autoOpen: false,
			modal: true,
			resizable: false,
			draggable: false
		});
		$('#notice_view_2').dialog({ buttons:[
			    {text: "Đóng",click: function() { $(this).dialog("close"); } }
			],
			autoOpen: false,
			modal: true,
			resizable: false,
			draggable: false
		});
		
		$('#compare_btn').click(function(){
			var count = $("input[name='a_id[]']:checked").length;
			if (count < 2) {
				$('#notice_view_1').dialog('open');
			} else if (count > 2) {
				$('#notice_view_2').dialog('open');
			} else {
				var url = '<?=base_url()?>index.php/cart/compare';
				$("input[name='a_id[]']:checked").each(function()
				{
					url += '/' + $(this).val();
				});
				window.open(url,'So sánh bất động sản',"resizable=1,width=900,height=375");
			}
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
		<?php if($this->session->flashdata('notice')):?>
		$('#success_view').dialog({ buttons:[
			    {text: "Đóng",click: function() { $(this).dialog("close"); } }
			],
			modal: true,
			resizable: false,
			draggable: false
		});
		<?php endif;?>
	})
	</script>
</head>
<body>
	<div id="confirm_view" title="Quản lý tin BĐS" style="display: none;">
		<p>Bạn có chắc muốn xóa khỏi giỏ (những) tin được chọn?</p>
	</div>
	<div id="notice_view" title="Quản lý tin BĐS" style="display: none;">
		<p>Không có tin nào được chọn!</p>
	</div>
	<div id="notice_view_1" title="Quản lý tin BĐS" style="display: none;">
		<p>Vui lòng chọn đủ 2 tin bất động sản!</p>
	</div>
	<div id="notice_view_2" title="Quản lý tin BĐS" style="display: none;">
		<p>Chỉ được phép chọn 2 tin để thực hiện so sánh!</p>
	</div>
	<div id="success_view" title="Quản lý tin BĐS" style="display: none;">
		<p><?=$this->session->flashdata('notice')?></p>
	</div>
	<?=$topBar?>
	<div class="container">
		<div class="main-content span-24">
			<div class="breadcrumbs">
				<ul>
					<li class="crumb-first"><a href="<?=base_url()?>index.php"><img src="<?=base_url()?>images/home.png" alt="Trang chủ" width="21"/></a></li>
					<li class="crumb-last"><a href="#">Giỏ tin</a></li>
				</ul>
			</div>
			<div style="margin: 0 auto;width: 870px;">
				<div class="btn_wrap" style="width:210px">
					<button class="add_btn" id="compare_btn" style="float: left;"><img src="<?=base_url()?>images/compare.png" width="15"/>So sánh</button>
					<button class="del_btn" id="del_btn" style="float: right;"><img src="<?=base_url()?>images/trash.png" width="12"/>Bỏ khỏi giỏ tin</button>
				</div>
				<div class="table_wrap">
					<form action="<?=base_url()?>index.php/cart/deleteitem" method="post" id="re_frm">
					<table border="0" cellspacing="0" cellpadding="0" id="account_table" class="display">
						<thead>
							<tr>
								<th class="fixed_column">STT</th>
								<th class="fixed_column"><input type="checkbox" name="c_all" id="ck_all" /></th>
								<th>Tiêu đề</th>
								<th>Người đăng</th>
								<th>Ngày đăng</th>
								<th>Loại giao dịch</th>
								<th>Loại BĐS</th>
								<th class="fixed_column"></th>
							</tr>
						</thead>
						<tbody>
							<?php $index = 1?>
							<?php foreach($realEstates as $r):?>
							<tr>
								<td><?=$index++?></td>
								<td><input type="checkbox" name="a_id[]" value="<?=$r['realestateid']?>"/></td>
								<td><?=$r['title']?></td>
								<td><?=$r['user']?></td>
								<td><?=$r['date']?></td>
								<td><?=$r['transaction']?></td>
								<td><?=$r['category']?></td>
								<td><a href="<?=base_url()?>index.php/realestate/index/<?=$r['realestateid']?>" class="edit_btn"><img src="<?=base_url()?>images/view_detail.png" height="24" width="24" title="Chi tiết tin BĐS"/></td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>