@extends('common.template')
@section('content')
    <div class="layui-container">
        <div class="layuimini-main">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 25px;">
                <legend>云片短信</legend>
            </fieldset>

            <form class="layui-form layui-form-pane" action="" lay-filter="example" onsubmit="return false">
                <div class="layui-form-item">
                    <label class="layui-form-label">API Key</label>
                    <div class="layui-input-block">
                        <input type="text" name="cloud_key" autocomplete="off" placeholder="填入接口钥"
                            value="{{ $sms['cloud_key'] ?? '' }}" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">签名</label>
                    <div class="layui-input-block">
                        <input type="text" name="cloud_sign" placeholder="填入签名" autocomplete="off"
                            value="{{ $sms['cloud_sign'] ?? '' }}" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"> 验证码内容</label>
                    <div class="layui-input-block">
                        <input type="text" name="cloud_temp" placeholder="填入验证码内容" value="{{ $sms['cloud_temp'] ?? '' }}"
                            autocomplete="off" class="layui-input">
                    </div>
                </div>

                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 25px;">
                    <legend>聚合短信</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label">API Key</label>
                    <div class="layui-input-block">
                        <input type="text" name="ju_key" autocomplete="off" placeholder="填入接口钥"
                            value="{{ $sms['ju_key'] ?? '' }}" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">签名</label>
                    <div class="layui-input-block">
                        <input type="text" name="ju_sign" placeholder="填入签名" autocomplete="off"
                            value="{{ $sms['ju_sign'] ?? '' }}" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">模板ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="ju_id" placeholder="填入短信模板ID" autocomplete="off"
                            value="{{ $sms['ju_id'] ?? '' }}" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">短信服务商</label>
                    <div class="layui-input-block" style="background:white">
                        <input type="radio" id="cloud" name="status" value="0" title="云片">
                        <input type="radio" id="ju" name="status" value="1" title="聚合">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        @if (checkAuth('sms_config_edit'))
                            <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var saveSms = "{{ route('admin_save_sms') }}";
        var status = "{{ $sms['status'] ?? 0 }}";

        //check status
        if (status == 0) {
            $('#cloud').attr('checked', true);
        } else {
            console.log(status);
            $('#ju').attr('checked', true);
        }

    

        layui.use(['form'], function() {
            var form = layui.form,
                layer = layui.layer;


              
            //监听提交
            form.on('submit(save)', function(data) {

                $.ajax({
                    url: saveSms,
                    data: {
                        'data': JSON.stringify(data.field),
                    },
                    async : false,
                    method: 'POST',
                    beforeSend: function () {
                        $("#button[lay-filter='save']").removeClass('disabled').prop('disabled', false);
                        loading = layer.load(2)
                    },
                    complete: function () {
                        $("#button[lay-filter='save']").removeClass('disabled').prop('disabled', false);
                        layer.close(loading)
                    },
                    error: function () {
                        layer.msg(AJAX_ERROR_TIP, {
                            icon: 2,
                            time: FAIL_TIME,
                            shade: 0.3
                        });
                    },
                    success: function(data) {
                        layer.msg(data.msg, {
                                icon: 6,
                                time: SUCCESS_TIME,
                                shade: 0.2
                            });
                    }
                });
            });

        });
    </script>
@endsection
