@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layuimini-main">

            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">批量拒绝通过内容</label>
                    <div class="layui-input-block">
                      <textarea name="pass" placeholder="例如:祝您游戏盈!" class="layui-textarea">{{$pass['pass'] ?? ''}}</textarea>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    <button class="layui-btn" lay-submit="" lay-filter="save">提交</button>
                  </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var savePass= "{{route('admin_pass_save')}}";
    
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;

  

            //监听提交
            form.on('submit(save)', function(data) {
                
                axios({
                        method: 'post',
                        url: savePass,
                        data: {
                            'data': JSON.stringify(data.field),
                        }
                    })
                    .then(function(response) {
                        var res = response.data;
                        if (res.code == 1) {
                            layer.msg(res.msg);
                        }
                          
                    });
                   

            });

        });
    </script>
@endsection
