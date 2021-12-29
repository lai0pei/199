@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layuimini-container">
        <div class="layuimini-main">

            <fieldset class="table-search-fieldset">
                <legend>搜索信息</legend>
                <div style="margin: 10px 10px 10px 10px">
                    <form class="layui-form layui-form-pane" lay-filter="data-search-filter" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">所有活动</label>
                                <div class="layui-input-inline">
                                    <select name="event_id">
                                        <option value="">请选择</option>
                                        @foreach ($eventList as $ind => $item)
                                            <option value="{{ $item['id'] ?? '' }}">{{ $item['name'] ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">显示</label>
                                <div class="layui-input-inline">
                                    <select name="status">
                                        <option value="">请选择</option>
                                        @foreach ($status as $ind => $item)
                                            <option value="{{ $ind }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">用户名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="username" autocomplete="off" placeholder="请输入用户名称"
                                        class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">用户Ip</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="ip" autocomplete="off" placeholder="请输入用户Ip"
                                        class="layui-input">
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

            <script type="text/html" id="toolbarFilter">
                <div class="layui-btn-container">
                    @if (checkAuth('apply_bulk_delete'))
                        <button class="layui-btn layui-btn-danger layui-btn-sm data-add-btn" lay-event="batch-delete"> 批量删除 </button>
                    @endif
                    @if (checkAuth('apply_bulk_pass'))
                        <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="batch-pass"> 批量通过 </button>
                    @endif
                    @if (checkAuth('apply_bulk_refuse'))
                        <button class="layui-btn layui-btn-warm layui-btn-sm data-add-btn" lay-event="batch-refuse"> 批量拒绝 </button>
                    @endif
                </div>
            </script>

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                @if (checkAuth('apply_edit'))
                    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="audit">审核操作</a>
                @endif
            </script>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var getUserList = "{{ route('admin_user_list') }}";
        var deleteUser = "{{ route('admin_delete_audit') }}";
        var audit = "{{ route('admin_user_audit') }}";
        var refuse = "{{ route('admin_bulk_refuse') }}";
        var pass = "{{ route('admin_bulk_pass') }}";



        layui.use(['form', 'table', 'laydate'], function() {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table,
                layuimini = layui.layuimini;
            laydate = layui.laydate;
            form.render();

            table.render({
                elem: '#currentTableId',
                url: getUserList,
                toolbar: '#toolbarFilter',
                defaultToolbar: ['filter'],
                cols: [
                    [{
                            type: 'checkbox',
                        }, {
                            field: 'id',
                            title: '编号',
                            width: 100,
                            sort: true
                        },
                        {
                            field: 'username',
                            title: '用户名称',
                            width: 120,
                            sort: true
                        },
                        {
                            field: 'event',
                            title: '活动名称',
                            sort: true
                        },
                        {
                            field: 'apply_time',
                            title: '申请时间',
                            sort: true
                        },
                        {
                            field: 'status_text',
                            title: '审核状态',
                            sort: true
                        },
                        {
                            field: 'ip',
                            title: 'IP地址',
                            sort: true
                        },
                        {
                            field: 'description',
                            title: '备注内容',
                            sort: true
                        },
                        {
                            field: 'created_at',
                            title: '创建时间',
                            sort: true
                        },
                        {
                            title: '操作',
                            width: 220,
                            templet: '#currentTableBar',
                            fixed: "right",
                            align: "center"
                        }
                    ]
                ],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true,
            });
            //日期
            laydate.render({
                elem: '#created_at',
                trigger: 'click',
                range: false
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
            //监听表格复选框选择
            table.on('checkbox(currentTableFilter)', function(obj) {
                console.log(obj)
            });

            table.on('toolbar(currentTableFilter)', function(obj) {
                console.log(obj);
                var data = form.val("data-search-filter");
                var searchParams = JSON.stringify(data);
                switch (obj.event) {
                    case 'add':
                        var index = layer.open({
                            title: '',
                            type: 2,
                            shade: 0.2,
                            maxmin: false,
                            shadeClose: false,
                            area: ['60%', '65%'],
                            content: '/admin/' + MODULE_NAME + '/create',
                        });
                        break;
                    case 'batch-delete':
                        layer.confirm('确认删除?', function(index) {
                            var checkStatus = table.checkStatus('currentTableId'),
                                data = checkStatus.data;

                            $.ajax({
                                url: deleteUser,
                                data: {
                                    'data': data,
                                },
                                method: 'POST',
                                success: function(res) {
                                    layer.msg('删除' + data.length + '条记录', {
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

                                    }, SUCCESS_TIME);

                                }
                            });
                        });
                        break;
                    case 'batch-pass':
                        layer.confirm('确认通过?', function(index) {
                            var checkStatus = table.checkStatus('currentTableId'),
                                data = checkStatus.data;

                            $.ajax({
                                url: pass,
                                data: {
                                    'data': data,
                                },
                                method: 'POST',
                                success: function(res) {

                                    layer.msg('审核通过' + data.length + '条记录', {
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

                                    }, SUCCESS_TIME);
                                }
                            });


                            layer.close(index);
                        });
                        break;
                    case 'batch-refuse':
                        layer.confirm('确认拒绝?', function(index) {
                            var checkStatus = table.checkStatus('currentTableId'),
                                data = checkStatus.data;


                            $.ajax({
                                url: refuse,
                                data: {
                                    'data': data,
                                },
                                method: 'POST',
                                success: function(res) {
                                   
                                    layer.msg('审核拒绝' + data.length + '条记录', {
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

                                    }, SUCCESS_TIME);
                                }
                            });


                            layer.close(index);
                        });
                        break;
                    case 'link':
                        setTimeout(function() {
                            table.resize(); //
                        }, TABLE_RESIZE_TIME);
                        break;
                    case 'export_data':
                        window.location.href = '/admin/' + MODULE_NAME +
                            '/export?searchParams=' +
                            searchParams;
                        break;
                    case 'LAYTABLE_TIPS':
                        top.layer_module_tips(MODULE_NAME);
                        break;
                }
            });
            table.on('tool(currentTableFilter)', function(obj) {
                var data = obj.data;
                switch (obj.event) {
                    case 'view':
                        var index = layer.open({
                            title: '表单配置',
                            type: 2,
                            shade: 0.2,
                            maxmin: true,
                            shadeClose: true,
                            area: ['100%', '100%'],
                            content: viewForm + '/' + data.id,
                        });
                        break;
                    case 'audit':
                        var index = layer.open({
                            title: '核审活动',
                            type: 2,
                            shade: 0.2,
                            maxmin: true,
                            shadeClose: true,
                            area: ['100%', '100%'],
                            content: audit + '/' + data.id,
                        });
                        break;
                    case 'delete': {
                        layer.confirm('确认删除?', function(index) {
                            var id = obj.data.id;

                            $.ajax({
                                url: deleteEvent,
                                data: {
                                    'id': id,
                                },
                                method: 'POST',
                                success: function(data) {
                                    if (data.code == 1) {
                                        layer.msg('审核拒绝' + data.length + '条记录', {
                                            icon: 6
                                        });
                                        location.reload();
                                    } else {
                                        layer.msg(data.msg);
                                    }
                                }
                            });

                            layer.close(index);
                        });
                    }

                    break;

                }
            });

            //监听排序事件
            table.on('sort(currentTableFilter)', function(
                obj) { //注：sort 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
                // console.log(obj.field); //当前排序的字段名
                // console.log(obj.type); //当前排序类型：desc（降序）、asc（升序）、null（空对象，默认排序）
                // console.log(this); //当前排序的 th 对象

                //尽管我们的 table 自带排序功能，但并没有请求服务端。
                //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                table.reload('currentTableId', {
                    initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                        ,
                    where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                        field: obj.field //排序字段
                            ,
                        order: obj.type //排序方式
                    }
                });

                // layer.msg('服务端排序。order by '+ obj.field + ' ' + obj.type);
            });
        });
    </script>
@endsection