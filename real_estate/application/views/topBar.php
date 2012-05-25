<div id="top-bar" class="span-24">
	<ul id="top-menu" class="span-24">
		<li class="company-name"><a href="<?=base_url()?>index.php">RE2Y</a></li>
		<li class="top-menu-item dropdown">
			<a href="#">Thông tin nhà đất</a>
			<ul class="sub-menu">
				<li><a href="<?=base_url()?>index.php/realestate/view?trans=Bán">Nhà đất bán</a></li>
				<li><a href="<?=base_url()?>index.php/realestate/view?trans=Thuê">Nhà đất cho thuê</a></li>
			</ul>
		</li>
		<li class="top-menu-item dropdown">
			<a href="<?=base_url()?>index.php/search">Tìm kiếm</a>
			<ul class="sub-menu">
				<li><a href="<?=base_url()?>index.php/search">Tìm kiếm cơ bản</a></li>
				<li><a href="<?=base_url()?>index.php/search/advanced">Tìm kiếm nâng cao</a></li>
			</ul>
		</li>
		<li class="top-menu-item"><a href="<?=base_url()?>index.php">Liên hệ</a></li>
                <?php if (array_key_exists('user_id', $userdata)):?>
		<li class="top-menu-item dropdown">
			<a href="">Quản lý</a>
			<ul class="sub-menu">
				<li><a href="<?=base_url()?>index.php/realestate/manage">Quản lý tin</a></li>
				<?php if (array_key_exists('is_admin', $userdata) && $userdata['is_admin']):?>
				<li><a href="<?=base_url()?>index.php/realestate/review">Duyệt tin</a></li>
				<li><a href="<?=base_url()?>index.php/user">Quản lý tài khoản</a></li>
				<?php endif;?>
			</ul>
		</li>
                <?php endif;?>
	</ul>
	<span id="top-right-area">
		<a href="<?=base_url()?>index.php/cart" class="cart_btn">
			<span id="cart_item_num" class="cart_item_num"><?=array_key_exists('cart',$userdata) ? count($userdata['cart']) : 0 ?></span>
			<span class="cart_img_holder">Giỏ tin</span>
		</a>
		<ul class="login_signup_wrap">
			<?php if (array_key_exists('user_id',$userdata) && $userdata['user_id']): ?>
			<li class="blue_btn" style="float: left">
				<a href="<?=base_url()?>index.php/user/change" class="left_btn">Tài khoản</a>
			</li>
			<li class="blue_btn">
				<a href="<?=base_url()?>index.php/logout" class="right_btn">Đăng xuất
					<div class="right_arrow"></div>
				</a>
			</li>
			<?php else: ?>
			<li class="blue_btn" style="float: left">
				<a href="<?=base_url()?>index.php/login" class="left_btn">Đăng nhập</a>
			</li>
			<li class="blue_btn">
				<a href="<?=base_url()?>index.php/register" class="right_btn">Đăng ký
					<div class="right_arrow"></div>
				</a>
			</li>
			<?php endif;?>
		</ul>
	</span>
</div>
