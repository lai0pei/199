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
            <form class="layui-form" action="" onsubmit="return false">

                <input type="hidden" value="{{ $data['id'] ?? '' }}" class="layui-input" name="id" disabled>
                <label class="layui-form-label required">会员账号</label>
                <div class="layui-input-block">
                    <input type="text" lay-verify="required" value="{{ $data['user_name'] ?? '' }}" class="layui-input"
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
                            <tr>
                                <td>游戏</td>
                                <td>{{ $data['game'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>电话号码</td>
                                <td>{{ $data['mobile'] ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>发送</td>
                                <td>{{ $data['is_send'] ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>匹配</td>
                                <td>{{ $data['is_match'] ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>IP</td>
                                <td>{{ $data['ip'] ?? '' }}</td>
                            </tr>

                            <tr>
                                <td>派送时间</td>
                                <td>{{ $data['send_time'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>创建时间</td>
                                <td>{{ $data['created_at'] ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>更新时间</td>
                                <td>{{ $data['updated_at'] ?? '' }}</td>
                            </tr>
                            @foreach($data['value'] as $v)
                            <tr>
                                <td>{{$v['name']}}</td>
                                <td>{{ $v['value'] }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
           
                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="radio" name="state" value="0" id="before" title="未审核"
                            {{ ($data['state'] ?? '') == 0 ? 'checked' : '' }}>
                        <input type="radio" name="state" value="1" id="pass" title="通过"
                            {{ ($data['state'] ?? '') == 1 ? 'checked' : '' }}>
                        <input type="radio" name="state" value="2" id="refuse" title="拒绝"
                            {{ ($data['state'] ?? '') == 2 ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">派送信息</label>
                    <div class="layui-input-block">
                        <textarea name="send_remark" lay-verify="required"
                            class="layui-textarea">{{ $data['send_remark'] ?? '' }}</textarea>
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
            var save_audit = "{{ route('admin_audit_sms') }}";

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
                        success: function(res) {
                           
                            if (res.code == 1) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    time: SUCCESS_TIME,
                                    shade: 0.2
                                });
                            
                            setTimeout(function () {
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    
                                parent.$('button[lay-filter="data-search-btn"]').click();//刷新列表
                                parent.layer.close(index); //再执行关闭

                            }, SUCCESS_TIME);
                            } else {
                                layer.msg(res.msg);
                            }
                        }
                    });

                });
            });
        </script>
    @endsection
