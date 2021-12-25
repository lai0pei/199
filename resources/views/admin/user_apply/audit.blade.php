@extends('common.template')
@section('content')
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <form class="layui-form" action="">
                <input type="hidden"
                value="{{ $data['id'] ?? "" }}" class="layui-input" name="id" disabled >
            <label class="layui-form-label required">用户名</label>
            <div class="layui-input-block">
                <input type="text" lay-verify="required"
                    value="{{ $data['username'] ?? "" }}" class="layui-input" disabled >
            </div>
            <br>
            <div class="layui-form-item" >
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="0" id="before" title="未审核" {{($data['status'] ?? '' ) == 0 ? "checked" : ""}}>
                    <input type="radio" name="status" value="1" id="pass" title="通过" {{($data['status'] ?? '' ) == 1 ? "checked" : ""}}>
                    <input type="radio" name="status" value="2" id="refuse" title="拒绝" {{($data['status'] ?? '' ) == 2 ? "checked" : ""}}>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">核审内容</label>
                <div class="layui-input-block">
                  <textarea name="description"  lay-verify="required" class="layui-textarea">{{$data['description'] ?? ''}}</textarea>
                </div>
              </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认保存</button>
                </div>
            </div>
            </form>
        </div>
    @endsection
    @section('footer')
        <script>
            var save_audit = "{{ route('admin_save_audit') }}";
            layui.use(['form'], function() {
                var form = layui.form,
                    layer = layui.layer,
                    $ = layui.$;


                //监听提交
                form.on('submit(saveBtn)', function(data) {
                    $.ajax({
                        url: save_audit,
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

                });
            });
        </script>
    @endsection
