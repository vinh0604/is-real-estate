<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>RE2Y - Real Estate to You</title>
        <!--[if IE]>
                <link rel="stylesheet" href="<?= base_url() ?>css/blueprint/ie.css" type="text/css" media="screen"/>
        <![endif]-->
        <link rel="stylesheet" href="<?= base_url() ?>css/blueprint/screen.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/blueprint/print.css" type="text/css" media="print"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/style.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/jquery.autocomplete.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/jqdialog.css" type="text/css" media="screen"/>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
        <link rel="stylesheet" href="<?= base_url() ?>css/pagination.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/redmond/jquery-ui-1.8.18.custom.css" type="text/css" media="screen"/>
        <script type="text/javascript"
                src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDS5bb-pXbt4N27kkA9y1AS0nGxgciqTiU&sensor=true&language=vi">
        </script>
        <script src="<?= base_url() ?>js/GeoJSON.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.pagination.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.autocomplete.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/common.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.cart.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jqdialog.min.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8">
            var map;
            var aMarker = [];
            var infoWindow = null;
            var area=0;
            //Chế độ tương tác bản đồ
            var Mode = 0;
            var Load = 0;
            
            function pageselectCallback(index,jq){
                if (index != 0)
                    if (area==1)
                        AdvancedSearch(10,index*10,false);
                else
                    UpdateMap(10,index*10,false);
            
            }
            $(document).ready(function(){
                
                $('.dropdown').hover(function() {
                    $(this).children('.sub-menu').slideDown(200);
                }, function() {
                    $(this).children('.sub-menu').hide();
                });
                
                var myOptions = {
                    center: new google.maps.LatLng(10.75, 106.67),
                    zoom: 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
                infoWindow = new google.maps.InfoWindow();
                google.maps.event.addListener(map, 'zoom_changed', function() {UpdateMap(10,0,true);});
                google.maps.event.addListener(map, 'dragend', function() {UpdateMap(10,0,true);});
                google.maps.event.addDomListener(window, 'load', function() {Load=1; UpdateMap(10,0,true); Load=0;});
                               
                $('.add_cart').spCart('<?= base_url() ?>index.php/cart/add');               
                $('#city').change(function(){
                    $.getJSON('<?= base_url() ?>index.php/realestate/getdistrictbycityid',
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
                $('#street_name').autocompleteArray(
<?php
echo "[";
foreach ($street as $st):
    echo "'$st->ten_dgt',";
endforeach;
echo "]";
?>
                        ,
                        {
                            delay:10,
                            minChars:1,
                            matchSubset:1,
                            onItemSelect:selectItem,
                            onFindValue:findValue,
                            autoFill:true,
                            maxItemsToShow:10
                        } 
                    
                    );
                    })
                    function findValue(li) {
                        //if( li == null ) return alert("No match!");
                        // if coming from an AJAX call, let's use the CityId as the value
                        if( !!li.extra ) var sValue = li.extra[0];
                        // otherwise, let's just display the value in the text box
                        else var sValue = li.selectValue;
                        //alert("The value you selected was: " + sValue);
                    }
                    function selectItem(li) {
                        findValue(li);
                    } 
        
                    function addEvent(marker,realestateid) {
                        google.maps.event.addListener(marker, 
                        'click', 
                        function(event){
                            showInfo(marker,realestateid);
                        });
                    }
                    function showInfo(marker,realEstateId) {
                        $.getJSON('<?= base_url() ?>index.php/home/getdetail',
                        {id: realEstateId},
                        function(realEstate) {
                            var url = '<?= base_url() ?>index.php/realestate/index/' + realEstate.realestateid;
                            var price = '';
                            if (parseFloat(realEstate.price)) {
                                price = price.concat('<span class="info_price">',formatPrice(realEstate.price),realEstate.currency,'</span>');
                                if (realEstate.unit) {
                                    price = price.concat(' / ',realEstate.unit);
                                }
                            }
                            var direction_url = ''.concat('<a href="#" class="direction_link" lat="',marker.getPosition().lat(),'" lng="',marker.getPosition().lng(),'" style="float: left">Tìm đường đến đây</a>');
                            var cart_url = ''.concat('<a href="#" class="add_cart" reid="',realEstate.realestateid,'" style="float: right">Thêm vào giỏ tin</a>');
                            infoWindow.setContent('<div class="info_window">'.concat(
                            '<div class="info_title"><a href="',url,'">',realEstate.title,'</a></div>', 
                            '<div><b>Địa chỉ: </b>',realEstate.address,'</div>',
                            '<div><b>Diện tích: </b>',realEstate.area,' m2','</div>',
                            '<div><b>Loại BĐS: </b>',realEstate.category,'</div>',
                            '<div><b>Giá: </b> ',price,'</div>',
                            '<div><b>Điện thoại: </b>',realEstate.contacttel,'</div>',
                            '<div style="width: 100%; margin-top: 10px;">',cart_url,'</div>',
                            '</div>'));
                            infoWindow.open(map,marker);
                        });
                    }
            
            
                    function UpdateObjectOnMap(realEstate){
                        var icon = '<?= base_url() ?>images/house_sale.png';
                        var location = JSON.parse(realEstate.location);
                        if (realEstate.transaction.toLowerCase() == "thuê") {
                            icon = '<?= base_url() ?>images/house_lease.png';
                        }
                        var marker = new GeoJSON(location, {"icon": icon});
                        marker.setMap(map);
                        addEvent(marker,realEstate.realestateid);
                        aMarker.push(marker);
                    }
            
                    function UpdateList(realEstates,sumPages,updatePage){
                        if (realEstates.length == 0){
                            $("#resultList").html("Không có kết quả trùng khớp");
                            return;
                        }
                
                        var count=0;
                        $("#resultList").html('');
                        for (i in realEstates)       {
                            var innerHTML="";
                            innerHTML+="<li><div class='news-wrap'><div class='left-news'>";
                            innerHTML+="<a href='#' onmouseover='ChangeIcon("+count+");' onmouseout='ResetIcon("+count+",\""+realEstates[i].transaction+"\");'";
                            innerHTML+='><img src="<?= base_url() ?>images/thumbnails/'+realEstates[i].realestateid+'/'+realEstates[i].url+'" alt="Hình địa ốc" width="64"/>';
                            innerHTML+='</a></div><div class="right-news"><div class="news-title">';
                            innerHTML+="<a href='<?= base_url() ?>index.php/realestate/index/"+realEstates[i].realestateid+"' onmouseover='ChangeIcon("+count+");' onmouseout='ResetIcon("+count+",\""+realEstates[i].transaction+"\");' >"+realEstates[i].title+'</a>';
                            innerHTML+='</div></div></div></li>';
                            $("#resultList").append(innerHTML);                        
                            count++;
                            UpdateObjectOnMap(realEstates[i]);
                        }
                        if (updatePage){
                            $('#pagination').pagination(sumPages, {callback: pageselectCallback, 
                                prev_text: '&lt',
                                next_text: '&gt',
                                num_display_entries: 3,
                                num_edge_entries: 1,
                                items_per_page: 10});
                        }
                        if (Mode==0)
                            map.panTo(aMarker[0].getPosition());
                    }
            
            
                    function AdvancedSearch(limit,offset,updatePage){
                        Mode=0;
                        $('#MapMode').attr("checked", false);
                        if (!CheckPrice())
                            return;
                        area=1;
                        $("#resultList").html("Đang tải dữ liệu...");
                        if (aMarker) {
                            for (var i = 0; i < aMarker.length; i++ ) {
                                aMarker[i].setMap(null);
                            }
                        }
                        aMarker=[];
                        $.getJSON("<?php echo base_url() ?>index.php/search/Advancedsearch",
                        { keyword: $("#keyword").val(),
                            cityID: $("#city").val(),
                            districtID: $("#district").val(),
                            categoryID: $("#category").val(),
                            transaction: $("#transaction").val(),
                            direction: $('#direction').val(),
                            area: $('#area').val(),
                            startPrice : price1,
                            endPrice : price2,
                            currency: $('#currency').val(),
                            hospitalDis : $('#hospital_distance').val(),
                            schoolDis : $('#school_distance').val(),
                            marketDis : $('#market_distance').val(),
                            streetDis : $('#street_distance').val(),
                            streetName : $('#street_name').val(),
                            limit : limit,
                            offset : offset},
                        function (realEstates){
                            UpdateList(realEstates["items"],realEstates['count'],updatePage);
                        }
                
                    );
                    }
                    function ChangeIcon(i){
                        aMarker[i].setIcon('<?= base_url() ?>images/map1.png');
                        if (Mode == 0)
                            map.panTo(aMarker[i].getPosition());
                    }
                    function ResetIcon(i,transaction){
                        if (transaction.toLowerCase() == "thuê")
                            aMarker[i].setIcon('<?= base_url() ?>images/house_lease.png');
                        else
                            aMarker[i].setIcon('<?= base_url() ?>images/house_sale.png');
                    }
            
                    function UpdateMap(limit,offset,updatePage){
                        ChangeMode();
                        if (Mode == 0 && Load==0 )
                            return ;
                        area=0;
                        $("#resultList").html("Đang tải dữ liệu...");
                        if (aMarker) {
                            for (var i = 0; i < aMarker.length; i++ ) {
                                aMarker[i].setMap(null);
                            }
                        }
                        aMarker=[];
                        $.getJSON("<?php echo base_url() ?>index.php/search/GetAllForMapAdvancedSearch",
                        { keyword: $("#keyword").val(),
                            cityID: $("#city").val(),
                            districtID: $("#district").val(),
                            categoryID: $("#category").val(),
                            transaction: $("#transaction").val(),
                            direction: $('#direction').val(),
                            area: $('#area').val(),
                            startPrice : price1,
                            endPrice : price2,
                            currency: $('#currency').val(),
                            hospitalDis : $('#hospital_distance').val(),
                            schoolDis : $('#school_distance').val(),
                            marketDis : $('#market_distance').val(),
                            streetDis : $('#street_distance').val(),
                            streetName : $('#street_name').val(),
                            northEastlat:map.getBounds().getNorthEast().lat(),
                            northEastlng:map.getBounds().getNorthEast().lng(),
                            southWestlat:map.getBounds().getSouthWest().lat(),
                            southWestlng:map.getBounds().getSouthWest().lng(),
                            limit : limit,
                            offset : offset},
                        function (realEstates){
                            UpdateList(realEstates["items"],realEstates['count'],updatePage);
                        }
                    );
                    }
        
                    function ChangeMode(){
                        if ($('#MapMode').is(':checked'))
                            Mode=1;
                        else
                            Mode =0;
                    }
            
                    function ShowMessage(content){
                        $('#message').html(content);
                        $('#dialog').dialog({ modal: true,buttons: [
                                {
                                    text: "OK",
                                    click: function() { $(this).dialog("close"); }
                                }
                            ]});
                    }
            
            
                    var price1;
                    var price2;
                    function CheckPrice(){
                        var str = "";
                
                        if (isNaN($('#start_price').val())){
                            str+='Giá 1 nhập sai <br />';
                        }
                        if (isNaN($('#hospital_distance').val()) || (parseFloat($('#hospital_distance').val()) < 0)){
                            str+='Khoảng cách bệnh viện nhập sai <br />';
                        }
                        if (isNaN($('#market_distance').val()) || (parseFloat($('#market_distance').val()) < 0)){
                            str+='Khoảng cách chợ,siêu thị nhập sai <br />';
                        }
                        if (isNaN($('#school_distance').val()) || (parseFloat($('#school_distance').val()) < 0)){
                            str+='Khoảng cách trường học nhập sai <br />';
                        }
                        if (isNaN($('#street_distance').val()) || (parseFloat($('#street_distance').val()) < 0)){
                            str+='Khoảng cách đường nhập sai <br />';
                        }
                
                        if ($('#street_name').val() == "" && $('#street_distance').val() != ""){
                            str+='Thiếu tên đường <br />';
                        }
                    
                        if ($('#street_name').val() != "" && $('#street_distance').val() == ""){
                            str+='Thiếu khoảng cách đến đường <br />';    
                        }
                
                        var p = $('#price').val();
                        var min = parseFloat($('#start_price').val());
                        var max = parseFloat($('#end_price').val());
                        if (min > max){
                            str+='Khoảng giá không phù hợp';
                        }
                
                        if (str!=""){					
                            ShowMessage(str);
                            return false;
                        }
                        if ($('#currency').val() == 'VND'){
                            if ($('#start_price').val() != "" ) price1 = parseFloat($('#start_price').val())*100000;
                            else price1 ="";
                            if ($('#end_price').val() != "" )
                                price2 = parseFloat($('#end_price').val())*1000000;
                            else price2="";
                        }
                        else{
                            if ($('#start_price').val() != "" ) price1 = parseFloat($('#start_price').val());
                            else price1 ="";
                            if ($('#end_price').val() != "" )
                                price2 = parseFloat($('#end_price').val());
                            else price2="";
                        }
                        return true;
                    }
            
        </script>


    </head>
    <body>
        <?= $topBar ?>
        <div id="dialog" title="Lỗi" style="display: none;">
            <p id="message"></p>
        </div>
        <div class="container">
            <div class="span-24 search-area-wrap">
                <div class="module-wrap advance-search-wrap">
                    <div class="caption-area">
                        Tìm kiếm nâng cao
                    </div>
                    <form action="<?= base_url() ?>index.php/search/advanced" method="post" id="search_frm">
                        <table class="top-table">
                            <tr>
                                <td colspan="2"> 
                                    <input type="text" name="k" id="keyword" placeholder="Nhập từ khóa..."/>
                                </td>
                                <td colspan="2">
                                    <select name="city" id="city">
                                        <option value="">Tỉnh/Thành phố</option>
                                        <?php foreach ($cities as $c): ?>
                                            <option value="<?= $c->cityid ?>"><?= $c->name ?></option>	
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td colspan="2">
                                    <select name="district" id="district">
                                        <option value="">Quận/ Huyện</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="transaction" id="transaction">
                                        <option value="">Chọn loại giao dịch</option>
                                        <option value="Thuê">Thuê</option>
                                        <option value="Bán">Bán</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="category" id="category">
                                        <option value="">Chọn loại BĐS</option>
                                        <?php foreach ($categories as $c): ?>
                                            <option value="<?= $c->categoryid ?>"><?= $c->name ?></option>	
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td colspan="2">
                                    <select name="area" id="area">
                                        <option value="">Diện tích</option>
                                        <option value="1"> dưới 100m2</option>
                                        <option value="2"> 100m2 đến 500m2</option>
                                        <option value="3">trên 500m2</option>
                                    </select>
                                </td>
                                <td>

                                    <select name="direction" id="direction">
                                        <option value="">Phương hướng</option>
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
                                <td style="width: 108px;">
                                    <label for="start_price">Giá từ: </label>
                                </td>
                                <td style="width: 130px;">
                                    <input type="text" name="start_price" id="start_price" />
                                </td>
                                <td style="width: 50px;">
                                    <label for="end_price">Giá đến: </label>
                                </td>
                                <td style="width: 130px;">
                                    <input type="text" name="end_price" id="end_price" />
                                </td>
                                <td style="width: 92px;">
                                    <select name="currency" id="currency" style="width: 85px;">
                                        <option value="VND">triệu VNĐ</option>
                                        <option value="USD">USD</option>
                                        <option value="SJC">lượng SJC</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table class="low-table">
                            <tr>
                                <td style="width: 125px;">
                                    <label for="hospital">Cách bệnh viện </label>
                                </td>
                                <td style="width: 100px;">
                                    <input type="text" name="hospital_distance" id="hospital_distance" />
                                </td>
                                <td><label for=""> mét</label></td>
                            </tr>
                            <tr>
                                <td>

                                    <label for="school">Cách trường học </label>
                                </td>
                                <td>
                                    <input type="text" name="school_distance" id="school_distance" />
                                </td>
                                <td><label for=""> mét</label></td>
                            </tr>
                            <tr>
                                <td>

                                    <label for="market">Cách chợ/ siêu thị </label>
                                </td>
                                <td>
                                    <input type="text" name="market_distance" id="market_distance" />
                                </td>
                                <td><label for=""> mét</label></td>
                            </tr>
                            <tr>
                                <td>

                                    <label for="street">Cách đường </label>
                                </td>
                                <td colspan="2">
                                    <input type="text" name="street_name" id="street_name" placeholder="Tên đường..."/>
                                </td>
                                <td style="width: 50px;">
                                    <label for="street_distance">Phạm vi </label>
                                </td>
                                <td style="width: 100px;">
                                    <input type="text" name="street_distance" id="street_distance" />
                                </td>
                                <td><label for=""> mét</label></td>
                            </tr>
                            <tr>


                                <td colspan="2">
                                    <input type="checkbox" id="MapMode" onclick="ChangeMode();"/> <label>Bật chế độ tương tác bản đồ</label>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="button" class="submit_btn" value="Tìm kiếm" onclick="AdvancedSearch(10,0,true);"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="left-side span-6">
                    <div class="module-wrap">
                        <div class="caption-area">
                            Kết quả tìm kiếm
                        </div>
                        <div class="result-wrap">
                            <ul id ="resultList">
                            </ul>
                        </div>
                        <div class="nav-wrap">
                            <div id="pagination" class="pagination"></div>
                        </div>
                    </div>
                </div>
                <div class="right-side span-18 last">
                    <div id="map_canvas" style="width: 100%; height: 550px;"></div>
                </div>
            </div>
        </div>
    </body>
</html>
