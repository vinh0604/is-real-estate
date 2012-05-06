(function( $ ) {
  $.fn.spCart = function(url) {
	this.live('click',function(){
		$.post(url,{id: $(this).attr('reid')},
				function(data) {
					if(data.status && data.status == 'OK') {
						if($('#cart_item_num')) {
							$('#cart_item_num').text(data.count);
						}
						$.jqDialog.alert('Thêm tin vào giỏ thành công!');
					} else if(data.status && data.status == 'EXISTED'){
						$.jqDialog.alert('Tin được chọn đã có trong giỏ. Vui lòng chọn tin khác!');
					} else {
						$.jqDialog.alert('Không thêm được tin vào giỏ. vui lòng thử lại!');
					}
				},'json');
	});
  };
})( jQuery );