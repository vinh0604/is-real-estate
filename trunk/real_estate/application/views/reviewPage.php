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
						"aaSorting": [[3,'desc']],
						"aoColumns": [{"mDataProp" : function(row,eType) { return '<input type="checkbox" name="a_id[]" value="' + row.realestateid + '"/>';},"bSortable": false,"bSearchable": false,"sWidth" :"30px"},
									  {"mDataProp" : "title","sWidth" :"200px"},
									  {"mDataProp" : function(row,eType) {return '<a href="<?=base_url()?>index.php/user/' + row.userid + '">' + row.username + '</a>';}},
									  {"mDataProp" : "date"},
									  {"mDataProp" : "transaction"},
									  {"mDataProp" : "category"},
									  {"mDataProp" : function(row,eType) {return '<a href="<?=base_url()?>index.php/realestate/getdetailforreview/' + row.realestateid + '" class="edit_btn"><img src="<?=base_url()?>images/view_detail.png" height="24" width="24" title="Chỉnh sửa tin BĐS"/>';},"bSortable": false,"bSearchable": false,"sWidth" :"30px"}],
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": "<?=base_url()?>index.php/realestate/updatedatareview",
						"fnServerData": function ( sSource, aoData, fnCallback ) {
							$.getJSON(sSource, aoData, function(json) {
								$('#ck_all').attr('checked',false);
								fnCallback(json);
							});
						}
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
		$('#accept_view').dialog({ buttons:[
			    {text: "Có",click: function() { 
			    						var aIDs = [];
			    						$("input[name='a_id[]']:checked").each(function(){
			    							aIDs.push($(this).val());
			    						});
			    						$('.re_ids').val(JSON.stringify(aIDs));
			    						$('#accept_frm').submit();
			    					} 
			    },
			    {text: "Không",click: function() { $(this).dialog("close"); } }
			],
			autoOpen: false,
			modal: true,
			resizable: false,
			draggable: false
		});
		$('#reject_view').dialog({ buttons:[
			    {text: "Có",click: function() { $('#reason_view').dialog('open');$(this).dialog("close");} },
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
		$('#reason_view').dialog({ buttons:[
			    {text: "Xác nhận",click: function() { 
			    								var aIDs = [];
					    						$("input[name='a_id[]']:checked").each(function(){
					    							aIDs.push($(this).val());
					    						});
					    						$('.re_ids').val(JSON.stringify(aIDs));
					    						$('#reason_field').val($('#reason').val());
					    						$('#deny_frm').submit();
			    							}
			    },
			    {text: "Hủy",click: function() { $(this).dialog("close"); } }
			],
			autoOpen: false,
			modal: true,
			resizable: false,
			draggable: false
		});
		
		$('#accept_btn').click(function() {
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
				$('#accept_view').dialog('open');
			}
		});
		$('#reject_btn').click(function() {
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
				$('#reject_view').dialog('open');
			}
		});
		$('.edit_btn').live('click',function(e) {
			window.open($(this).attr('href'),'Thông tin bất động sản',"resizable=1,width=1000,height=675");
			e.preventDefault();
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
	<form action="<?=base_url()?>index.php/realestate/accept" method="post" id="accept_frm">
		<input type="hidden" name="ids" class="re_ids"/>
	</form>
	<form action="<?=base_url()?>index.php/realestate/deny" method="post" id="deny_frm">
		<input type="hidden" name="ids" class="re_ids"/>
		<input type="hidden" name="reason" id="reason_field"/>
	</form>
	<div id="accept_view" title="Quản lý tin BĐS" style="display: none;">
		<p>Bạn có chắc muốn đồng ý đăng (những) tin được chọn?</p>
	</div>
	<div id="reject_view" title="Quản lý tin BĐS" style="display: none;">
		<p>Bạn có chắc muốn từ chối đăng (những) tin được chọn?</p>
	</div>
	<div id="notice_view" title="Quản lý tin BĐS" style="display: none;">
		<p>Không có tin nào được chọn!</p>
	</div>
	<div id="reason_view" title="Quản lý tin BĐS" style="display: none;">
		<div><label>Lý do từ chối đăng tin:</label></div>
		<textarea name="reason" id="reason" style="width: 265px;height: 175px;"></textarea>
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
					<li class="crumb-sub"><a href="<?=base_url()?>index.php/realestate/manage">Quản lý tin BĐS</a></li>
					<li class="crumb-last"><a href="#">Duyệt tin BĐS</a></li>
				</ul>
			</div>
			<div style="margin: 0 auto;width: 870px;">
				<div class="btn_wrap" style="width:280px">
					<button class="add_btn" id="accept_btn" style="float: left;"><img src="<?=base_url()?>images/check.gif" width="12"/>Chấp nhận đăng tin</button>
					<button class="del_btn" id="reject_btn" style="float: right;"><img src="<?=base_url()?>images/cancel.gif" width="12"/>Từ chối đăng tin</button>
				</div>
				<div class="table_wrap">
					<table border="0" cellspacing="0" cellpadding="0" id="account_table" class="display">
						<thead>
							<tr>
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
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>