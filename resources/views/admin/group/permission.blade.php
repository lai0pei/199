@extends('common.template')
@section('style')
@endSection
@section('content')
    <div class="layui-btn-container">

    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">组名称 <span class="color-red">*</span></label>
        <div class="layui-input-block ">
            <input type="text" class="layui-input " name="role_name" maxlength="50" autocomplete="off"
                value="{{ $role['role_name'] ?? '' }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">角色名称 <span class="color-red">*</span></label>
        <div class="layui-input-block ">
            <div id="auth_permission" class="demo-tree-more"></div>
        </div>
    </div>
    {{-- <div id="test9" class="demo-tree demo-tree-box" style="width: 200px; height: 300px; overflow: scroll;"></div> --}}
    <div class="layui-form-item text-center">
        <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit="system.auth/saveAuthorize"
            lay-filter="save_form_1" lay-demo="getChecked">确认</button>
    </div>
@endsection

@section('footer')
    <script>
        var getPermission = "{{ route('admin_permission_list') }}";
        var submitPermission = "{{ route('admin_submit_list') }}";
        var id = "{{ $role['id'] }}";

        layui.use(['tree', 'util'], function() {
            var tree = layui.tree,
                layer = layui.layer,
                util = layui.util;


            //模拟数据

            $(document).ready(function(obj) {
                console.log(obj);

                $.ajax({
                    type: "POST",
                    url: getPermission,
                    data: {
                        "id": id,
                    },
                    success: function(data) {
                        let list = data.data;
                        console.log(list);
                        if (data.code == 1) {}
                        //基本演示
                        tree.render({
                            elem: '#auth_permission',
                            data: list,
                            showCheckbox: true //是否显示复选框
                                ,
                                accordion : true,
                            id: 'demoId1',
                            isJump: false //是否允许点击节点时弹出新窗口跳转
                        });
                    },
                });
            });


            //按钮事件
            util.event('lay-demo', {
                getChecked: function(othis) {
                    var checkedData = tree.getChecked('demoId1'); //获取选中节点的数据

                    axios({
                            method: 'post',
                            url: submitPermission,
                            responseType: 'json',
                            data: {
                                'id': id,
                                'checked' : JSON.stringify(checkedData),
                            }
                        })
                        .then(function(response) {
                            var res = response.data;
                            if (res.code == 1) {
                                layer.msg(res.msg);
                              
                            } else {
                                layer.msg(res.msg);
                            }
                        });
                        setTimeout(function () {
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.$('button[lay-filter="data-search-btn"]').click();//刷新列表
                                parent.layer.close(index); //再执行关闭

                            }, SUCCESS_TIME)
                      

                }
            });

        });
    </script>
@endsection
