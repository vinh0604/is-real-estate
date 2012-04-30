<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title></title>
        <!--[if IE]>
                <link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen"/>
        <![endif]-->
        <link rel="stylesheet" href="<?= base_url() ?>css/blueprint/screen.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/blueprint/print.css" type="text/css" media="print"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/style.css" type="text/css" media="screen"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= base_url() ?>css/validationEngine.jquery.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="<?= base_url() ?>css/redmond/jquery-ui-1.8.18.custom.css" type="text/css" media="screen"/>

        <script src="<?= base_url() ?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.ui.core.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.ui.datepicker.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.ui.datepicker-vi.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.validationEngine-vi.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('.dropdown').hover(function() {
                    $(this).children('.sub-menu').slideDown(200);
                }, function() {
                    $(this).children('.sub-menu').hide();
                });
                $('#signup_frm').validationEngine('attach');
                $('#birthdate').datepicker({dateFormat:'dd/mm/yy', changeMonth:true, changeYear:true, yearRange: '1940:2012'});
            })
        
    function Register(){
        {
            var valid = $('#signup_frm').validationEngine('validate');
            if (valid==true){
            $.ajax({  
                type: "POST",  
                url: "<?php echo base_url() ?>index.php/register/doregister",												
                data :{
                    username : $('#username').val(),
                    password : $('#password').val(),
                    email: $('#email').val(),
                    fullname : $('#fullname').val(),
                    gender: $("[name='gender']").val(),
                    phone: $('#phone').val(),
                    identity: $('#identity').val(),
                    address: $('#address').val(),
                    birthdate: $('#birthdate').val()
                },
                success: function(html){
                    if (html=='1'){
                        $("#redirect").attr('style','display:block');
                        $("#forminput").attr('style','display:none');
                        setTimeout('window.location = "<?php echo base_url()?>index.php/login"',5000);
                    }
                    else
                        $("#message").html(html);
                }  
            });
            }
            }
    }
        </script>
    </head>
    <body>
        <?= $topBar ?>
        <div class="container">
            <div class="signin-container" style="margin: 20px auto;">
                <div class="form-title">
                    Đăng ký
                </div>
                <div id="message">
                </div>
                <div id="redirect" style="display: none" align="center">
                    <img src="<?php echo base_url()?>images/loading.gif" width="32px" height="32px"/>
                    <p>Đăng ký thành công ! Đang chuyển trang</p>
                    <p>Nhấn vào <a href="<?=base_url()?>index.php/login">đây</a> nếu trình duyệt không chuyển trang</p>
                </div>
                <div id="forminput" style="display: block">
                <form id="signup_frm">
                    <table>
                        <tr>
                            <td style="text-align: center;" colspan="2"><label>(<b>*</b>): Các trường bắt buộc</label></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="username">Tên đăng nhập (<b>*</b>):</label></td>
                            <td><input type="text" name="username" id="username" class="validate[required,custom[noSpecialCaracters]]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="password">Mật khẩu (<b>*</b>):</label></td>
                            <td><input type="password" name="password" id="password" class="validate[required]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="password_confirm">Xác nhận mật khẩu (<b>*</b>):</label></td>
                            <td><input type="password" name="password_confirm" id="password_confirm" class="validate[required,equals[password]]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="email">Email (<b>*</b>):</label></td>
                            <td><input type="text" name="email" id="email" class="validate[required,custom[email]]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="email_confirm">Xác nhận email (<b>*</b>):</label></td>
                            <td><input type="text" name="email_confirm" id="email_confirm" class="validate[required],equals[email]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="fullname">Họ tên (<b>*</b>):</label></td>
                            <td><input type="text" name="fullname" id="fullname" class="validate[required]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label>Giới tính (<b>*</b>):</label></td>
                            <td>
                                <input type="radio" name="gender" id="gender_1" value="1" class="validate[required]" checked/><label for="gender_1">Nam</label>
                                <input type="radio" name="gender" id="gender_0" value="0" class="validate[required]"/><label for="gender_0">Nữ</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="phone">Số điện thoại (<b>*</b>):</label></td>
                            <td><input type="text" name="phone" id="phone" class="validate[required,custom[onlyNumber]]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="identity">Số CMND (<b>*</b>):</label></td>
                            <td><input type="text" name="identity" id="identity" class="validate[required,custom[onlyNumber]]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="address">Địa chỉ:</label></td>
                            <td><textarea name="address" id="address" style="width: 240px; height: 18px"></textarea></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="birthdate">Ngày sinh:</label></td>
                            <td><input type="text" name="birthdate" id="birthdate"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="checkbox" name="terms_of_service" id="terms_of_service" class="validate[required]"/>
                                <label for="terms_of_service">Tôi đã đọc và đồng ý với <a href="#">điều khoản sử dụng</a></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input onclick="Register()" type="button" class="submit_btn" value="Đăng ký"/>
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>
