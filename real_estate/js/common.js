/*
 * Author: VinhBSD
 * Summary: format price 
 * Parameter 1: original price
 * Return: formatted string
 */
function formatPrice(price) {
	var sPrice = '';
	var num = null
	if (num = price / 1000000000 | 0) {
		sPrice += num + ' tỷ ';
	}
	price %= 1000000000;
	if (num = price / 1000000 | 0) {
		sPrice += num + ' triệu ';
	}
	price %= 1000000;
	if (num = price / 1000 | 0) {
		sPrice += num + ' nghìn ';
	}
	price %= 1000;
	if (price) {
		sPrice += price + ' ';
	}
	return sPrice;
}
