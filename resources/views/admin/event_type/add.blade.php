@extends('common.template')
@section('content')
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <input type="hidden" name="id" value="{{ $type['id'] ?? -1 }}" class="layui-input">
            <label class="layui-form-label required">活动名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" lay-reqtext="活动名不能为空" placeholder="新年优惠"
                    value="{{ $type['name'] ?? '' }}" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" lay-verify="required|ip" lay-reqtext="排序不能为空" placeholder="例如: 0"
                    value="{{ $type['sort'] ?? '' }}" class="layui-input">
            </div>
        </div>
   
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block" style="background:white">
                <input type="radio" id="open" name="status" value="1" title="正常" >
                <input type="radio" id="close" name="status" value="0" title="关闭">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认</button>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var mani_type = "{{ route('admin_mani_type') }}";
        var status = "{{$type['status'] ?? 1}}";
        if(status == 1){
        $('#open').attr('checked',true);
    }else{
        $('#close').attr('checked',true);
    }

        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;




            //监听提交
            form.on('submit(saveBtn)', function(data) {
                $.ajax({
                    url: mani_type,
                    data: data.field,
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


                return false;
            });

        });
    </script>
@endsection
