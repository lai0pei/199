@extends('common.template')
@section('content')
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="account" lay-verify="required" lay-reqtext="用户名不能为空" placeholder="请输入用户名" value=""
                    class="layui-input" maxlength="12">
                <tip>填写登录账号的名称。</tip>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">昵称</label>
            <div class="layui-input-block">
                <input type="text" name="username" lay-verify="required" lay-reqtext="昵称名不能为空" placeholder="请输入昵称" value=""
                    class="layui-input" maxlength="12">
                <tip>填写管理员显示的名称。</tip>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" lay-verify="required" lay-reqtext="密码不能为空" placeholder="请输入密码"
                    value="" class="layui-input" maxlength="12">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系号码</label>
            <div class="layui-input-block">
                <input type="number" name="number" placeholder="请输入飞机联系号" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="开启" checked="checked">
                <input type="radio" name="status" value="0" title="禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择角色</label>
            <div class="layui-input-block">
                <select name="role" lay-filter="aihao" lay-verify="required" lay-reqtext="角色不能为空" id="selectId">
                    <option></option>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认保存</button>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var add_person = "{{ route('admin_add_person') }}";
        var get_role = "{{ route('admin_get_role') }}";


        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer,
                $ = layui.$;

            $('document').ready(function() {
                $.ajax({
                    url: get_role,
                    dataType: 'json',
                    method: 'GET',
                    success: function(data) {
                        if (data.expire == 1) {
                            layer.msg(data.msg, {
                                icon: 6,
                                time: LOGOUT_TIME,
                                shade: 0.2
                            });
                            setTimeout(function() {

                                parent.location.reload(1);


                            }, LOGOUT_TIME)

                        }
                        var list = data.data;
                        if (data.code == 1) {
                            $.each(list, function(index, item) {

                                //option 第一个参数是页面显示的值，第二个参数是传递到后台的值
                                $('#selectId').append(new Option(item.role_name, item
                                    .id)); //往下拉菜单里添加元素
                                //设置value（这个值就可以是在更新的时候后台传递到前台的值）为2的值为默认选中
                                $('#selectId').val(1);
                            });
                            form.render();
                        }
                    }
                });
            });

            //监听提交
            form.on('submit(saveBtn)', function(data) {
                $.ajax({
                    url: add_person,
                    data: data.field,
                    method: 'POST',
                    success: function(data) {
                        if (data.expire == 1) {
                            layer.msg(data.msg, {
                                icon: 6,
                                time: LOGOUT_TIME,
                                shade: 0.2
                            });
                            setTimeout(function() {

                                parent.location.reload(1);


                            }, LOGOUT_TIME)

                        }
                        if (data.code == 1) {
                            layer.msg(data.msg, {icon: 6, time: SUCCESS_TIME, shade: 0.2});
                            setTimeout(function () {
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.$('button[lay-filter="data-search-btn"]').click();//刷新列表
                                parent.layer.close(index); //再执行关闭

                            }, SUCCESS_TIME)

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
