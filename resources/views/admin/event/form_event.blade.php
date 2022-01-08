@extends('common.template')
@section('content')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <fieldset class="table-search-fieldset" style="display: none">
                <legend>搜索信息</legend>
                <div style="margin: 10px 10px 10px 10px"> 
                    <form class="layui-form layui-form-pane" lay-filter="data-search-filter" action="">
                        <div class="layui-form-item">
                         
                            <div class="layui-inline">
                                <label class="layui-form-label">表单名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="id" value="{{ $id ?? -1 }}" class="layui-input">
                                    <input type="text" name="name" autocomplete="off" placeholder="请输入活动名称"
                                        class="layui-input">
                                </div>
                            </div>
                            <div class="layui-btn-container">
                                <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-submit
                                lay-filter="data-search-btn">刷新列表</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="add" > 添加活动表单 </button>
                </div>
               
            </script>
           
            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑表单</a>
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
            </script>

        </div>
    </div>
@endsection
@section('footer')
    <script>
        var add_page = "{{ route('admin_form_detail') }}";
        var delete_ip = "{{ route('admin_form_delete') }}";
        var api_url = "{{ route('admin_form_list') }}";
        var event_id = "{{ $id }}";



        layui.use(['form', 'table'], function() {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table;

            table.render({
                elem: '#currentTableId',
                url: api_url,
                where: {
                    'id': event_id,
                },
                even : true,
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
                            title: '表单名称',
                            align: "center",
                            sort: true
                        },
                        {
                            field: 'event',
                            width: 200,
                            title: '所属活动',
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
                            field: 'option',
                            width: 200,
                            title: '表单类型',
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
                console.log(obj.data);
                if (obj.event === 'add') { // 监听添加操作
                    var index = layer.open({
                        title: '添加活动表单',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['80%', '80%'],
                        content: add_page + "/" + event_id
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
                        title: '编辑活动表单',
                        type: 2,
                        shade: 0.2,
                        maxmin: false,
                        shadeClose: true,
                        area: ['60%', '60%'],
                        content: add_page + "/" + event_id + "/" + data.id,
                    });
                    $(window).on("resize", function() {
                        layer.full(index);
                    });
                    return false;
                } else if (obj.event === 'delete') {
                    layer.confirm('确认删除?', function(index) {
                        var id = obj.data.id;


                        $.ajax({
                            url: delete_ip,
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
                                        var index = layer.getFrameIndex(window
                                            .name); //先得到当前iframe层的索引
                                        $('button[lay-filter="data-search-btn"]')
                                            .click(); //刷新列表
                                        layer.close(index); //再执行关闭

                                    }, SUCCESS_TIME)
                                } else {
                                    layer.msg(data.msg);
                                }
                            }
                        });
                        layer.close(index);
                    });
                }
            });

        });
    </script>
@endsection
