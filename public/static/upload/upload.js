layui.use(['form', 'upload'], function () {
    var form = layui.form,
        layer = layui.layer,
        upload = layui.upload;
    //监听提交
    form.on('submit(saveBtn)', function (data) {
        console.log(data);
        $.ajax({
            url: save,
            data: {
                'data': data.field,
            },
            method: 'POST',
            success: function (res) {
                if (res.code == 1) {
                    layer.msg(res.msg);
                    window.parent.location.reload();
                } else {
                    layer.msg(res.msg);
                }
            }
        });

    });

    //logo 上传
    upload.render({
        elem: '#logo',
        url: uploader //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#logo').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败

            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }

            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            //赋值 input 用来传递 form 提交
            $('#logoData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#uploadView').removeClass('layui-hide').find('img').attr('src', res
                .data.src);
        },
    });

    //查询按钮 上传
    upload.render({
        elem: '#searchBtn',
        url: searchBtn //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#searchBtn').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败
            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }
            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            console.log(res);
            //赋值 input 用来传递 form 提交
            $('#searchBtnData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#searchBtnView').removeClass('layui-hide').find('img').attr('src', res
                .data.src);

        },
    });

    

    //查询按钮 上传
    upload.render({
        elem: '#1Wall',
        url: cruosel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#1Wall').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败
            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }
            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            console.log(res);
            //赋值 input 用来传递 form 提交
            $('#1WallData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#1View').removeClass('layui-hide').find('img').attr('src', res
                .data.src);

        },
    });

    //查询按钮 上传
    upload.render({
        elem: '#2Wall',
        url: cruosel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#2Wall').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败
            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }
            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            console.log(res);
            //赋值 input 用来传递 form 提交
            $('#2WallData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#2View').removeClass('layui-hide').find('img').attr('src', res
                .data.src);

        },
    });

    //查询按钮 上传
    upload.render({
        elem: '#3Wall',
        url: cruosel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#3Wall').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败
            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }
            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            console.log(res);
            //赋值 input 用来传递 form 提交
            $('#3WallData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#3View').removeClass('layui-hide').find('img').attr('src', res
                .data.src);

        },
    });

    //查询按钮 上传
    upload.render({
        elem: '#4Wall',
        url: cruosel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#4Wall').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败
            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }
            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            console.log(res);
            //赋值 input 用来传递 form 提交
            $('#4WallData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#4View').removeClass('layui-hide').find('img').attr('src', res
                .data.src);

        },
    });

    //查询按钮 上传
    upload.render({
        elem: '#5Wall',
        url: cruosel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#5Wall').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败
            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }
            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            console.log(res);
            //赋值 input 用来传递 form 提交
            $('#5WallData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#5View').removeClass('layui-hide').find('img').attr('src', res
                .data.src);

        },
    });

    //查询按钮 上传
    upload.render({
        elem: '#6Wall',
        url: cruosel //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
        ,
        size: 2048,
        drag: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        accept: 'images/*',
        before: function (obj) {
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
                $('#6Wall').attr('src', result); //图片链接（base64）
            });

            layer.msg('上传中', {
                icon: 16,
                time: 0
            });
        },
        done: function (res) {
            //如果上传失败
            if (res.data.length == 0) {
                return layer.msg(res.msg);
            }
            if (res.code !== 0) {
                return layer.msg('上传失败');
            }
            console.log(res);
            //赋值 input 用来传递 form 提交
            $('#6WallData').attr('value', res.data.src);
            layer.msg('上传成功');
            layui.$('#6View').removeClass('layui-hide').find('img').attr('src', res
                .data.src);

        },
    });
});
