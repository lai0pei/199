@extends('common.template')
@section('style')
@endsection
@section('content')
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <label class="layui-form-label required">表单名称</label>
            <div class="layui-input-block">
                <input type="hidden" name="id" value="{{ $form['id'] ?? -1 }}">
                <input type="hidden" name="event_id" value="{{ $event_id ?? -1 }}">
                <input type="text" name="name" lay-verify="required" lay-reqtext="请输入表单名称" placeholder="请输入表单名称"
                    value="{{ $form['name'] ?? '' }}" class="layui-input" maxlength="12">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">选项</label>
            <div class="layui-input-block">
                <input type="text" name="option" lay-verify="required" lay-reqtext="请输入表单选项" placeholder="多个选项用英文逗号(,)分隔"
                    value="{{ $form['option'] ?? '' }}" class="layui-input" maxlength="12">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">表单类型</label>
            <div class="layui-input-inline">
                <select name="type" lay-verify="required" lay-reqtext="请选择表单类型" id="selectId">
                    @if (($form['type']?? '' ) == '')
                        @foreach ($type as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @else
                        <option value="{{ $form['type'] }}">{{ $form['type_name'] }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" lay-verify="required" lay-reqtext="请输入排序" placeholder="例如: 0"
                    value="{{ $form['sort'] ?? '' }}" class="layui-input" maxlength="12">
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认保存</button>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var get_role = "{{ route('admin_get_role') }}";
        var save_person = "{{ route('admin_form_add') }}";
        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer,
                $ = layui.$;


            //监听提交
            form.on('submit(saveBtn)', function(data) {
                $.ajax({
                    url: save_person,
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
