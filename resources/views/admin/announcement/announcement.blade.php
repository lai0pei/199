@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layuimini-main">

            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">公告通知</label>
                    <div class="layui-input-block">
                      <textarea name="announcement"  lay-verify="required" placeholder="填写公告通知" class="layui-textarea">{{$config['announcement'] ?? ''}}</textarea>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    @if (checkAuth('accouncement_edit'))
                    <button class="layui-btn" lay-submit="" lay-filter="save">提交</button>
                    @endif
                  </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var announcementPass= "{{route('admin_announcement_save')}}";
    
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;

  

            //监听提交
            form.on('submit(save)', function(data) {


                    $.ajax({
                    url: announcementPass,
                    data: {
                            'data': JSON.stringify(data.field),
                        },
                    method: 'POST',
                    async : false,
                    success: function(data) {
                        if (data.code == 1) {
                            layer.msg(data.msg, {icon: 6, time: SUCCESS_TIME, shade: 0.2})
                        } else {
                            layer.msg(data.msg, {icon: 6, time: SUCCESS_TIME, shade: 0.2})
                        }
                    }
                });
                   

            });

        });
    </script>
@endsection
