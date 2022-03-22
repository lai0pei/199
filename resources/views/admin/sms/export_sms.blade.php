@extends('common.template')
@section('style')

@endsection

@section('content')
    <div class="layuimini-container">
        <div class="layuimini-main">
            <div class="layui-form layuimini-form">
                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">导出过滤</label>
                    <div class="layui-input-block">
                        <input type="radio" id="export_id" name="myExport" value="0" title="全部" lay-filter="ChoiceRadio" checked>
                        <input type="radio" id="export_id" name="myExport" value="1" title="匹配" lay-filter="ChoiceRadio">
                        <input type="radio" id="export_id" name="myExport" value="2" title="不匹配" lay-filter="ChoiceRadio">
                        <input type="radio" id="export_id" name="myExport" value="3" title="已发" lay-filter="ChoiceRadio">
                        <input type="radio" id="export_id" name="myExport" value="4" title="未发" lay-filter="ChoiceRadio">
                        <input type="radio" id="export_id" name="myExport" value="5" title="未审核" lay-filter="ChoiceRadio">
                        <input type="radio" id="export_id" name="myExport" value="6" title="通过" lay-filter="ChoiceRadio">
                        <input type="radio" id="export_id" name="myExport" value="7" title="拒绝" lay-filter="ChoiceRadio">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-sm btn" onclick="myExport()">确认导出</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var exporter = "{{ route('sms_export') }}";

        function myExport() {
            let id = $("input[name='myExport']:checked").val();
            console.log("export_id", id);
            window.open(exporter + "?id=" + id,'_blank');
        }
    </script>
@endsection
