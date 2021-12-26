@extends('common.template')
@section('content')
    <div class="layui-container">
        <div class="layui-row">
            <form class="layui-form" action="" lay-filter="example" onsubmit="return false;">
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号码 <span class="color-red">*</span></label>
                    <div class="layui-input-block ">
                        <input type="text" class="layui-input" lay-verify="required|phone|number" name="mobile" maxlength="50" autocomplete="off" value="" >
                    </div>
                </div>
                <div class="layui-form-item margin-bottom-submit">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="create">立即提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var addMobile = "{{route('admin_mobile_add')}}";

  

        layui.use(['form'], function () {
            var form = layui.form;
            //监听提交
            form.on('submit(create)', function (data) {
              
                $.ajax({
                    type: 'POST',
                    url: addMobile,
                    data: data.field,
                    dataType: 'json',
                    beforeSend: function () {
                        $("#button[lay-filter='create']").removeClass('disabled').prop('disabled', false);
                        loading = layer.load(2)
                    },
                    complete: function () {
                        $("#button[lay-filter='create']").removeClass('disabled').prop('disabled', false);
                        layer.close(loading)
                    },
                    error: function () {
                        layer.msg(AJAX_ERROR_TIP, {
                            icon: 2,
                            time: FAIL_TIME,
                            shade: 0.3
                        });
                    },
                    success: function (data) {
                        if (data.code === 1) {
                            layer.msg(data.msg, {icon: 6, time: SUCCESS_TIME, shade: 0.2});
                            setTimeout(function () {
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.$('button[lay-filter="data-search-btn"]').click();//刷新列表
                                parent.layer.close(index); //再执行关闭

                            }, SUCCESS_TIME);
                        } else {
                            layer.msg(data.msg, {
                                icon: 2,
                                time: FAIL_TIME,
                                shade: 0.3
                            });
                        }

                    }
                })

                return false;
            });
        });
    </script>
@endsection
