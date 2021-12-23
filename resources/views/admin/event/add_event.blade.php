@extends('common.template')
@section('style')
    <style>
        .layui-form {
            padding: 2%;
        }

        .layui-form-label {
            width: 8rem;
        }

        .spread {
            padding-top: 1rem;
        }

        .layui-upload-img {
            width: 15%;
            padding-left: 5.8rem;
        }

        .layui-upload {
            padding-left: 4rem;
        }

        .progress {
            padding-left: 6rem;
        }

    </style>
@endsection
@section('content')
    <div class="layuimini-container">
        <div class="layui-form layuimini-form">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <input type="hidden" name="id" value="{{ $type['id'] ?? -1 }}" class="layui-input">
                    <label class="layui-form-label required">活动名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" lay-verify="required" lay-reqtext="活动名不能为空" placeholder="例如:新年优惠"
                            value="{{ $type['name'] ?? '' }}" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">活动类型</label>
                    <div class="layui-input-inline">
                        <select name="role" lay-filter="aihao" lay-verify="required" lay-reqtext="请选择活动类型" id="selectId">
                            @foreach ($event as $key => $value)
                                <option value="{{ $key }}">{{ $value['name'] }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label required">活动排序</label>
                    <div class="layui-input-inline">
                        <input type="number" name="name" lay-verify="required" lay-reqtext="活动排序不能为空" placeholder="例如:0"
                            value="{{ $type['sort'] ?? '' }}" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">外联地址</label>
                    {{-- <div class="layui-input-inline">
                        <input type="text" name="external_url" lay-verify="required|url" lay-reqtext="活动名不能为空"
                            placeholder="http://www.google.com" value="{{ $type['external_url'] ?? '' }}"
                            class="layui-input">
                    </div> --}}
                    <div class="layui-input-inline">
                        <input type="text" name="external_url" lay-reqtext="活动名不能为空" placeholder="http://www.google.com"
                            value="aa" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">活动开始时间</label>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" name="start" id="start" value="" placeholder="请选择开始时间">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">活动结束时间</label>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" id="end" name="end" value="" placeholder="请选择结束时间">
                    </div>
                </div>
                <div class="layui-form-item spread">
                    <label class="layui-form-label">是否开启活动</label>
                    <div class="layui-input-inline">
                        <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|关闭">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否显示</label>
                    <div class="layui-input-inline">
                        <input type="checkbox" name="display" lay-skin="switch" lay-text="显示|屏蔽">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否显每日限制</label>
                    <div class="layui-input-inline">
                        <input type="checkbox" name="is_daily" lay-skin="switch" lay-text="限制|不限">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label required">每日限制次数</label>
                    <div class="layui-input-inline">
                        <input type="number" name="daily_limit" lay-verify="required" placeholder="例如:0"
                            value="{{ $type['daily_limit'] ?? '' }}" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label required">活动图片</label>
                    <div class="layui-upload">
                        <button type="button" class="layui-btn" id="type_url">上传活动图片</button>
                        <input type='hidden' id="type_pic" name="type_pic" value="">
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" id="pic_url">
                            <p id="demoText"></p>
                        </div>
                        <div style="width: 95px;" class="progress">
                            <div class="layui-progress layui-progress-big" lay-showpercent="yes" lay-filter="demo">
                                <div class="layui-progress-bar" lay-percent=""></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="editor"> </div>
                
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('footer')
<script src="{{ asset('static/wangeditor-4.7.10/package/dist/wangEditor.js') }}" charset="utf-8"></script>


    <script>
        var mani_type = "{{ route('admin_mani_type') }}";
        var status = "{{ $type['status'] ?? 1 }}";
        var uploader = "{{ route('admin_upload') }}";
        var content = "{{ route('admin_upload_content') }}"
        if (status == 1) {
            $('#open').attr('checked', true);
        } else {
            $('#close').attr('checked', true);
        }

        const E = window.wangEditor
        const editor = new E('#editor')
        editor.config.uploadImgServer = content
        editor.create()

        layui.use(['form', 'layedit'], function() {
            var form = layui.form,
                layer = layui.layer,
                upload = layui.upload,
                element = layui.element,
                layedit = layui.layedit,
                laydate = layui.laydate;


            //开启公历节日
            laydate.render({
                elem: '#end',
                calendar: true,

            });

            //监听提交
            form.on('submit(saveBtn)', function(data) {
                console.log(data);
                layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                })
                // $.ajax({
                //     url: mani_type,
                //     data: data.field,
                //     method: 'POST',
                //     success: function(data) {
                //         if (data.code == 1) {
                //             layer.msg(data.msg);
                //                window.parent.location.reload();
                //         } else {
                //             layer.msg(data.msg);
                //         }
                //     }
                // });


                return false;
            });

            //常规使用 - 普通图片上传
            var uploadInst = upload.render({
                elem: '#type_url',
                url: uploader //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
                    ,
                before: function(obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result) {
                        console.log(result);
                        $('#pic_url').attr('src', result); //图片链接（base64）
                    });

                    element.progress('demo', '0%'); //进度条复位
                    layer.msg('上传中', {
                        icon: 16,
                        time: 0
                    });
                },
                done: function(res) {
                    //如果上传失败
                    if (res.code == 0) {
                        return layer.msg('上传失败');
                    }
                    console.log(res);
                    $('#type_pic').attr('value', res.data);
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

        });
    </script>
@endsection
