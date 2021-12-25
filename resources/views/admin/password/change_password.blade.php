@extends('common.template')
@section('content')
    <div class="layui-form layuimini-form">

        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">账号名称</label>
                <div class="layui-input-block">
                    <input type="text" name="account" autocomplete="off" class="layui-input" disabled
                        value="{{ $data['account'] }}" disabled>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-block">
                    <input type="text" name="user_name" autocomplete="off" class="layui-input"
                        value="{{ $data['user_name'] }}" disabled>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">登录次数</label>
                <div class="layui-input-block">
                    <input type="text" name="login_count" autocomplete="off" class="layui-input"
                        value="{{ $data['login_count'] }}" disabled>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">所属管理组</label>
                <div class="layui-input-block">
                    <input type="text" name="role" autocomplete="off" class="layui-input"
                        value="{{ $data['role_name'] }}" disabled>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">旧密码</label>
                    <div class="layui-input-inline">
                        <input type="text" name="old" autocomplete="off" class="layui-input" value="" maxlength="12">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">新密码</label>
                    <div class="layui-input-inline">
                        <input type="text" name="new" autocomplete="off" class="layui-input" maxlength="12">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">再次输入</label>
                    <div class="layui-input-inline">
                        <input type="text" name="re_new" autocomplete="off" class="layui-input" maxlength="12">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                @if(checkAuth('password_change'))
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
                </div>
                @endif
            </div>
        </form>
    </div>
@endsection
@section('footer')
    <script>
        var savePassword = "{{route('admin_password_change')}}";
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer

            //监听提交
            form.on('submit(save)', function(data) {

                axios({
                        method: 'post',
                        url: savePassword,
                        responseType: 'json',
                        data: {
                            'new' : data.field.new,
                            'old' : data.field.old,
                            're-new' : data.field.re_new,
                        }
                    })
                    .then(function(response) {
                        var res = response.data;
                        if (res.code == 1) {
                            layer.alert(res.msg)
                        } else {
                            layer.alert(res.msg)
                        }
                    });
               
                return false;
            });

        });
    </script>
@endsection
