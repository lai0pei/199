@extends('common.template')
@section('style')
<style>
.password-form{
    padding-top : 3rem;
}
</style>
@endsection
@section('content')
<div class="layui-container">
    <div class="layui-form layuimini-form password-form">
        <div class="layuimini-main">
        <form class="layui-form" action="" lay-filter="reset_form">
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
                @if (checkAuth('password_change'))
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
                    </div>
                @endif
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script>
        var savePassword = "{{ route('admin_password_change') }}";
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer

            //监听提交
            form.on('submit(save)', function(data) {

                $.ajax({
                    url: savePassword,
                    data: {
                        'new': data.field.new,
                        'old': data.field.old,
                        're-new': data.field.re_new,
                    },
                    method: 'POST',
                    beforeSend: function () {
                        $("#button[lay-filter='save']").removeClass('disabled').prop('disabled', false);
                        loading = layer.load(2)
                    },
                    complete: function () {
                        $("#button[lay-filter='save']").removeClass('disabled').prop('disabled', false);
                        layer.close(loading)
                    },
                    error: function () {
                        layer.msg(AJAX_ERROR_TIP, {
                            icon: 2,
                            time: FAIL_TIME,
                            shade: 0.3
                        });
                    },
                    success: function(data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {icon: 6, time: SUCCESS_TIME, shade: 0.2});
                            location.reload(1);
                        } else {
                            layer.msg(data.msg);
                        }
                    }
                });

                return false;
            });

        });
    </script>
@endsection
