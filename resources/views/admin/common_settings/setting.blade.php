@extends('common.template')
@section('style')

@endsection

@section('content')

    <div class="layui-container">
        <div class="layuimini-main">
            <label class="layui-form-label required">活动图片</label>

            <div class="layui-upload">
                <button type="button" class="layui-btn" id="test1">上传图片</button>
                <div class="layui-upload-list">
                  <img class="layui-upload-img" id="demo1">
                  <p id="demoText"></p>
                </div>
                <div style="width: 95px;">
                  <div class="layui-progress layui-progress-big" lay-showpercent="yes" lay-filter="demo">
                    <div class="layui-progress-bar" lay-percent=""></div>
                  </div>
                </div>
              </div>   
               
              <a name="list-progress"> </a>
                
              <div style="margin-top: 10px;">
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var saveSms = "{{route('admin_save_sms')}}";
        var status = "{{$sms['status'] ?? 0}}";



    
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;

  

            //监听提交
            form.on('submit(save)', function(data) {
                    
                      
                    $.ajax({
                    url: saveSms,
                    data: {
                            'data': JSON.stringify(data.field),
                        },
                    method: 'POST',
                    success: function(data) {
                        if (data.code == 1) {
                            layer.msg(data.msg);
                               window.parent.location.reload();
                        } else {
                            layer.msg(data.msg);
                        }
                    }
                });

            });

        });

        //常规使用 - 普通图片上传
  var uploadInst = upload.render({
    elem: '#test1'
    ,url: 'https://httpbin.org/post' //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
    ,before: function(obj){
      //预读本地文件示例，不支持ie8
      obj.preview(function(index, file, result){
        $('#demo1').attr('src', result); //图片链接（base64）
      });
      
      element.progress('demo', '0%'); //进度条复位
      layer.msg('上传中', {icon: 16, time: 0});
    }
    ,done: function(res){
      //如果上传失败
      if(res.code > 0){
        return layer.msg('上传失败');
      }
      //上传成功的一些操作
      //……
      $('#demoText').html(''); //置空上传失败的状态
    }
    ,error: function(){
      //演示失败状态，并实现重传
      var demoText = $('#demoText');
      demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
      demoText.find('.demo-reload').on('click', function(){
        uploadInst.upload();
      });
    }
    //进度条
    ,progress: function(n, elem, e){
      element.progress('demo', n + '%'); //可配合 layui 进度条元素使用
      if(n == 100){
        layer.msg('上传完毕', {icon: 1});
      }
    }
  });
    </script>
@endsection
