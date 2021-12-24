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
                                <label class="layui-form-label">用户手机号码</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="user" autocomplete="off" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-inline">
                                <button type="submit" class="layui-btn layui-btn-primary" lay-submit
                                    lay-filter="data-search-btn"><i class="layui-icon"></i> 搜 索
                                </button>
                            </div>

                            <div class="layui-inline upload-shift">
                                <button type="button" class="layui-btn" id="exel_import">导入VIP用户手机号码</button>
                            </div>

                        </div>

                    </form>
                </div>
            </fieldset>
            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
            </script>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var getLog = "{{ route('admin_getLog') }}";
        var viewLog = "{{ route('admin_detailLog') }}";
        var uploadExcel = "{{route('admin_import_excel')}}";
        layui.use(['form', 'table', 'upload', 'layer', 'element'], function() {
            var $ = layui.jquery,
                upload = layui.upload,
                table = layui.table,
                form = layui.form,
                element = layui.element,
                layer = layui.layer;


            table.render({
                elem: '#currentTableId',
                url: getLog,
                toolbar: '#toolbarFilter',
                defaultToolbar: ['filter'],
                cols: [
                    [{
                            field: 'id',
                            title: '编号',
                            width: 250,
                            sort: true
                        },
                        {
                            field: 'type',
                            title: '手机号',
                            minWidth: 100,
                            sort: true
                        },
                        {
                            title: '操作',
                            minWidth: 220,
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
                            title: '',
                            type: 2,
                            shade: 0.2,
                            maxmin: false,
                            shadeClose: false,
                            area: ['60%', '65%'],
                            content: viewLog + '/' + data.id,
                        });
                        break;
                    case 'delete':

                        break;
                }
            });

            //常规使用 - 普通图片上传
            var uploadInst = upload.render({
                elem: '#exel_import',
                url: uploadExcel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
                    ,
                    accept: "file",
                //  exts: 'xls|xlsx|xlsm|xlt|xltx|xltm',
                exts: 'xls|xlsx',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                before: function(obj) {
                    //预读本地文件示例，不支持ie8

                    element.progress('demo', '0%'); //进度条复位
                    layer.msg('文件上传中', {
                        icon: 16,
                        time: 0
                    });
                },
                done: function(res) {
                    //如果上传失败
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    }
                    //上传成功的一些操作
                    //……
                    $('#demoText').html(''); //置空上传失败的状态
                },
                error: function() {
                        //演示失败状态，并实现重传
                        var demoText = $('#demoText');
                        demoText.html(
                            '<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>'
                        );
                        demoText.find('.demo-reload').on('click', function() {
                            uploadInst.upload();
                        });
                    }
                    //进度条
                    ,
                progress: function(n, elem, e) {
                    element.progress('demo', n + '%'); //可配合 layui 进度条元素使用
                    if (n == 100) {
                        layer.msg('上传完毕', {
                            icon: 1
                        });
                    }
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
