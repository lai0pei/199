<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>laravel title</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="{{ asset('static/layui/css/layui.css') }}" type="text/css" media="all">
    @yield('style')
</head>

<body class="@yield('body_class')">
    @yield('content')
</body>
<script src="{{ asset('static/layui/layui.js') }}" charset="utf-8"></script>
<script src="{{ asset('static/jquery/jquery-3.6.0.js') }}" charset="utf-8"></script>
<script type="text/javascript">
    MODULE_NAME = '{{ $MODULE_NAME ?? '' }}';
    SUCCESS_TIME = 800;
    FAIL_TIME = 2000;
    TABLE_RESIZE_TIME = 3500;
    AJAX_ERROR_TIP = '访问失败';
</script>
<!-- 添加 csrf-token 验证 -->
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
    });
</script>
@yield('footer')

</html>
