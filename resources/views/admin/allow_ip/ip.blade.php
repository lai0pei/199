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
                                <label class="layui-form-label">IP</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="ip" autocomplete="off" class="layui-input" placeholder="例如:127.0.0.1">
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
                <div class="layui-btn-container">
                    @if (checkAuth('ip_add'))
                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add"> 添加IP地址 </button>
                    @endif
                </div>
            </script>

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                @if (checkAuth('ip_edit'))
                <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
                @endif
                @if (checkAuth('ip_delete'))
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
                @endif
            </script>

        </div>
    </div>
@endsection
@section('footer')
    <script>
        var add_page = "{{ route('admin_add_ip') }}";
        var delete_ip = "{{ route('admin_delete_ip') }}";
        var api_url = "{{ route('admin_ip_list') }}";



        layui.use(['form', 'table'], function() {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table;

            table.render({
                elem: '#currentTableId',
                url: api_url,
                toolbar: '#toolbarDemo',
                defaultToolbar: ['filter', 'exports', 'print', ],
                even : true,
                cols: [
                    [{
                            field: 'id',
                            width: 100,
                            title: '编号',
                            sort: true,
                            align: "center"
                        },
                        {
                            field: 'ip',
                            width: 100,
                            title: 'IP',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'description',
                            width: 200,
                            title: '备注',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'username',
                            width: 200,
                            title: '操作管理员',
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
                        title: '添加IP',
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
                        title: '编辑IP',
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
                        $.ajax({
                            type: 'POST',
                            url: delete_ip,
                            data: {
                                'id': id,
                            },
                            async : false,
                            dataType: 'json',
                            beforeSend: function() {
                                $("#button[lay-filter='create']").removeClass(
                                    'disabled').prop('disabled', false);
                                loading = layer.load(2)
                            },
                            complete: function() {
                                $("#button[lay-filter='create']").removeClass(
                                    'disabled').prop('disabled', false);
                                layer.close(loading)
                            },
                            error: function() {
                                layer.msg(AJAX_ERROR_TIP, {
                                    icon: 2,
                                    time: FAIL_TIME,
                                    shade: 0.3
                                });
                            },
                            success: function(data) {
                                if (data.code === 1) {
                                    layer.msg(data.msg, {icon: 6, time: SUCCESS_TIME, shade: 0.2});
                            setTimeout(function () {
                                var index = layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                $('button[lay-filter="data-search-btn"]').click();//刷新列表
                               layer.close(index); //再执行关闭

                            }, SUCCESS_TIME)
                                } else {
                                    layer.msg(data.msg, {
                                        icon: 2,
                                        time: FAIL_TIME,
                                        shade: 0.3
                                    });
                                }

                            }
                        })
                    });
                }
            });

        });
    </script>
@endsection
