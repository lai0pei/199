<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>优惠申请</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="{{ asset('static/lib/layui-v2.6.3/css/layui.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('static/layuimini/one_page/css/layuimini.css?v=2.0.4.2') }}" type="text/css"
        media="all">
    <link rel="stylesheet" href="{{ asset('static/layuimini/one_page/css/public.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('static/layuimini/one_page/css/themes/default.css') }}" type="text/css"
        media="all">
    <link rel="stylesheet" href="{{ asset('static/lib/font-awesome-4.7.0/css/font-awesome.min.css') }}" type="text/css"
        media="all">
    <style>
        @font-face {
            font-family: productSan;
            src: url("{{ asset('font/ProductSan.ttf') }}");
        }

        html * {
            font-family: productSan;
        }

        .layui-tab-item.layui-show {
            overflow: hidden;
        }

    </style>

    <style id="layuimini-bg-color">
    </style>

    @yield('style')
</head>

<body class="layui-layout-body layuimini-all">
    @yield('content')
    <script src="{{ asset('static/layui/layui.js') }}" charset="utf-8"></script>
    <script src="{{ asset('static/lib/jquery-3.4.1/jquery-3.4.1.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('static/layuimini/one_page/js/lay-config.js?v=2.0.0') }}" charset="utf-8"></script>


    <script type="text/javascript">
        // ajax 接口返回 页面显示 窗口 配置
        MODULE_NAME = '{{ $MODULE_NAME ?? '' }}';
        SUCCESS_TIME = 200;
        FAIL_TIME = 200;
        TABLE_RESIZE_TIME = 200;
        LOGOUT_TIME = 2000;
        AJAX_ERROR_TIP = '访问失败';
    </script>

    <script>
        layui.use(['element', 'layer'], function() {
            var $ = layui.jquery,
                element = layui.element,
                layer = layui.layer;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //记录浏览记录
            // $.post('{{ url('view_browsing') }}');
        });
    </script>
    @yield('footer')
</body>

</html>
