@extends('common.template')
@section('style')
@endsection
@section('content')
<div class="layui-form layuimini-form">
    <div class="layui-form-item">
        <label class="layui-form-label required">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="account" lay-verify="required" lay-reqtext="用户名不能为空" placeholder="请输入用户名" value="{{$edit_admin->account}}" class="layui-input">
            <tip>填写自己管理账号的名称。</tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label required">昵称</label>
        <div class="layui-input-block">
            <input type="text" name="username" lay-verify="required" lay-reqtext="昵称名不能为空" placeholder="请输入昵称" value="{{$edit_admin->user_name}}" class="layui-input">
            <tip>填写自己管理账号昵称。</tip>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="text" name="password" lay-verify="required" lay-reqtext="密码不能为空" placeholder="请输入密码" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item" pane="">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <input type="radio" name="status" value="1" title="开启" checked="checked">
            <input type="radio" name="status" value="0" title="禁用" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择角色</label>
        <div class="layui-input-block">
            <select name="role" lay-filter="aihao" lay-verify="required" lay-reqtext="角色不能为空" id="selectId">
                <option></option>
            </select>
        </div>
    </div>
    <div class="layui-form-item " style="display:none">
        <div class="layui-input-block">
            <input type="text" name="id" lay-verify="required"  value="{{$edit_admin->id}}" class="layui-input">
        </div>
    </div>
   
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认保存</button>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
    var get_role = "{{route('admin_get_role')}}";
    var save_person = "{{route('admin_save_admin')}}";
  layui.use(['form'], function () {
        var form = layui.form,
            layer = layui.layer,
            $ = layui.$;

            $('document').ready(function(){
        $.ajax({
            url : get_role,
            dataType : 'json',
            method : 'GET',
            success : function(data){
                var list = data.data;
                if(data.code == 1){
                    $.each(list,function(index,item){
 
 	//option 第一个参数是页面显示的值，第二个参数是传递到后台的值
 	$('#selectId').append(new Option(item.role_name,item.id));//往下拉菜单里添加元素
 	//设置value（这个值就可以是在更新的时候后台传递到前台的值）为2的值为默认选中
  
 	$('#selectId').val('{{$edit_admin->role_id}}');
 });
 form.render();
                }
            }
        });
    });
        //监听提交
        form.on('submit(saveBtn)', function (data) {
            $.ajax({
            url : save_person,
            data : data.field,
            method : 'POST',
            success : function(data){
                if(data.code == 1){
                   layer.msg(data.msg);
                }else{
                    layer.msg(data.msg);
                }
            }
        });

    });
});
</script>
@endsection