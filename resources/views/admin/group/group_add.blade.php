@extends('common.template')
@section('content')
    <div class="layui-container">
        <div class="layui-row">
            <form class="layui-form" action="" lay-filter="example" onsubmit="return false;">
                <input type="hidden" name="id" value="{{ $role->id ?? '-1' }}">
                <div class="layui-form-item">
                    <label class="layui-form-label">角色名称 <span class="color-red">*</span></label>
                    <div class="layui-input-block ">
                        <input type="text" class="layui-input " name="role_name" maxlength="50" autocomplete="off"
                            value="{{ $role->role_name ?? '' }}">
                    </div>
                </div>
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="1" id="radioOpen" title="开启">
                        <input type="radio" name="status" value="0" id="radioClose" title="禁用">
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
        var maniPage = "{{ route('group_add') }}";

        //check status
        var status = "{{ $role->status ?? 1 }}";
        if (status == 1) {
            $('#radioOpen').attr('checked', true);
        } else {
            $('#radioClose').attr('checked', true);
        }

        layui.use(['form', 'laydate', 'layarea', 'table', 'tableSelect'], function() {
            var form = layui.form,
                layer = layui.layer,
                laydate = layui.laydate,
                layarea = layui.layarea;
            table = layui.layarea;
            //监听提交
            form.on('submit(create)', function(data) {
                var id = data.field.id;
                _url = maniPage;

                $.ajax({
                    type: 'POST',
                    url: _url,
                    data: data.field,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#button[lay-filter='create']").removeClass('disabled').prop(
                            'disabled', false);
                        loading = layer.load(2)
                    },
                    complete: function() {
                        $("#button[lay-filter='create']").removeClass('disabled').prop(
                            'disabled', false);
                        layer.close(loading)
                    },
                    error: function() {
                        layer.msg(AJAX_ERROR_TIP, {
                            icon: 2,
                            time: FAIL_TIME,
                            shade: 0.3
                        });
                    },
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
                        if (data.code === 1) {
                            layer.msg(data.msg, {
                                icon: 6,
                                time: SUCCESS_TIME,
                                shade: 0.2
                            });
                            setTimeout(function() {
                                var index = parent.layer.getFrameIndex(window
                                .name); //先得到当前iframe层的索引
                                parent.$('button[lay-filter="data-search-btn"]')
                            .click(); //刷新列表
                                parent.layer.close(index); //再执行关闭

                            }, SUCCESS_TIME)
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
