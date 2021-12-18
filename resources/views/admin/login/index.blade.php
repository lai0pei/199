@extends('common.template')
@section('style')
<style>
html,
body {
    width: 100%;
    height: 100%;
    overflow: hidden
}

body {
    background: #009688;
}

.background {
    width: 340px;
    height: 300px;
    position: absolute;
    left: 50%;
    top: 40%;
    margin-left: -170px;
    margin-top: -100px;
}

body:after {
    content: '';
    background-repeat: no-repeat;
    background-size: cover;
    -webkit-filter: blur(3px);
    -moz-filter: blur(3px);
    -o-filter: blur(3px);
    -ms-filter: blur(3px);
    filter: blur(3px);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}

.layui-container {
    width: 100%;
    height: 100%;
    overflow: hidden
}

.logo-title {
    text-align: center;
    letter-spacing: 2px;
    padding: 14px 0;
}

.logo-title h1 {
    color: black;
    font-weight: bold;
}

.login-form {
    background-color: #fff;
    border: 1px solid #fff;
    border-radius: 3px;
    padding: 14px 20px;
    box-shadow: 0 0 8px #eeeeee;
}

.login-form .layui-form-item {
    position: relative;
}

.login-form .layui-form-item label {
    position: absolute;
    left: 1px;
    top: 0.5rem;
    width: 38px;
    text-align: center;
}

.login-form .layui-form-item input {
    padding-left: 2.5rem;
}

.captcha {
    width: 55%;
    display: inline-block;
}

.captcha-img {
    display: inline-block;
    vertical-align: top;
    background : url("{{asset ('image/admin/loading-2.gif')}}") no-repeat center;
    min-height: 32px;
}

.captcha-img img {
    border: 1px solid #e6e6e6;
    height: 36px;
    width: 100%;
}

#captchaPic {
    cursor: pointer;
}
</style>
@endsection
@section('content')
<div class="layui-container">
    <div class="background">
        <div class="layui-form login-form">
            <div class="layui-row">
                <div class="layui-form-item logo-title">
                    <h1>{{config('zhihe.name')}}后台登录</h1>
                </div>
                <div class="layui-col-sm12">
                    <form class="layui-form" action="" onsubmit="return false;">
                        <div class="layui-form-item">
                            <label class="layui-icon layui-icon-username" for="username"></label>
                            <input type="text" name="username" lay-verify="required|account" placeholder="用户名"
                                autocomplete="off" class="layui-input" maxlength="20" value="">
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-icon layui-icon-password" for="password"></label>
                            <input type="password" name="password" lay-verify="required|password" placeholder="密码"
                                autocomplete="off" class="layui-input" maxlength="64" value="">
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-icon layui-icon-vercode" for="captcha"></label>
                            <input type="text" name="captcha" placeholder="图形验证码" autocomplete="off"
                                class="layui-input verification captcha" value="" maxlength="4">
                            <div class="captcha-img">
                                <img id="captchaPic" class="layui-hide" alt="验证码图片" src="{{route ('admin.login.captcha')}}" title="点击刷新验证码">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="login">登 入</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
layui.use('form', function() {
    var form = layui.form;
    layer = layui.layer;
    var admin_Menu = "{{route('admin_menu')}}";
    var login = "{{route('admin.login.login')}}";

    $(document).on('click', '#captchaPic', function() {
        captcha = $(this).attr('src');
        captcha += '?t=' + Math.random();
        $(this).attr('src', captcha)
    });

    $('#captchaPic').click().removeClass('layui-hide');

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
                $("#captchaPic").click();
            },
            success: function(data) {
                if (data.code === 1) {
                    layer.msg(data.message, {
                        icon: 6,
                        time: SUCCESS_TIME,
                        shade: 0.2
                    });
                    setTimeout(function() {
                        window.location = admin_Menu;
                    }, SUCCESS_TIME);
                } else {
                    top.layer.msg(data.message, {
                        icon: 2,
                        time: FAIL_TIME,
                        shade: 0.3
                    });
                    if (data.refresh === true) {
                        $("#captchaPic").click();
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