@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layuimini-main">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 25px;">
                <legend>云片短信</legend>
            </fieldset>


            <form class="layui-form layui-form-pane" action="" lay-filter="example">
                <div class="layui-form-item">
                    <label class="layui-form-label">API Key</label>
                    <div class="layui-input-block">
                        <input type="text" name="cloud_key" autocomplete="off" placeholder="填入接口钥" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">签名</label>
                    <div class="layui-input-block">
                        <input type="text" name="cloud_sign" placeholder="填入签名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"> 验证码内容</label>
                    <div class="layui-input-block">
                        <input type="text" name="cloud_temp" placeholder="填入验证码内容" autocomplete="off"
                            class="layui-input">
                    </div>
                </div>

                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 25px;">
                    <legend>聚合短信</legend>
                </fieldset>
                <div class="layui-form-item">
                    <label class="layui-form-label">API Key</label>
                    <div class="layui-input-block">
                        <input type="text" name="ju_key" autocomplete="off" placeholder="填入接口钥" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">签名</label>
                    <div class="layui-input-block">
                        <input type="text" name="ju_sign" placeholder="填入签名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">模板ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="ju_id" placeholder="填入短信模板ID" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">短信服务商</label>
                    <div class="layui-input-block" style="background:white">
                        <input type="radio" name="status" value="0" title="云片" checked="">
                        <input type="radio" name="status" value="1" title="聚合">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var saveSms = "{{route('admin_save_sms')}}";
        layui.use(['form', 'layedit', 'laydate'], function() {
            var form = layui.form,
                layer = layui.layer




            //监听提交
            form.on('submit(save)', function(data) {

                axios({
                        method: 'post',
                        url: saveSms,
                        responseType: 'json',
                        data: {
                            'data': JSON.stringify(data.field),
                        }
                    })
                    .then(function(response) {
                        var res = response.data;
                        if (res.code == 1) {
                            layer.msg(res.msg);
                        }
                          
                    });
                   

            });

        });
    </script>
@endsection
