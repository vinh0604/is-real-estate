<?php
	$count = count($realEstates);
	$remain = $count % 2; 
	$i = 0;
?>
<?php for(;$i<($count - $remain);$i+=2):?>
<div class="list-row span-24">
	<div class="left-news span-12">
		<table>
			<tr>
				<td class="news-image-wrap">
					<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i]['realestateid']?>">
						<img src="<?=base_url()?>images/files/<?=$realEstates[$i]['realestateid']?>/<?=$realEstates[$i]['url']?>" alt="Hình bất động sản" width="132"/>
					</a>
					<div class="news-operation">
						<span class="blue_btn" style="float: left;">
							<a href="#" class="left_btn" title="Thêm vào giỏ tin">
								<div class="shopping_cart"></div>
							</a>
						</span>
						<span class="blue_btn">
							<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i]['realestateid']?>" class="right_btn">Xem thêm
							</a>
						</span>
					</div>
				</td>
				<td class="news-detail-wrap">
					<div class="news-title">
						<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i]['realestateid']?>"><?=$realEstates[$i]['title']?></a>
					</div>
					<div>
						<b>Địa chỉ: </b><?=$realEstates[$i]['address']?>
					</div>
					<div>
						<table>
							<tr>
								<td>
									<b>Giao dịch: </b><?=$realEstates[$i]['transaction']?>
								</td>
								<td>
									<b>Loại BĐS: </b> <?=$realEstates[$i]['category']?>
								</td>
							</tr>
						</table>
					</div>
					<div>
						<table>
							<tr>
								<td>
									<b>Kích thước: </b> <?=$realEstates[$i]['size']?>
								</td>
								<td>
									<b>Diện tích: </b> <?=$realEstates[$i]['area']?> m2
								</td>
							</tr>
						</table>
					</div>
					<div>
						<b>Giá: </b> <span class="price_tag"><?=formatPrice($realEstates[$i]['price']).$realEstates[$i]['currency']?><?=($realEstates[$i]['unit'])? ' / '.($realEstates[$i]['unit']) : ''?></span>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div class="right-news span-12 last">
		<table>
			<tr>
				<td class="news-image-wrap">
					<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i+1]['realestateid']?>">
						<img src="<?=base_url()?>images/files/<?=$realEstates[$i+1]['realestateid']?>/<?=$realEstates[$i+1]['url']?>" alt="Hình bất động sản" width="132"/>
					</a>
					<div class="news-operation">
						<span class="blue_btn" style="float: left;">
							<a href="#" class="left_btn" title="Thêm vào giỏ tin">
								<div class="shopping_cart"></div>
							</a>
						</span>
						<span class="blue_btn">
							<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i+1]['realestateid']?>" class="right_btn">Xem thêm
							</a>
						</span>
					</div>
				</td>
				<td class="news-detail-wrap">
					<div class="news-title">
						<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i+1]['realestateid']?>"><?=$realEstates[$i+1]['title']?></a>
					</div>
					<div>
						<b>Địa chỉ: </b><?=$realEstates[$i+1]['address']?>
					</div>
					<div>
						<table>
							<tr>
								<td>
									<b>Giao dịch: </b><?=$realEstates[$i+1]['transaction']?>
								</td>
								<td>
									<b>Loại BĐS: </b> <?=$realEstates[$i+1]['category']?>
								</td>
							</tr>
						</table>
					</div>
					<div>
						<table>
							<tr>
								<td>
									<b>Kích thước: </b> <?=$realEstates[$i+1]['size']?>
								</td>
								<td>
									<b>Diện tích: </b> <?=$realEstates[$i+1]['area']?> m2
								</td>
							</tr>
						</table>
					</div>
					<div>
						<b>Giá: </b> <span class="price_tag"><?=formatPrice($realEstates[$i+1]['price']).' '.$realEstates[$i+1]['currency']?><?=($realEstates[$i+1]['unit'])? ' / '.($realEstates[$i+1]['unit']) : ''?></span>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php endfor;?>
<?php if($remain):?>
<div class="list-row span-24">
	<div class="left-news span-12">
		<table>
			<tr>
				<td class="news-image-wrap">
					<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i]['realestateid']?>">
						<img src="<?=base_url()?>images/files/<?=$realEstates[$i]['realestateid']?>/<?=$realEstates[$i]['url']?>" alt="Hình bất động sản" width="132"/>
					</a>
					<div class="news-operation">
						<span class="blue_btn" style="float: left;">
							<a href="#" class="left_btn" title="Thêm vào giỏ tin">
								<div class="shopping_cart"></div>
							</a>
						</span>
						<span class="blue_btn">
							<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i]['realestateid']?>" class="right_btn">Xem thêm
							</a>
						</span>
					</div>
				</td>
				<td class="news-detail-wrap">
					<div class="news-title">
						<a href="<?=base_url()?>index.php/realestate/index/<?=$realEstates[$i]['realestateid']?>"><?=$realEstates[$i]['title']?></a>
					</div>
					<div>
						<b>Địa chỉ: </b><?=$realEstates[$i]['address']?>
					</div>
					<div>
						<table>
							<tr>
								<td>
									<b>Giao dịch: </b><?=$realEstates[$i]['transaction']?>
								</td>
								<td>
									<b>Loại BĐS: </b> <?=$realEstates[$i]['category']?>
								</td>
							</tr>
						</table>
					</div>
					<div>
						<table>
							<tr>
								<td>
									<b>Kích thước: </b> <?=$realEstates[$i]['size']?>
								</td>
								<td>
									<b>Diện tích: </b> <?=$realEstates[$i]['area']?> m2
								</td>
							</tr>
						</table>
					</div>
					<div>
						<b>Giá: </b> <span class="price_tag"><?=formatPrice($realEstates[$i]['price']).' '.$realEstates[$i]['currency']?><?=($realEstates[$i]['unit'])? ' / '.($realEstates[$i]['unit']) : ''?></span>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php endif;?>
