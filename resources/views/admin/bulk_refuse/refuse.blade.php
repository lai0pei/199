@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layuimini-main">

            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">批量拒绝回复内容</label>
                    <div class="layui-input-block">
                      <textarea name="refuse" placeholder="例如: 敬请谅解!" class="layui-textarea">{{$refuse['refuse'] ?? ''}}</textarea>
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
        var saveRefuse= "{{route('admin_bulk_save')}}";
    
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;

  

            //监听提交
            form.on('submit(save)', function(data) {
                
                axios({
                        method: 'post',
                        url: saveRefuse,
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
