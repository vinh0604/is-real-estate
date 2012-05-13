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
	<link rel="stylesheet" href="<?=base_url()?>css/validationEngine.jquery.css" type="text/css" media="screen"/>
	
	<script src="<?=base_url()?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.validationEngine.js" type="text/javascript"></script>
	<script src="<?=base_url()?>js/jquery.validationEngine-vi.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('.dropdown').hover(function() {
			$(this).children('.sub-menu').slideDown(200);
		}, function() {
			$(this).children('.sub-menu').hide();
		});
		$('#signin_frm').validationEngine('attach');
	})
	</script>
</head>
<body>
	<?=$topBar?>
	<div class="container">
		<div class="signin-container" style="margin-top: 20%;">
			<div class="form-title">
				Đăng nhập
			</div>
			<?php if ($this->session->flashdata('error')):?>
			<div class="error" style="text-align: center;">
				<?=$this->session->flashdata('error')?>
			</div>
			<?php endif;?>
			<form action="<?=base_url()?>index.php/login/submitlogin" method="post" id="signin_frm">
				<table>
					<tr>
						<td class="label_holder"><label for="username">Tên đăng nhập:</label></td>
						<td><input type="text" name="username" id="username" class="validate[required,custom[noSpecialCaracters]]"/></td>
					</tr>
					<tr>
						<td class="label_holder"><label for="password">Mật khẩu:</label></td>
						<td><input type="password" name="password" id="password" class="validate[required]"/></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="checkbox" name="save_login" id="save_login" />
							<label for="save_login">Duy trì đăng nhập?</label>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: right;">
							<input type="submit" class="submit_btn" value="Đăng nhập"/>
							<a href="#">Quên mật khẩu?</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>