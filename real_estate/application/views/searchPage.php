<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>RE2Y - Real Estate to You</title>
        <!--[if IE]>
                <link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen"/>
        <![endif]-->
        <link rel="stylesheet" href="<?= base_url() ?>css/blueprint/screen.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/blueprint/print.css" type="text/css" media="print"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/style.css" type="text/css" media="screen"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
        <link rel="stylesheet" href="<?= base_url() ?>css/pagination.css" type="text/css" media="screen"/>

        <script src="<?= base_url() ?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/common.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/GeoJSON.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.pagination.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDS5bb-pXbt4N27kkA9y1AS0nGxgciqTiU&sensor=true&language=vi"></script>
        <script type="text/javascript" charset="utf-8">
            var map;
            var aMarker = [];
            var infoWindow = null;
            var area=0;
            //Chế độ tương tác bản đồ
            var Mode = 0;
            var Load = 0;
            var keyword;
            var cityid;
            var districtid;
            function pageselectCallback(index,jq){
                if (index != 0)
                    if (area==1)
                        BasicSearch(10,index*10,false);
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
                
                $.urlParam = function(name){
                    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
                    return results[1] || 0;
                }
 
                
                keyword = decodeURIComponent($.urlParam('k'));
                cityid= $.urlParam('city');
                districtid = $.urlParam('district');
                if (keyword!=0){
                    while (keyword.indexOf('+') != -1)
                    keyword =  keyword.replace("+"," ");
                    $("#keyword").val(keyword);
                }
                if (cityid!=0){
                    $("#city option[value="+cityid+"]").attr('selected',true);
                    $.getJSON('<?= base_url() ?>index.php/realestate/getdistrictbycityid',
                    {id: cityid},
                    function(districts) {
                        var htmlDistrict = ['<option value="">Quận/ Huyện</option>'];
                        console.log(districts);
                        for(i in districts) {
                            htmlDistrict.push(''.concat('<option value="',districts[i].districtid,'">',districts[i].name,'</option>'));
                        }
                        $('#district').html(htmlDistrict.join(''));
                        if (districtid!=0){
                            //alert(districtid);
                            $("#district option[value="+districtid+"]").attr('selected',true);
                        }
                    });
                }
                

            })
        
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
                    '<div style="width: 100%; margin-top: 10px;">',direction_url,cart_url,'</div>',
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
            
            
            function BasicSearch(limit,offset,updatePage){
                $('#MapMode').attr("checked", false);
                area=1;
                Mode=0;
                $("#resultList").html("Đang tải dữ liệu...");
                if (aMarker) {
                    for (var i = 0; i < aMarker.length; i++ ) {
                        aMarker[i].setMap(null);
                    }
                }
                aMarker=[];
                $.getJSON("<?php echo base_url() ?>index.php/search/basicsearch",
                { keyword: $("#keyword").val(),
                    cityID: $("#city").val(),
                    districtID: $("#district").val(),
                    categoryID: $("#category").val(),
                    transaction: $("#transaction").val(),
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
                if (keyword != 0 || districtid != 0 || cityid != 0){
                    BasicSearch(10, 0, true);
                    keyword=0;
                    districtid=0;
                    cityid=0;
                    return;
                }
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
                $.getJSON("<?php echo base_url() ?>index.php/search/getallformap",
                { keyword: $("#keyword").val(),
                    cityID: $("#city").val(),
                    districtID: $("#district").val(),
                    categoryID: $("#category").val(),
                    transaction: $("#transaction").val(),
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
        </script>
    </head>
    <body>

        <?= $topBar ?>
        <div class="container">
            <div class="span-24 search-area-wrap">
                <div class="left-side span-6">
                    <div class="search-frm-wrap module-wrap">
                        <div class="caption-area">
                            Tìm kiếm bất động sản
                        </div>
                        <form action="#" method="get" id="search_frm">
                            <table>
                                <tr>
                                    <td> 
                                        <input type="text" name="k" id="keyword" placeholder="Nhập từ khóa..."/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="city" id="city">
                                            <option value="">Tỉnh/Thành phố</option>
                                            <?php foreach ($cities as $c): ?>
                                                <option value="<?= $c->cityid ?>"><?= $c->name ?></option>	
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="district" id="district">
                                            <option value="">Quận/ Huyện</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="category" id="category">
                                            <option value="">Chọn loại BĐS</option>
                                            <?php foreach ($categories as $c): ?>
                                                <option value="<?= $c->categoryid ?>"><?= $c->name ?></option>	
                                            <?php endforeach; ?>
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
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="MapMode" onclick="ChangeMode();"/> <label>Bật chế độ tương tác bản đồ</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="button" class="submit_btn" value="Tìm kiếm" onclick="BasicSearch(10,0,true)"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="module-wrap">
                        <div class="caption-area">
                            Kết quả tìm kiếm
                        </div>
                        <div class="result-wrap" id ="result">
                            <ul id="resultList"></ul>
                        </div>
                        <div class="nav-wrap">
                            <div id="pagination" class="pagination"></div>
                        </div>
                    </div>
                </div>
                <div class="right-side span-18 last">
                    <div id="map_canvas" style="width: 100%; height: 710px;"></div>
                </div>
            </div>
        </div>
    </body>
</html>