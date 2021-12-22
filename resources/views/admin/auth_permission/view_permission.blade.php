@extends('common.template')

@section('content')
    <div class="layui-container">
        <div class="layui-row">
                <div class="layui-form-item">
                    <label class="layui-form-label">权限名称 <span class="color-red">*</span></label>
                    <div class="layui-input-block ">
                        <input type="text" class="layui-input " maxlength="50" autocomplete="off"
                               value="{{$data['title']}}" disabled>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-block">
                      <textarea class="layui-textarea">{{$data['content']}}</textarea>
                    </div>
                  </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
