@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <div class="layui-form layuimini-form">
            <div class="layui-form-item">
            <div class="layui-input-block">
                    <button type="button" class="layui-btn" id="sms_import"
                        title="导入数据会更改到现有数据中">选择导入的文件</button>
            </div>
            </div>
            <div class="layui-form-item" pane="">
                <label class="layui-form-label">审核状态</label>
                <div class="layui-input-block">
                    <input type="radio"  id="status" name="status" value="1" title="通过" lay-filter="ChoiceRadio" checked>
                    <input type="radio" id="status" name="status" value="2" title="拒绝"  lay-filter="ChoiceRadio">
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        
        var uploadExcel = "{{route('sms_import_mani')}}";
        layui.use([ 'upload', 'layer', 'element','form'], function() {
            var $ = layui.jquery,
                upload = layui.upload,
                element = layui.element,
                form = layui.form,
                layer = layui.layer;

              window.stat = 1;
                    form.on('radio(ChoiceRadio)', function(data){
                        window.stat = data.value;
                  
                        });
             
              
            //常规使用 - 普通图片上传
            var uploadInst = upload.render({
                elem: '#sms_import',
                url: uploadExcel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
                    ,
                accept: "file",
                //  exts: 'xls|xlsx|xlsm|xlt|xltx|xltm',
                exts: 'xls|xlsx|csv',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                before: function(obj) {
                   
                    //预读本地文件示例，不支持ie8
                    this.data.status = window.stat;
             
                    element.progress('demo', '0%'); //进度条复位
                    layer.msg('文件导入中,请耐心等待。。。', {
                        icon: 16,
                        time: 0
                    });
                },
                done: function(data) {
                    //如果上传失败
                    layer.msg(data.msg, {
                        icon: 6,
                        time: SUCCESS_TIME,
                        shade: 0.2
                    });
                    setTimeout(function() {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.$('button[lay-filter="data-search-btn"]').click(); //刷新列表
                        parent.layer.close(index); //再执行关闭

                    }, SUCCESS_TIME)
                },
            });
        });
    </script>

@endsection
