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
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= base_url() ?>css/demo_table_jui.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/redmond/jquery-ui-1.8.18.custom.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/validationEngine.jquery.css" type="text/css" media="screen"/>

        <script src="<?= base_url() ?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery-ui-1.8.18.custom.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.ui.datepicker-vi.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.validationEngine-vi.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8">
            var action;
            $(document).ready(function(){
                $('.dropdown').hover(function() {
                    $(this).children('.sub-menu').slideDown(200);
                }, function() {
                    $(this).children('.sub-menu').hide();
                });
                $('#account_table').dataTable({
                    "bJQueryUI": true,
                    "aoColumns": [{"bSortable": true,"bSearchable": false,"sWidth" :"100px"},
                        {"bSortable": false,"bSearchable": false,"sWidth" :"30px"},
                        null,
                        null,
                        null,
                        null,
                        {"bSortable": false,"bSearchable": false,"sWidth" :"30px"}]
                });
                $('#ck_all').click(function() {
                    var checked_status = this.checked;
                    $("input[name='a_id[]']").each(function()
                    {
                        this.checked = checked_status;
                    });
                });
                $("input[name='a_id[]']").click(function() {
                    $('#ck_all').attr('checked', false);
                    var flag = true;
                    if (this.checked) {
                        $("input[name='a_id[]']").each(function()
                        {
                            if (!this.checked) {
                                flag = false;
                                return flag;
                            }
                        });
                        if (flag) {
                            $('#ck_all').attr('checked', true);
                        }
                    }
                });

                $('#confirm_view').dialog({ buttons:[
                        {text: "Có",click: function() { DeleteUser(); } },
                        {text: "Không",click: function() { $(this).dialog("close"); } }
                    ],
                    autoOpen: false,
                    modal: true,
                    resizable: false,
                    draggable: false
                });
                $('#notice_view').dialog({ buttons:[
                        {text: "Đóng",click: function() { $(this).dialog("close"); } }
                    ],
                    autoOpen: false,
                    modal: true,
                    resizable: false,
                    draggable: false
                });
                $('#form_view').dialog({ buttons : [
                        {text: "Lưu tài khoản",click: function() { DoAction();} },
                        {text: "Đóng",click: function() { $(this).dialog("close"); } }
                    ],
                    autoOpen: false,
                    modal: true,
                    width: 350,
                    close: function(event, ui) { $('#account_frm').validationEngine('hideAll'); }
                });
                $('#account_frm').validationEngine('attach');
                $('#birthdate').datepicker({dateFormat:'dd/mm/yy', changeMonth:true, changeYear:true, yearRange: '1940:2000'});
		
                $('#del_btn').click(function() {
                    var not_checked = true;
                    $("input[name='a_id[]']").each(function()
                    {
                        if (this.checked) {
                            not_checked = false;
                            return not_checked;
                        }
                    });
                    if (not_checked) {
                        $('#notice_view').dialog('open');
                    } else {
                        $('#confirm_view').dialog('open');
                    }
                });
		
                $('#add_btn').click(function() {
                    action=0;
                    $('#form_view').dialog( "option", "title", "Thêm tài khoản" );
                    $('#form_view').dialog('open');
                    $('#username').removeAttr('disabled');
                    $('#username').val("");
                    $('#email').val("");
                    $('#fullname').val("");
                    $('#phone').val("");
                    $('#address').val("");
                    $('#birthdate').val("");
                });
		UpdateAffect();
                
            })
            
            function UpdateAffect(){
                $('.edit_btn').click(function() {
                    action=1;
                    $('#form_view').dialog( "option", "title", "Sửa tài khoản" );
                    $('#form_view').dialog('open');
                    var username = this.id;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>index.php/user/getuser",
                        data : {username : username},
                        dataType: "json",
                        success: function(data){
                            var arr = data.res["row"];
                            $('#username').val(arr["username"]);
                            $('#username').attr('disabled','disabled');
                            $('#email').val(arr["email"]);
                            $('#fullname').val(arr["name"]);
                            $('#phone').val(arr["tel"]);
                            $('#address').val(arr["address"]);
                            $('#birthdate').val(arr["birthday"]);
                        }
                    });
                
                });
                $('.edit_btn').hover(function(){
                    $(this).children('img').attr('src','<?= base_url() ?>images/edit_hover.png');
                }, function(){
                    $(this).children('img').attr('src','<?= base_url() ?>images/edit.png');
                });
            }
            
            function DoAction(){
                if (action==0)
                    AddNewUser();
                else
                    UpdateUser();
            }
            
            function AddNewUser(){
                var valid= $('#account_frm').validationEngine('validate');
                if (valid==true){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>index.php/user/addnewuser",
                        data:{
                            username : $('#username').val(),
                            email: $('#email').val(),
                            fullname : $('#fullname').val(),
                            phone: $('#phone').val(),
                            address: $('#address').val(),
                            birthdate: $('#birthdate').val()
                        },
                        dataType: "json",
                        success: function(data){
                            var message = data.res["message"];
                            var arr = data.res["row"];
                            if (message=="1") {   
                                ShowMessage("Thêm mới tài khoản thành công");
                                $("#account_table").dataTable().fnAddData([
                                    arr["userid"],                                                
                                    '<td><input type="checkbox" name="a_id[]" id="user'+arr["userid"]+'" value="'+arr["userid"]+'"/></td>',
                                    arr["username"],
                                    arr["name"],
                                    arr["email"],
                                    arr["duty"],
                                    '<a href="#" class="edit_btn" id ="'+arr["username"]+'"><img src="<?= base_url() ?>images/edit.png" height="24" width="24" title="Chỉnh sửa tài khoản"/></a>'
                                ]);
                                UpdateAffect();
                            }
                            else ShowMessage(message);
                        }
                    });
                }
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
            function UpdateUser(){ var valid= $('#account_frm').validationEngine('validate');
                if (valid==true){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>index.php/user/updateuser",
                        data:{
                            username : $('#username').val(),
                            email: $('#email').val(),
                            fullname : $('#fullname').val(),
                            phone: $('#phone').val(),
                            address: $('#address').val(),
                            birthdate: $('#birthdate').val()
                        },
                        success: function(html){
                            if (html=="1"){
                                ShowMessage("Cập nhật thành công");
                                $("#name"+$('#username').val()).text($('#fullname').val());
                                $("#email"+$('#username').val()).text($('#email').val());
                            }
                        }
                    });
                }
            }
            
            function DeleteUser(){
                var list=[];
                $("input[name='a_id[]']").each(function()
                {
                    if (this.checked) {
                        list.push(this.value);
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>index.php/user/deleteuser",
                    data : {list: list},
                    dataType: "json",
                    success: function(data){
                        var items=data.res["result"];
                        var i;
                        var message="";
                        for (i=0;i<items.length;i++){
                            var userid = (items[i]["userid"]);
                            var result = (items[i]["result"]);
                            if (result=="1"){
                                message = message + "*Tài khoản ID="+userid+" xóa thành công<br />";
                                var tag= $("#user"+userid).parent().parent();
                                $("#account_table").dataTable().fnDeleteRow(tag);
                            }
                            else{
                                message = message + "*Tài khoản ID="+userid+" xóa không thành công<br />";
                            }
                        }
                        $('#confirm_view').dialog('close');
                        ShowMessage(message);
                    }
                });
            }
        </script>
    </head>
    <body>
        <div id="dialog" title="Quản lý tài khoản" style="display: none;">
            <p id="message"></p>
        </div>
        <div id="confirm_view" title="Quản lý tài khoản" style="display: none;">
            <p>Bạn có chắc muốn xóa (những) tài khoản được chọn?</p>
        </div>
        <div id="notice_view" title="Quản lý tài khoản" style="display: none;">
            <p>Không có tài khoản nào được chọn!</p>
        </div>
        <div id="form_view" style="display: none;">
            <p>
                <label>(*): Các trường bắt buộc</label>
            </p>
            <form id="account_frm">
                <table>
                    <tr>
                        <td>
                            <label for="username">Tên đăng nhập (*):</label>
                        </td>
                        <td>
                            <input type="text" name="username" id="username" class="validate[required,custom[noSpecialCaracters]]"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email">Email (*):</label>
                        </td>
                        <td>
                            <input type="text" name="email" id="email" class="validate[required,custom[email]]"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="fullname">Họ tên (*):</label>
                        </td>
                        <td>
                            <input type="text" name="fullname" id="fullname" class="validate[required]"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="birthdate">Ngày sinh (*):</label>
                        </td>
                        <td>
                            <input type="text" name="birthdate" id="birthdate" class="validate[required]"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="address">Địa chỉ:</label>
                        </td>
                        <td>
                            <textarea name="address" id="address" style="width: 132px; height: 36px"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="phone">Điện thoại:</label>
                        </td>
                        <td>
                            <input type="text" name="phone" id="phone" class="validate[optional,custom[onlyNumber]]"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?= $topBar ?>
        <div class="container">
            <div class="main-content span-24">
                <div class="breadcrumbs">
                    <ul>
                        <li class="crumb-first"><a href="<?= base_url() ?>index.php"><img src="<?= base_url() ?>images/home.png" alt="Trang chủ" width="21"/></a></li>
                        <li class="crumb-last"><a href="<?= base_url() ?>index.php/user">Quản lý tài khoản</a></li>
                    </ul>
                </div>
                <div style="margin: 0 auto;width: 870px;">
                    <div class="btn_wrap">
                        <button class="del_btn" id="del_btn"><img src="<?= base_url() ?>images/trash.png" />Xóa tài khoản</button>
                        <button class="add_btn" id="add_btn"><img src="<?= base_url() ?>images/plus.png" />Thêm tài khoản</button>
                    </div>
                    <div class="table_wrap">
                        <table border="0" cellspacing="0" cellpadding="0" id="account_table" class="display">
                            <thead>
                                <tr>
                                    <th class="">Mã tài khoản</th>
                                    <th class="fixed_column"><input type="checkbox" name="c_all" id="ck_all" /></th>
                                    <th>Tên đăng nhập</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Quyền</th>
                                    <th class="fixed_column"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($lstAdmin as $item) { ?>
                                    <tr>
                                        <td><?php echo $item->userid ?></td>
                                        <td><input type="checkbox" name="a_id[]" id="user<?php echo $item->userid ?>" value="<?php echo $item->userid ?>"/></td>
                                        <td><?php echo $item->username ?></td>
                                        <td id="name<?php echo $item->username ?>"><?php echo $item->name ?></td>
                                        <td id="email<?php echo $item->username ?>"><?php echo $item->email ?></td>
                                        <td><?php echo $item->duty ?></td>
                                        <td><a href="#" class="edit_btn" id="<?php echo $item->username ?>"><img src="<?= base_url() ?>images/edit.png" height="24" width="24" title="Chỉnh sửa tài khoản"/></a></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>