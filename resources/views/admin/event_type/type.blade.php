@extends('common.template')
@section('content')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加新活动 </button>
                </div>
            </script>

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
            </script>

        </div>
    </div>
@endsection
@section('footer')
    <script>
        var add_page = "{{ route('admin_add_type') }}";
        var delete_ip = "{{ route('admin_delete_type') }}";
        var api_url = "{{ route('admin_type_list') }}";
    


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
                            field: 'name',
                            width: 100,
                            title: '活动类型',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'status',
                            width: 200,
                            title: '状态',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'sort',
                            width: 200,
                            title: '排序',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'created_at',
                            width: 200,
                            title: '创建时间',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'updated_at',
                            width: 200,
                            title: '更新时间',
                            align: "center",
                            sort: true
                        },
                        {
                            title: '操作',
                            minWidth: 200,
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
                        title: '添加活动类型',
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
                        title: '编辑活动类型',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: add_page + '/' + data.id,
                    });
                    $(window).on("resize", function() {
                        layer.full(index);
                    });
                    return false;
                } else if (obj.event === 'delete') {
                    layer.confirm('确认删除?', function(index) {
                        var id = obj.data.id;
                        axios({
                                method: 'post',
                                url: delete_ip,
                                responseType: 'json',
                                data: {
                                    'id': id,
                                }
                            })
                            .then(function(response) {
                                var res = response.data;
                                if (res.code == 1) {
                                    layer.msg(res.msg);
                                    location.reload();
                                } else {
                                    layer.msg(res.msg);
                                }
                            });
                        layer.close(index);
                    });
                }
            });

        });
    </script>
@endsection
