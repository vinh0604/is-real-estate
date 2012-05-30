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
	<link rel="stylesheet" href="<?=base_url()?>css/validationEngine.jquery.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/image-form.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/bootstrap-image-gallery.min.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/jquery.fileupload-ui.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=base_url()?>css/redmond/jquery-ui-1.8.18.custom.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.validationEngine-vi.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	var SUB_DIR = '<?=$realEstate['realestateid']?>' + '/';
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#city').change(function(){
			$.getJSON('<?=base_url()?>index.php/realestate/getdistrictbycityid',
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
		$('#re_frm').validationEngine('attach');
		$('#map_marker').click(function(){
			window.open ("<?=base_url()?>public/mapMarkerPage.html","mymap",'width=840,height=600,toolbar=0,resizable=0');
		});
		$('#city').val('<?=$realEstate['cityid']?>');
		$('#district').val('<?=$realEstate['districtid']?>');
		$('[name="transaction"][value="<?=$realEstate['transaction']?>"]').attr('checked', 'checked');
		$('#category').val('<?=$realEstate['categoryid']?>');
		$('#currency').val('<?=$realEstate['currency']?>');
		$('#direction').val('<?=$realEstate['direction']?>');
		$('#legalstatus').val('<?=$realEstate['legalstatus']?>');
		
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
	<script src="<?=base_url()?>js/tmpl.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/load-image.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/canvas-to-blob.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/bootstrap-image-gallery.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.iframe-transport.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.fileupload.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.fileupload-ip.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.fileupload-ui.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/locale.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=base_url()?>js/main.js" type="text/javascript"></script>
</head>
<body>
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
					<li class="crumb-last"><a href="#">Sửa tin BĐS</a></li>
				</ul>
			</div>
			<div class="form_title">Thông tin BĐS</div>
			<?=validation_errors('<div class="error" style="width: 450px;margin: 4px auto;">','</div>');?>
			<div class="form_wrapper span-18">
				<form action="<?=base_url()?>index.php/realestate/updateitem" method="post" id="re_frm">
				<input type="hidden" name="realestateid" value="<?=$realEstate['realestateid']?>"/>
				<table>
					<tr>
						<td colspan="3" style="text-align: center">
							<label>(*): Các trường bắt buộc</label>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="title">Tiêu đề tin (*):</label></td>
						<td colspan="2"><input type="text" name="title" id="title" placeholder="Nhập tiêu đề..." class="validate[required]" value="<?=$realEstate['title']?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label>Loại giao dịch (*):</label></td>
						<td colspan="2">
							<input type="radio" name="transaction" id="transaction_0" value="Bán" checked class="validate[required]"/>
							<label for="transaction_0">Bán</label>
							<input type="radio" name="transaction" id="transaction_1" value="Thuê" class="validate[required]"/>
							<label for="transaction_1">Cho thuê</label>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="category">Loại BĐS (*):</label></td>
						<td colspan="2">
							<select name="category" id="category" class="validate[required]">
								<option value="">Chọn loại BĐS</option>
								<?php foreach($categories as $c):?>
								<option value="<?=$c->categoryid?>"><?=$c->name?></option>	
								<?php endforeach;?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="address">Địa chỉ (*):</label></td>
						<td colspan="2"><input type="text" name="address" id="address" placeholder="Nhập số nhà, đường, phường xã..." class="validate[required]" value="<?=$realEstate['address']?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"></td>
						<td style="width: 169px;">
							<select name="city" id="city" class="validate[required]">
								<option value="">Tỉnh / Thành phố</option>
								<?php foreach($cities as $c):?>
								<option value="<?=$c->cityid?>"><?=$c->name?></option>	
								<?php endforeach;?>
							</select>
						</td>
						<td>
							<select name="district" id="district">
								<option value="">Quận / Huyện</option>
								<?php foreach($districts as $d):?>
								<option value="<?=$d->districtid?>"><?=$d->name?></option>	
								<?php endforeach;?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="price">Giá (*):</label></td>
						<td style="width: 169px;">
							<input type="text" name="price" id="price" style="width: 78px;" class="validate[required,custom[number]]" value="<?=$realEstate['price']?>"/>
							<select name="currency" id="currency" style="width: 85px;">
								<option value="VND">triệu VNĐ</option>
								<option value="USD">USD</option>
								<option value="lượng">lượng</option>
								<option value="lượng">chỉ</option>
							</select>
						</td>
						<td>
							<label for="unit">Đơn vị tính:</label>
							<input type="text" name="unit" id="unit" style="width: 71px;"  value="<?=$realEstate['unit']?>"/>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="area">Diện tích (*):</label></td>
						<td colspan="2">
							<input type="text" name="area" id="area" style="width: 169px;"  class="validate[required,custom[number]]" value="<?=$realEstate['area']?>"/>
							<b>mét vuông</b>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="width">Kích thước:</label></td>
						<td style="width: 169px;">
							<input type="text" name="width" id="width" style="width: 142px;" placeholder="Nhập chiều rộng..." class="validate[optional,custom[number]]" value="<?=$realEstate['width']?>"/>
							<b>mét</b>
						</td>
						<td>
							<input type="text" name="length" id="length" style="width: 142px;" placeholder="Nhập chiều dài..." class="validate[optional,custom[number]]" value="<?=$realEstate['length']?>"/>
							<b>mét</b>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="direction">Phương hướng:</label></td>
						<td colspan="2">
							<select name="direction" id="direction">
								<option value="">Chọn hướng nhà</option>
								<option value="">Chọn hướng nhà</option>
								<option value="Đông">Đông</option>
								<option value="Tây">Tây</option>
								<option value="Nam">Nam</option>
								<option value="Bắc">Bắc</option>
								<option value="Đông Bắc">Đông Bắc</option>
								<option value="Tây Nam">Tây Nam</option>
								<option value="Đông Nam">Đông Nam</option>
								<option value="Tây Bắc">Tây Bắc</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="alley">Độ rộng lối vào:</label></td>
						<td colspan="2">
							<input type="text" name="alley" id="alley" class="validate[optional,custom[number]]" style="width: 142px;" value="<?=$realEstate['alley']?>"/>
							<b>mét</b>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="legal_status">Tình trạng pháp lý:</label></td>
						<td colspan="2">
							<select name="legalstatus" id="legalstatus">
								<option value="">Chọn Tình trạng pháp lý</option>
								<option value="Sổ đỏ">Sổ đỏ</option>
								<option value="Sổ hồng">Sổ hồng</option>
								<option value="Giấy tờ hợp lệ">Giấy tờ hợp lệ</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="description">Mô tả chi tiết:</label></td>
						<td colspan="2">
							<textarea name="description" id="description" placeholder="Thông tin về cơ sở vật chất, tiện nghi, phòng ốc..."/><?=$realEstate['description']?></textarea>
						</td>
					</tr>
					<tr>
						<td class="label_wrapper"></td>
						<td colspan="2">
							<a href="#" id="map_marker" class="popup_link">Nhấp vào để chọn vị trí bất động sản trên bản đồ</a>
						</td>
					</tr>
				</table>
				<input type="hidden" name="lat" id="lat" value="<?=$realEstate['lat']?>"/>
				<input type="hidden" name="lng" id="lng" value="<?=$realEstate['lng']?>"/>
				<div class="section_header">Thông tin liên hệ</div>
				<table>
					<tr>
						<td class="label_wrapper"><label for="contactname">Người liên hệ (*):</label></td>
						<td colspan="2"><input type="text" name="contactname" id="contactname" class="validate[required]" value="<?=$realEstate['contactname']?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="contacttel">Số điện thoại (*):</label></td>
						<td colspan="2"><input type="text" name="contacttel" id="contacttel" class="validate[required,custom[onlyNumber]]" value="<?=$realEstate['contacttel']?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="contactadd">Địa chỉ (*):</label></td>
						<td colspan="2"><input type="text" name="contactadd" id="contactadd" class="validate[required]" value="<?=$realEstate['contactadd']?>"/></td>
					</tr>
					<tr>
						<td class="label_wrapper"><label for="remark">Ghi chú:</label></td>
						<td colspan="2"><textarea name="remark" id="remark"><?=$realEstate['remark']?></textarea></td>
					</tr>
					<tr>
						<td colspan="3" style="text-align: center;"><input type="submit" value="Lưu thay đổi" class="submit_btn"/></td>
					</tr>
				</table>
				</form>
				<div class="section_header">Hình ảnh</div>
			</div>
			<div class="span-20" style="margin: 10px 0 0 80px;">
			<form id="fileupload" action="<?=base_url()?>index.php/imageupload" method="POST" enctype="multipart/form-data">
		        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
		        <div class="row fileupload-buttonbar">
		            <div class="span-12">
		                <!-- The fileinput-button span is used to style the file input field as button -->
		                <span class="btn btn-success fileinput-button" style="margin-top: 2px;">
		                    <i class="icon-plus icon-white"></i>
		                    <span>Chọn ảnh...</span>
		                    <input type="file" name="files[]" multiple>
		                </span>
		                <button type="submit" class="btn btn-primary start" style="margin-top: 2px;">
		                    <i class="icon-upload icon-white"></i>
		                    <span>Tải lên tất cả</span>
		                </button>
		                <button type="reset" class="btn btn-warning cancel" style="margin-top: 2px;">
		                    <i class="icon-ban-circle icon-white"></i>
		                    <span>Hủy tải lên</span>
		                </button>
		                <button type="button" class="btn btn-danger delete" style="margin-top: 2px;">
		                    <i class="icon-trash icon-white"></i>
		                    <span>Xóa</span>
		                </button>
		                <input type="checkbox" class="toggle">
		            </div>
		            <div class="span-8 last">
		                <!-- The global progress bar -->
		                <div class="progress progress-success progress-striped active fade">
		                    <div class="bar" style="width:0%;"></div>
		                </div>
		            </div>
		        </div>
		        <!-- The loading indicator is shown during image processing -->
		        <div class="fileupload-loading"></div>
		        <br>
		        <!-- The table listing the files available for upload/download -->
		        <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
		    </form>
		    <!-- modal-gallery is the modal dialog used for the image gallery -->
			<div id="modal-gallery" class="modal modal-gallery hide fade">
			    <div class="modal-header">
			        <a class="close" data-dismiss="modal">&times;</a>
			        <h3 class="modal-title"></h3>
			    </div>
			    <div class="modal-body"><div class="modal-image"></div></div>
			    <div class="modal-footer">
			        <a class="btn modal-download" target="_blank">
			            <i class="icon-download"></i>
			            <span>Tải xuống</span>
			        </a>
			        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
			            <i class="icon-play icon-white"></i>
			            <span>Slideshow</span>
			        </a>
			        <a class="btn btn-info modal-prev">
			            <i class="icon-arrow-left icon-white"></i>
			            <span>Trước</span>
			        </a>
			        <a class="btn btn-primary modal-next">
			            <span>Sau</span>
			            <i class="icon-arrow-right icon-white"></i>
			        </a>
			    </div>
			</div>
			<!-- The template to display files available for upload -->
			<script id="template-upload" type="text/x-tmpl">
			{% for (var i=0, file; file=o.files[i]; i++) { %}
			    <tr class="template-upload fade">
			        <td class="preview"><span class="fade"></span></td>
			        <td class="name"><span>{%=file.name%}</span></td>
			        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			        {% if (file.error) { %}
			            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
			        {% } else if (o.files.valid && !i) { %}
			            <td>
			                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
			            </td>
			            <td class="start">{% if (!o.options.autoUpload) { %}
			                <button class="btn btn-primary">
			                    <i class="icon-upload icon-white"></i>
			                    <span>{%=locale.fileupload.start%}</span>
			                </button>
			            {% } %}</td>
			        {% } else { %}
			            <td colspan="2"></td>
			        {% } %}
			        <td class="cancel">{% if (!i) { %}
			            <button class="btn btn-warning">
			                <i class="icon-ban-circle icon-white"></i>
			                <span>{%=locale.fileupload.cancel%}</span>
			            </button>
			        {% } %}</td>
			    </tr>
			{% } %}
			</script>
			<!-- The template to display files available for download -->
			<script id="template-download" type="text/x-tmpl">
			{% for (var i=0, file; file=o.files[i]; i++) { %}
			    <tr class="template-download fade">
			        {% if (file.error) { %}
			            <td></td>
			            <td class="name"><span>{%=file.name%}</span></td>
			            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
			        {% } else { %}
			            <td class="preview">{% if (file.thumbnail_url) { %}
			                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
			            {% } %}</td>
			            <td class="name">
			                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
			            </td>
			            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			            <td colspan="2"></td>
			        {% } %}
			        <td class="delete">
			            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
			                <i class="icon-trash icon-white"></i>
			                <span>{%=locale.fileupload.destroy%}</span>
			            </button>
			            <input type="checkbox" name="delete" value="1">
			        </td>
			    </tr>
			{% } %}
			</script>
			</div>
		</div>
	</div>
</body>
</html>