
(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{"required":{    			// Add your regex rules here, you can take telephone as an example
					"regex":"none",
						"alertText":"* Thông tin bắt buộc",
						"alertTextCheckboxMultiple":"* Vui lòng chọn một mục",
						"alertTextCheckboxe":"* Tùy chọn bắt buộc"},
					"length":{
						"regex":"none",
						"alertText":"*Độ dài từ ",
						"alertText2":" đến ",
						"alertText3": " ký tự cho phép"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* Vượt quá số tùy chọn tối đa"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"* Vui lòng chọn ",
						"alertText2":" tùy chọn"},	
					"equals":{
						"regex":"none",
						"alertText":"* Giá trị không khớp"},		
					"phone":{
						// credit: jquery.h5validate.js / orefalo
						"regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
						"alertText":"* Số điện thoại không hợp lệ"},	
					"email":{
						// Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
						"regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/,
						"alertText":"* Email không hợp lệ"},
					"integer":{
						"regex": /^[\-\+]?\d+$/,
						"alertText":"* Không phải số nguyên hợp lệ"},
					"number":{
						// Number, including positive, negative, and floating decimal. Credit: bassistance
						"regex": /^[\-\+]?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)$/,
						"alertText":"* Không phải số thực hợp lệ"},
					"date":{
						// Date in ISO format. Credit: bassistance
                         "regex":/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}$/,
                         "alertText":"* Định dạng ngày không hợp lệ, xin để định dạng DD/MM/YYYY"},
                         
                    "ipv4":{
                    	"regex": /^([1-9][0-9]{0,2})+\.([1-9][0-9]{0,2})+\.([1-9][0-9]{0,2})+\.([1-9][0-9]{0,2})+$/,
                    	"alertText":"* Địa chỉ IP không hợp lệ"},      
                    "url":{
                    	"regex":/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/,
                    	"alertText":"* Địa chỉ URL không hợp lệ"},
					"onlyNumber":{
						"regex":/^[0-9\ ]+$/,
						"alertText":"* Chỉ được nhập số"},	
					"noSpecialCaracters":{
						"regex":/^[0-9a-zA-Z]+$/,
						"alertText":"* Không được nhập các ký tự đặc biệt"},	
					"ajaxUser":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"* Tên đăng nhập sẵn dùng",	
						"alertTextLoad":"* Đang kiểm tra, xin chờ",
						"alertText":"* Tên đăng nhập này đã tồn tại"},	
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"* Tên này đã tồn tại",
						"alertTextOk":"* Tên sẵn dùng",	
						"alertTextLoad":"* Đang kiểm tra, xin chờ"},		
					"onlyLetter":{
						"regex":/^[a-zA-Z\ \']+$/,
						"alertText":"* Chỉ được nhập chữ cái alphabet"},
					"validate2fields":{
    					"nname":"validate2fields",
    					"alertText":"* Phải nhập đủ cả họ và tên"}	
					};
					
		}
	};
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang();
});