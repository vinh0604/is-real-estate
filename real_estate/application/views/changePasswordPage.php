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
        <link rel="stylesheet" href="<?= base_url() ?>css/validationEngine.jquery.css" type="text/css" media="screen"/>

        <script src="<?= base_url() ?>js/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>js/jquery.validationEngine-vi.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                $('.dropdown').hover(function() {
                    $(this).children('.sub-menu').slideDown(200);
                }, function() {
                    $(this).children('.sub-menu').hide();
                });
                $('#changepwd_frm').validationEngine('attach');
            })
            
            function ChangePassword(){
                var valid = $('#changepwd_frm').validationEngine('validate');
                if (valid==true){
                    $.ajax({
                        type: "POST",
                        data: {oldPassword: $('#password1').val()},
                        url : "<?php echo base_url() ?>index.php/user/checkoldpassword",
                        success: function(html){
                            if (html=="1")
                                $.ajax({
                                    type: "POST",
                                    data: {newPassword : $('#password2').val()},
                                    url : "<?php echo base_url() ?>index.php/user/changepassword",
                                    success: function(html){
                                        if (html=="1")
                                           $('#message').html('Đổi mật khẩu thành công');
                                    }
                            });
                        }
                    }
        );
        }
    }
        </script>

    </head>
    <body>
        <?= $topBar ?>
        <div class="container">
            <div class="signin-container" style="margin-top: 20%;">
                <div class="form-title">
                    Thay đổi mật khẩu
                </div>
                <div id="message">
                </div>
                <div id="changepwd">
                <form action="<?= base_url() ?>index.php/login/login" method="post" id="changepwd_frm">
                    <table>
                        <tr>
                            <td class="label_holder"><label for="password1">Mật khẩu hiện tại:</label></td>
                            <td><input type="password" name="password1" id="password1" class="validate[required]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="password2">Mật khẩu mới:</label></td>
                            <td><input type="password" name="password2" id="password2" class="validate[required]"/></td>
                        </tr>
                        <tr>
                            <td class="label_holder"><label for="password3">Xác nhận mật khẩu:</label></td>
                            <td><input type="password" name="password3" id="password3" class="validate[required,equals[password2]]"/></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input onclick="ChangePassword()" type="button" class="submit_btn" value="Thay đổi"/>
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>