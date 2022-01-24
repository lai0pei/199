@extends('common.template')
@section('content')
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <input type="hidden" name="id" value="{{ $ip['id'] ?? -1 }}" class="layui-input">
            <label class="layui-form-label required">ip</label>
            <div class="layui-input-block">
                <input type="text" name="ip" lay-verify="required|ip" lay-reqtext="ip不能为空" placeholder="例如:127.0.0.1"
                    value="{{ $ip['ip'] ?? '' }}" class="layui-input" maxlength="12">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">内容</label>
            <div class="layui-input-block">
                <input type="text" name="description" placeholder="例如:特别指定允许" value="{{ $ip['description'] ?? '' }}"
                    class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认</button>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var mani_ip = "{{ route('admin_mani_ip') }}";



        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;


            form.verify({
                ip: [
                    /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/,
                    'IP地址不符合规则'
                ]
            });

            //监听提交
            form.on('submit(saveBtn)', function(data) {
                $.ajax({
                    url: mani_ip,
                    data: data.field,
                    method: 'POST',
                    async : false,
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
