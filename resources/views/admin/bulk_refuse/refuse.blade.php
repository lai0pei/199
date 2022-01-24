@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layuimini-main">

            <form class="layui-form layui-form-pane" action="" onsubmit="return false">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">批量拒绝回复内容</label>
                    <div class="layui-input-block">
                        <textarea name="refuse" placeholder="例如: 敬请谅解!"
                            class="layui-textarea">{{ $refuse['refuse'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    @if (checkAuth('refuse_edit'))
                        <button class="layui-btn" lay-submit="" lay-filter="save">提交</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var saveRefuse = "{{ route('admin_bulk_save') }}";

        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;



            //监听提交
            form.on('submit(save)', function(data) {

                $.ajax({
                    url: saveRefuse,
                    data: {
                        'data': JSON.stringify(data.field),
                    },
                    method: 'POST',
                    async: false,
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
                        layer.msg(data.msg, { icon: 6, time: SUCCESS_TIME, shade: 0.2 })
                    }
                });

            });

        });
    </script>
@endsection
