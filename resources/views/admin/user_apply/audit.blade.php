@extends('common.template')
@section('style')
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

    </style>
@endsection
@section('content')
    <div class="layui-form layuimini-form">
        <div class="layui-form-item">
            <form class="layui-form" action="">
                <input type="hidden" value="{{ $data['id'] ?? '' }}" class="layui-input" name="id" disabled>
                <label class="layui-form-label required">用户名</label>
                <div class="layui-input-block">
                    <input type="text" lay-verify="required" value="{{ $data['username'] ?? '' }}" class="layui-input"
                        disabled>
                </div>
                <br>
                <div class="layui-form-item">
                    <label class="layui-form-label required">申请信息</label>
                    <div class="layui-input-block">
                        <table>
                            <tr>
                                <th>名称</th>
                                <th>内容</th>
                            </tr>
                            @foreach ($data['value'] as $v)
                                <tr>
                                    <td>{{ $v['name'] }}</td>
                                    @if(($v['type'] ?? '' == "photo"))
                                    <td><img src={{ $v['value'] }} alt='图片'></td>
                                    @else
                                    <td>{{ $v['value'] }}</td>
                                    @endif
                                    
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="0" id="before" title="未审核"
                            {{ ($data['status'] ?? '') == 0 ? 'checked' : '' }}>
                        <input type="radio" name="status" value="1" id="pass" title="通过"
                            {{ ($data['status'] ?? '') == 1 ? 'checked' : '' }}>
                        <input type="radio" name="status" value="2" id="refuse" title="拒绝"
                            {{ ($data['status'] ?? '') == 2 ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">核审内容</label>
                    <div class="layui-input-block">
                        <textarea name="description" lay-verify="required"
                            class="layui-textarea">{{ $data['description'] ?? '' }}</textarea>
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
                    layer = layui.layer;


                //监听提交
                form.on('submit(saveBtn)', function(data) {
                    $.ajax({
                        url: save_audit,
                        data: data.field,
                        method: 'POST',
                        success: function(res) {

                            layer.msg(res.msg, {
                                icon: 6,
                                time: SUCCESS_TIME,
                                shade: 0.2
                            });

                            setTimeout(function() {
                                console.log("hir");
                                var index = layer.getFrameIndex(window
                                .name); //先得到当前iframe层的索引
                                console.log(index);
                                parent.$('button[lay-filter="data-search-btn"]')
                            .click(); //刷新列表
                                parent.layer.close(index); //再执行关闭

                            }, SUCCESS_TIME);

                        }
                    });
                });
            });
        </script>
    @endsection
