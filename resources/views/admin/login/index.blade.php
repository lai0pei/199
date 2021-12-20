@extends('common.template')
@section('style')
<style>
    body {background-image:url("{{asset('image/bg.jpg')}}");height:100%;width:100%;}
    #container{height:100%;width:100%;}
    input:-webkit-autofill {-webkit-box-shadow:inset 0 0 0 1000px #fff;background-color:transparent;}
    .admin-login-background {width:300px;height:300px;position:absolute;left:50%;top:40%;margin-left:-150px;margin-top:-100px;}
    .admin-header {text-align:center;margin-bottom:20px;color:#ffffff;font-weight:bold;font-size:40px}
    .admin-input {border-top-style:none;border-right-style:solid;border-bottom-style:solid;border-left-style:solid;height:50px;width:300px;padding-bottom:0px;}
    .admin-input::-webkit-input-placeholder {color:#a78369}
    .layui-icon-username {color:#a78369 !important;}
    .layui-icon-username:hover {color:#9dadce !important;}
    .layui-icon-password {color:#a78369 !important;}
    .layui-icon-password:hover {color:#9dadce !important;}
    .admin-input-username {border-top-style:solid;border-radius:10px 10px 0 0;}
    .admin-input-verify {border-radius:0 0 10px 10px;}
    .admin-button {margin-top:20px;font-weight:bold;font-size:18px;width:300px;height:50px;border-radius:5px;background-color:#a78369;border:1px solid #d8b29f}
    .admin-icon {margin-left:260px;margin-top:10px;font-size:30px;}
    em {position:absolute;}
    .admin-captcha {position:absolute;margin-left:205px;margin-top:-40px;cursor: pointer;}
</style>
@endsection
@section('content')
<div id="container">
        <div class="admin-login-background">
            <div class="admin-header">
                <span>Vip后台登录</span>
            </div>
            <form class="layui-form" action="">
                <div>
                    <em class="layui-icon layui-icon-username admin-icon"></em>
                    <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" value="admin" class="layui-input admin-input admin-input-username">
                </div>
                <div>
                    <em class="layui-icon layui-icon-password admin-icon"></em>
                    <input type="password" name="password" placeholder="请输入密码" autocomplete="off" value="123456" class="layui-input admin-input">
                </div>
                <div>
                    <input type="text" name="captcha" placeholder="请输入验证码" value="12" autocomplete="off" class="layui-input admin-input admin-input-verify"> 
                    <img id="admin-captcha" class="admin-captcha" width="90" alt="验证码" height="30" src="{{route ('admin.login.captcha')}}">
                </div>
                <button class="layui-btn admin-button" lay-submit="" lay-filter="login">登 陆</button>
            </form>
        </div>
</div>
@endsection
@section('footer')
<script>
      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
layui.use('form', function() {
    var form = layui.form;
    layer = layui.layer;
    var admin_Menu = "{{route('admin_menu')}}";
    var login = "{{route('admin.login.login')}}";
    if (top.location != self.location) top.location = self.location;

    $(document).on('click', '#admin-captcha', function() {
        captcha = $(this).attr('src');
        captcha += '?t=' + Math.random();
        $(this).attr('src', captcha)
    });

    $('#admin-captcha').click().removeClass('layui-hide');

    form.on('submit(login)', function(data) {
        data = data.field;
        if (data.username == '') {
            layer.msg('请填写用户名');
            return false;
        }

        if (data.password == '') {
            layer.msg('请填写密码');
            return false;
        }

        if (data.captcha == '') {
            layer.msg('请填写验证码');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: login,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                $("#button[lay-filter='login']").removeClass('disabled').prop('disabled',
                    false);
                loading = layer.load(2)
            },
            complete: function() {
                $("#button[lay-filter='login']").removeClass('disabled').prop('disabled',
                    false);
                layer.close(loading)
            },
            error: function() {
                top.layer.msg(AJAX_ERROR_TIP, {
                    icon: 2,
                    time: FAIL_TIME,
                    shade: 0.3
                });
                $("#admin-captcha").click();
            },
            success: function(data) {
                if (data.code === 1) {
                    layer.msg(data.msg, {
                        icon: 6,
                        time: SUCCESS_TIME,
                        shade: 0.2
                    });
                    setTimeout(function() {
                        window.location = admin_Menu;
                    }, SUCCESS_TIME);
                } else {
                    top.layer.msg(data.msg, {
                        icon: 2,
                        time: FAIL_TIME,
                        shade: 0.3
                    });
                    if (data.refresh === true) {
                        $("#admin-captcha").click();
                        $("input[name='captcha']").val('')
                    }
                }

            },
        })
        return false;
    });
});
</script>
@endsection