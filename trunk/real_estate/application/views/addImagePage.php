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
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	var SUB_DIR = '2' + '/';
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
	})
	</script>
	<script src="<?=base_url()?>js/jquery.ui.widget.js" type="text/javascript"></script>
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
	<?=$topBar?>
	<div class="container">
		<div class="main-content span-24">
			<div class="breadcrumbs">
				<ul>
					<li class="crumb-first"><a href="<?=base_url()?>index.php"><img src="images/home.png" alt="Trang chủ" width="21"/></a></li>
					<li class="crumb-sub"><a href="<?=base_url()?>index.php/realestate">Quản lý tin BĐS</a></li>
					<li class="crumb-sub"><a href="<?=base_url()?>index.php/realestate">Tạo tin BĐS</a></li>
					<li class="crumb-last"><a href="<?=base_url()?>index.php/realestate">Thêm hình ảnh BĐS</a></li>
				</ul>
			</div>
			<div class="form_title">Hình ảnh BĐS</div>
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
			<div class="form_title"><button class="submit_btn">Hoàn tất</button></div>
		</div>
	</div>
</body>
</html>