@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layuimini-main">

            <form class="layui-form layui-form-pane" action="" onsubmit="return false">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">游戏列表</label>
                    <div class="layui-input-block">
                      <textarea name="game"  lay-verify="required" placeholder="例如:游戏多多 盈利多多" class="layui-textarea">{{$game['game'] ?? ''}}</textarea>
                    </div>
                  </div>
                  <div class="layui-form-item">
                    @if (checkAuth('game_edit'))
                    <button class="layui-btn" lay-submit="" lay-filter="save">提交</button>
                    @endif
                  </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var gamePass= "{{route('admin_game_save')}}";
    
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;

  

            //监听提交
            form.on('submit(save)', function(data) {
            

                    $.ajax({
                    url: gamePass,
                    data: {
                            'data': JSON.stringify(data.field),
                        },
                    method: 'POST',
                    async : false,
                    success: function(data) {
                        layer.msg(data.msg, { icon: 6, time: SUCCESS_TIME, shade: 0.2 })
                    }
                });
                   
            });

        });
    </script>
@endsection
