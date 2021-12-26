@extends('common.template')
@section('content')
    <div class="layuimini-container">
        <div class="layuimini-main">

            <fieldset class="table-search-fieldset">
                <legend>搜索信息</legend>
                <div style="margin: 10px 10px 10px 10px">
                    <form class="layui-form layui-form-pane" lay-filter="data-search-filter" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">所属角色</label>
                                <div class="layui-input-inline">
                                    <select name="role_id">
                                        <option value="">请选择</option>

                                        @foreach ($data['role'] as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['role_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">用户名</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="account" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">昵称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="user_name" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">状态</label>
                                <div class="layui-input-inline">
                                    <select name="status">
                                        <option value="">请选择</option>
                                        @foreach ($data['status'] as $ind => $item)
                                            <option value="{{ $ind }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <button type="submit" class="layui-btn layui-btn-primary" lay-submit
                                    lay-filter="data-search-btn"><i class="layui-icon"></i> 搜索 或 快速刷新
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
            <script type="text/html" id="toolbarDemo">
                @if (checkAuth('admin_add'))
                    <div class="layui-btn-container">
                        <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加管理员 </button>
                    </div>
                @endif
            </script>

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                @if (checkAuth('admin_view'))
                    <a class="layui-btn layui-btn-xs layui-btn-warm data-count-view" lay-event="view">查看</a>
                @endif
                @if (checkAuth('admin_edit'))
                    <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
                @endif
                @if (checkAuth('admin_delete'))
                    <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
                @endif
            </script>

        </div>
    </div>
@endsection
@section('footer')
    <script>
        var edit_page = "{{ route('admin_person_edit') }}";
        var view_page = "{{ route('admin_person_view') }}";
        var add_page = "{{ route('admin_person_add') }}";
        var delete_page = "{{ route('admin_person_delete') }}";
        var api_url = "{{ route('admin.admin_list') }}";


        layui.use(['form', 'table'], function() {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table;

            table.render({
                elem: '#currentTableId',
                url: api_url,
                toolbar: '#toolbarDemo',
                defaultToolbar: ['filter', 'exports', 'print', ],
                cols: [
                    [{
                            field: 'id',
                            width: 100,
                            title: '编号',
                            sort: true,
                            align: "center"
                        },
                        {
                            field: 'account',
                            width: 100,
                            title: '用户名',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'user_name',
                            width: 100,
                            title: '昵称',
                            align: "center"
                        },
                        {
                            field: 'last_ip',
                            width: 150,
                            title: '最后登录Ip',
                            align: "center"
                        },
                        {
                            field: 'status',
                            title: '状态',
                            width: 100,
                            sort: true,
                            align: "center"
                        },
                        {
                            field: 'role_name',
                            width: 150,
                            title: '角色',
                            align: "center"
                        },
                        {
                            field: 'login_count',
                            width: 150,
                            title: '登录次数',
                            sort: true,
                            align: "center"
                        },
                        {
                            field: 'last_date',
                            width: 180,
                            title: '最后登录时间',
                            sort: true,
                            align: "center"
                        },
                        {
                            title: '操作',
                            minWidth: 100,
                            toolbar: '#currentTableBar',
                            align: "center"
                        }
                    ]
                ],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true,
                // skin: 'line'
            });

            // 监听搜索操作
            form.on('submit(data-search-btn)', function(data) {
                var result = JSON.stringify(data.field);
                // layer.alert(result, {
                //     title: '最终的搜索信息'
                // });

                //执行搜索重载
                table.reload('currentTableId', {
                    page: {
                        curr: 1
                    },
                    where: {
                        searchParams: result
                    }
                }, 'data');

                return false;
            });
            /**
             * toolbar监听事件
             */
            table.on('toolbar(currentTableFilter)', function(obj) {
                if (obj.event === 'add') { // 监听添加操作
                    var index = layer.open({
                        title: '添加用户',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: add_page,
                    });
                    $(window).on("resize", function() {
                        layer.full(index);
                    });
                } else if (obj.event === 'delete') { // 监听删除操作
                    var checkStatus = table.checkStatus('currentTableId'),
                        data = checkStatus.data;
                    layer.alert(JSON.stringify(data));
                }
            });

            table.on('tool(currentTableFilter)', function(obj) {
                var data = obj.data;
                if (obj.event === 'edit') {

                    var index = layer.open({
                        title: '编辑用户',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: edit_page + '/' + data.id,
                    });
                    $(window).on("resize", function() {
                        layer.full(index);
                    });
                    return false;
                } else if (obj.event === 'view') {

                    var index = layer.open({
                        title: '查看用户',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: view_page + '/' + data.id,
                    });
                    $(window).on("resize", function() {
                        layer.full(index);
                    });
                    return false;
                } else if (obj.event === 'delete') {
                    layer.confirm('确认删除?', function(index) {
                        var id = obj.data.id;


                        $.ajax({
                            url: delete_page,
                            data: {
                                'id': id,
                            },
                            method: 'POST',
                            success: function(data) {
                                if (data.code == 1) {
                                    layer.msg(data.msg, {
                                        icon: 6,
                                        time: SUCCESS_TIME,
                                        shade: 0.2
                                    });
                                    setTimeout(function() {
                                        $('button[lay-filter="data-search-btn"]').click(); //刷新列表

                                    }, SUCCESS_TIME)

                                } else {
                                    layer.msg(data.msg);
                                }
                            }
                        });


                    });
                }
            });
        });
    </script>
@endsection
