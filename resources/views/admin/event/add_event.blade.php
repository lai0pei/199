@extends('common.template')
@section('style')
    <style>
        .layui-form-label {
            width: 8rem;
        }

        .layui-input-inline,
        .layui-form-label {
            margin-top: 1rem;
        }

        .description {
            width: 24rem;
        }

        .layui-input-block {
            margin-left: 10rem;
        }

    </style>
@endsection
@section('content')
    <div class="layui-container">
        <div class="layui-form layuimini-form">
            <form class="layui-form" action="" id="addGoodsForm" onsubmit="return false">
                <div class="layui-row">
                    <div class="layui-col-md6 layui-col-xs12 layui-col-sm12">
                        <input type="hidden" name="id" value="{{ $type['id'] ?? -1 }}" class="layui-input">
                        <label class="layui-form-label required">活动名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" lay-verify="required" lay-reqtext="活动名不能为空" placeholder="例如:新年优惠"
                                value="{{ $type['name'] ?? '' }}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-col-md6 layui-col-xs12 layui-col-sm12">
                        <label class="layui-form-label required">活动类型</label>
                        <div class="layui-input-inline">
                            <select name="type_id" lay-verify="required" lay-reqtext="请选择活动类型" id="selectId">
                                @foreach ($event as $key => $value)
                                @php $selected = '';
                                if(($type['type_id'] ?? '') == $key + 1){
                                    $selected = 'selected="selected"';
                                }
                                @endphp
                                    <option value="{{ $key + 1 }}" {{$selected}}>{{ $value['name'] }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="layui-row">
                    <div class="layui-col-md6 layui-col-xs12 layui-col-sm12 ">
                        <label class="layui-form-label required">活动排序</label>
                        <div class="layui-input-inline">
                            <input type="number" name="sort" lay-verify="required" lay-reqtext="活动排序不能为空"
                                placeholder="排序小排前" value="{{ $type['sort'] ?? '' }}" class="layui-input sort">
                        </div>
                    </div>


                    <div class="layui-col-md6 layui-col-xs12 layui-col-sm12 ">
                        <label class="layui-form-label">外联地址</label>
                        <div class="layui-input-inline">
                            <input type="text" name="external_url" placeholder="不跳转选择空白"
                                value="{{ $type['external_url'] ?? '' }}" class="layui-input">
                        </div>
                    </div>
                </div>
                <br>
                <div class="layui-form-item ">
                    <label class="layui-form-label">活动时间</label>
                    <div class="layui-inline" id="eventTime">
                        <div class="layui-input-inline">
                            <input type="text" autocomplete="off" name="start" id="start" class="layui-input"
                                placeholder="开始日期" value="{{ $type['start_time'] ?? '' }}">
                        </div>
                      
                        <div class="layui-input-inline">
                            <input type="text" autocomplete="off" id="end" name="end" class="layui-input"
                                placeholder="结束日期" value="{{ $type['end_time'] ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="layui-row">
                    <div class="layui-col-md3 layui-col-xs12 layui-col-sm12 ">
                        <label class="layui-form-label">开启活动</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|关闭"
                                {{ $type['status_check'] ?? '' }}>
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-xs12 layui-col-sm12">
                        <label class="layui-form-label">前台显示</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" name="display" lay-skin="switch" id='display' lay-text="显示|屏蔽"
                                {{ $type['display_check'] ?? '' }}>
                        </div>
                    </div>
                    <div class="layui-col-md3 layui-col-xs12 layui-col-sm12">
                        <label class="layui-form-label">短信验证码</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" name="need_sms" lay-skin="switch" id='need_sms' lay-text="需要|不需"
                                {{ $type['need_sms_check'] ?? '' }}>
                        </div>
                    </div>
                    <input type='hidden' value="{{$type['is_sms']}}" name="is_sms"/>
                    @if ((int)$type['is_sms'] === 1 )
                    <div class="layui-col-md3 layui-col-xs12 layui-col-sm12">
                        <label class="layui-form-label">每月限制</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" name="is_monthly" lay-skin="switch" id='is_monthly' lay-text="限制|不限"
                                {{ $type['is_monthly_check'] ?? '' }}>
                        </div>
                    </div>
                    @else
                    <div class="layui-col-md3 layui-col-xs12 layui-col-sm12">
                        <label class="layui-form-label">每日限制</label>
                        <div class="layui-input-inline">
                            <input type="checkbox" name="is_daily" lay-skin="switch" id='is_daily' lay-text="限制|不限"
                                {{ $type['is_daily_check'] ?? '' }}>
                        </div>
                    </div>
                    @endif
                </div>
                @if ((int)$type['is_sms'] !== 1 )
                <div class="layui-form-item">
                    <label class="layui-form-label required">限制次数</label>
                    <div class="layui-input-inline">
                        <input type="number" name="daily_limit" placeholder="不限时,次数无效"
                            value="{{ $type['daily_limit'] ?? '' }}" class="layui-input ">
                    </div>
                </div>
                @endif
                <div class="layui-form-item">
                    <label class="layui-form-label required">注释</label>
                    <div class="layui-input-inline">
                        <input type="text" name="description" placeholder="前台活动申请时显示"
                            value="{{ $type['description'] ?? '' }}" class="layui-input description">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label required">活动图片</label>
                    <div class="layui-upload-drag" id="type_url">
                        <i class="layui-icon"></i>
                        <p>点击上传，或将文件拖拽到此处</p>
                        <input type='hidden' id="type_pic" name="type_pic" value="{{ $type['type_pic'] ?? '' }}" lay-verify="required" lay-reqtext="活动图片不能为空">
                        <div class="layui-hide" id='uploadView'>
                            <hr>
                            <img src="{{ $type['type_pic'] ?? '' }}" alt="活动图片" style="max-width: 196px">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label required">活动内容</label>
                    <div class="layui-input-block">
                        <script id="editor" name="content" type="text/plain" style="width:auto;height:300px;"></script>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        @if (checkAuth('event_add'))
                            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('footer')
    <script type="text/javascript" src="{{ asset('static/ueditor/ueditor.config.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('static/ueditor/ueditor.all.js') }}" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('static/ueditor/lang/zh-cn/zh-cn.js') }}"></script>

    <script>
        var id = "{{ $type['id'] ?? -1 }}";

        if (id !== -1) {
            var doc = new DOMParser().parseFromString("{{ $type['content'] ?? '' }}", 'text/html');
            $(function() {
                window.setTimeout(setContent, 1000);
            });

            function setContent() {
                UE.getEditor('editor').execCommand('insertHtml', doc.documentElement.textContent);
            }
        }



        var ue = UE.getEditor('editor');
        //对编辑器的操作最好在编辑器ready之后再做
        ue.ready(function() {
            //设置编辑器的内容
            ue.setContent();

        });


        var mani_type = "{{ route('admin_mani_event') }}";
        var uploader = "{{ route('admin_upload') }}";
        var content = "{{ route('admin_upload_content') }}";



        layui.use(['form', 'layedit', 'laydate', 'upload', 'element'], function() {
            var form = layui.form,
                layer = layui.layer,
                upload = layui.upload,
                element = layui.element,
                laydate = layui.laydate;

            //编辑 赋值
            var content = "{{ $type['content'] ?? '' }}";
            var isEventPic = "{{ $type['type_pic'] ?? '' }}";
            console.log(isEventPic);
            if ('' !== isEventPic) {
                layui.$('#uploadView').removeClass('layui-hide');
            }

            //开启公历节日
            laydate.render({
                elem: '#eventTime',
                range: ['#start', '#end']
            });

            //监听提交
            form.on('submit(saveBtn)', function(data) {
                $.ajax({
                    url: mani_type,
                    data: {
                        "data": data.field,
                    },
                    method: 'POST',
                    success: function(data) {
                        let type_id = "{{ $type['id'] ?? -1 }}";

                        if (data.code == 1) {
                            layer.msg(data.msg, {
                                icon: 6,
                                time: SUCCESS_TIME,
                                shade: 0.2
                            });
                            if (-1 == type_id) {
                                location.reload();
                            } else {
                                setTimeout(function() {
                                    var index = parent.layer.getFrameIndex(window
                                        .name); //先得到当前iframe层的索引
                                    parent.$('button[lay-filter="data-search-btn"]')
                                        .click(); //刷新列表
                                    parent.layer.close(index); //再执行关闭

                                }, SUCCESS_TIME);
                            }



                        } else {
                            layer.msg(data.msg, {
                                icon: 6,
                                time: SUCCESS_TIME,
                                shade: 0.2
                            });
                        }
                    }
                });


                return false;
            });

            //常规使用 - 普通图片上传
            var uploadInst = upload.render({
                elem: '#type_url',
                url: uploader //此处用的是第三方的 http 请求演示，实际使用时改成您自己的上传接口即可。
                    ,
                size: 2048,
                drag: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                accept: 'images',
                before: function(obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result) {
                        $('#pic_url').attr('src', result); //图片链接（base64）
                    });

                    element.progress('demo', '0%'); //进度条复位
                    layer.msg('上传中', {
                        icon: 16,
                        time: 0
                    });
                },
                done: function(res) {
                    if (res.data.length == 0) {
                        layer.msg(res.msg);
                        return false;
                    }
                    //如果上传失败
                    if (res.code !== 0) {
                        return layer.msg('上传失败');
                    }

                    //赋值 input 用来传递 form 提交
                    $('#type_pic').attr('value', res.data.src);
                    //上传成功的一些操作
                    //……
                    layer.msg(res.msg, {
                        icon: 6,
                        time: SUCCESS_TIME,
                        shade: 0.2
                    });
                    layui.$('#uploadView').removeClass('layui-hide').find('img').attr('src', res
                        .data.src);

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
