@extends('common.template')
@section('body_class','bg-write')
@section('style')

@endsection

@section('content')
    <div class="layui-container">
        <div class="layui-row">
            <table class="layui-table zhihe-show">
                <colgroup>
                    <col width="20%">
                    <col width="">
                    <col>
                </colgroup>
                <thead>
                </thead>
                <tbody>
                <tr>
                    <th>类型</th>
                    <td>{{$log['type']}}</td>
                </tr>
                <tr>
                    <th>日志标题</th>
                    <td>{{$log['title']}}</td>
                </tr>
                <tr>
                    <th>创建时间</th>
                    <td>{{$log['created_at']}}</td>
                </tr>
                <tr>
                    <th>更新时间</th>
                    <td>{{$log['updated_at']}}</td>
                </tr>
                <tr>
                    <th>记录人</th>
                    <td>{{$log['user']}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')

@endsection
