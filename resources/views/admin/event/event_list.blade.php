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
                                <label class="layui-form-label">活动类型</label>
                                <div class="layui-input-inline">
                                    <select name="type_id">
                                        <option value="">请选择</option>
                                        @foreach ($data as $ind => $item)
                                            <option value="{{ $ind + 1 }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">状态</label>
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
                                <label class="layui-form-label">限制</label>
                                <div class="layui-input-inline">
                                    <select name="is_daily">
                                        <option value="">请选择</option>
                                        @foreach ($daily as $ind => $item)
                                            <option value="{{ $ind }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">显示</label>
                                <div class="layui-input-inline">
                                    <select name="display">
                                        <option value="">请选择</option>
                                        @foreach ($display as $ind => $item)
                                            <option value="{{ $ind }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">活动名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="name" autocomplete="off" placeholder="请输入活动名称"
                                        class="layui-input">
                                </div>
                            </div>

                            <div class="layui-inline">
                                <button type="submit" class="layui-btn layui-btn-primary" lay-submit
                                    lay-filter="data-search-btn"><i class="layui-icon"></i> 搜索 或 快速刷新 或 刷新
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                @if (checkAuth('event_config'))
                    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="view">表单配置</a>
                @endif
                @if (checkAuth('event_edit'))
                    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="edit">编辑活动</a>
                @endif
                @if (checkAuth('event_delete'))
                    <a class="layui-btn layui-btn-xs  layui-btn-danger" lay-event="delete">删除</a>
                @endif
            </script>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var getEventList = "{{ route('admin_get_event') }}";
        var viewForm = "{{ route('admin_form') }}";
        var editPage = "{{ route('admin_add_event') }}";
        var deleteEvent = "{{ route('admin_delete_event') }}";



        layui.use(['form', 'table', 'laydate'], function() {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table,
                layuimini = layui.layuimini;
            laydate = layui.laydate;
            form.render();

            table.render({
                elem: '#currentTableId',
                url: getEventList,
                toolbar: '#toolbarFilter',
                defaultToolbar: ['filter'],
                even : true,
                cols: [
                    [{
                            field: 'id',
                            title: '编号',
                            width: 100,
                            sort: true
                        },
                        {
                            field: 'name',
                            title: '活动名称',
                            width: 100,
                            sort: true
                        },
                        {
                            field: 'type',
                            title: '活动类型',
                            sort: true
                        },
                        {
                            field: 'sort',
                            title: '排序',
                            sort: true
                        },
                        {
                            field: 'display',
                            title: '是否显示',
                            sort: true
                        },
                        {
                            field: 'status',
                            title: '状态',
                            sort: true
                        },
                        {
                            field: 'is_daily',
                            title: '每日限制',
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
                        var checkStatus = table.checkStatus('currentTableId'),
                            data = checkStatus.data;
                        layer.confirm('确认删除记录？', function(index) {
                            layer.msg('删除' + data.length + '条记录', {
                                icon: 6
                            });
                            layer.close(index);
                        });
                        break;
                    case 'link':
                        setTimeout(function() {
                            table.resize(); //
                        }, TABLE_RESIZE_TIME)
                        break;
                    case 'export_data':
                        window.location.href = '/admin/' + MODULE_NAME + '/export?searchParams=' +
                            searchParams;
                        break;
                    case 'LAYTABLE_TIPS':
                        top.layer_module_tips(MODULE_NAME)
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
                    case 'edit':
                        var index = layer.open({
                            title: '编辑活动',
                            type: 2,
                            shade: 0.2,
                            maxmin: true,
                            shadeClose: true,
                            area: ['100%', '100%'],
                            content: editPage + '/' + data.id,
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
                                        layer.msg(data.msg, {
                                            icon: 6,
                                            time: SUCCESS_TIME,
                                            shade: 0.2
                                        });
                                        setTimeout(function() {
                                            var index = layer.getFrameIndex(
                                                window.name); //先得到当前iframe层的索引
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
