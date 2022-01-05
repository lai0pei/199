@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layuimini-main">

            <form class="layui-form layui-form-pane" action="" onsubmit="return false">
                <div class="layui-form-item">
                    <label class="layui-form-label required">首页</label>
                    <div class="layui-input-block">
                        <input type="text" name="home" lay-verify="required|url" lay-reqtext="首页前台" placeholder="请输入前台链接"
                            value="{{ $link['home'] ?? '' }}" class="layui-input">

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">新版APP</label>
                    <div class="layui-input-block">
                        <input type="text" name="app" lay-verify="required|url" lay-reqtext="下载新版APP"
                            placeholder="请输入下载新版APP链接" value="{{ $link['app'] ?? '' }}" class="layui-input">

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">线路检测</label>
                    <div class="layui-input-block">
                        <input type="text" name="speed" lay-verify="required|url" lay-reqtext="线路检测" placeholder="请输入线路检测链接"
                            value="{{ $link['speed'] ?? '' }}" class="layui-input">

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">在线客服</label>
                    <div class="layui-input-block">
                        <input type="text" name="chat" lay-verify="required|url" lay-reqtext="在线客服" placeholder="请输入在线客服链接"
                            value="{{ $link['chat'] ?? '' }}" class="layui-input">

                    </div>
                </div>

                <div class="layui-form-item">
                    @if (checkAuth('link_edit'))
                    <button class="layui-btn" lay-submit="" lay-filter="save">提交</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var linkRefuse = "{{ route('admin_link_save') }}";

        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;



            //监听提交
            form.on('submit(save)', function(data) {

                $.ajax({
                    url: linkRefuse,
                    data: {
                        'data': JSON.stringify(data.field),
                    },
                    method: 'POST',
                    async : false,
                    success: function(data) {
                        if (data.code == 1) {
                            layer.msg(data.msg);
                           location.reload();
                        } else {
                            layer.msg(data.msg);
                        }
                    }
                });


            });

        });
    </script>
@endsection
