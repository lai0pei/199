@extends('common.template')
@section('style')
    <style>
        .top-panel {
            border: 1px solid #eceff9;
            border-radius: 5px;
            text-align: center;
        }

        .top-panel>.layui-card-body {
            height: 60px;
        }

        .top-panel-number {
            line-height: 60px;
            font-size: 30px;
            text-align: center;
        }

        .top-panel-tips {
            line-height: 30px;
            font-size: 12px
        }

    </style>
@endsection
@section('content')
    <div class="layuimini-main">

        <div class="layui-row layui-col-space15">

            <div class="layui-col-xs12 layui-col-md3">

                <div class="layui-card top-panel">
                    <div class="layui-card-header">总新人申请数量</div>
                    <div class="layui-card-body">
                        <div class="layui-row ">
                            <div class="  top-panel-number">
                                {{ $total ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="layui-col-xs12 layui-col-md3">

                <div class="layui-card top-panel">
                    <div class="layui-card-header">今日新人申请数量</div>
                    <div class="layui-card-body">
                        <div class="layui-row ">
                            <div class="  top-panel-number">
                                {{ $today ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <div class="layui-col-xs12 layui-col-md3">

                <div class="layui-card top-panel">
                    <div class="layui-card-header">总活动申请数量</div>
                    <div class="layui-card-body">
                        <div class="layui-row ">
                            <div class="  top-panel-number">
                                {{ $event ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="layui-col-xs12 layui-col-md3">

                <div class="layui-card top-panel">
                    <div class="layui-card-header">今日活动申请数量</div>
                    <div class="layui-card-body">
                        <div class="layui-row ">
                            <div class="  top-panel-number">
                                {{ $todayEvent ?? 0 }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="layui-col-xs12 layui-col-md3">

                <div class="layui-card top-panel">
                    <div class="layui-card-header">新人申请未审核</div>
                    <div class="layui-card-body">
                        <div class="layui-row ">
                            <div class="  top-panel-number">
                                {{ $smsAppr ?? 0 }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="layui-col-xs12 layui-col-md3">

                <div class="layui-card top-panel">
                    <div class="layui-card-header">活动申请未审核</div>
                    <div class="layui-card-body">
                        <div class="layui-row ">
                            <div class="  top-panel-number">
                                {{ $userAppr ?? 0 }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="layui-col-xs12 layui-col-md3">

                <div class="layui-card top-panel">
                    <div class="layui-card-header">Vip号码数量</div>
                    <div class="layui-card-body">
                        <div class="layui-row ">
                            <div class="  top-panel-number">
                                {{ $vip ?? 0 }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>


        </div>

        <div class="layui-row layui-col-space15">
            <div class="layui-col-xs12 ">
                <div id="echarts-records" style="background-color:#ffffff;min-height:400px;padding: 10px"></div>
            </div>
            {{-- <div class="layui-col-xs12 layui-col-md3">
                <div id="echarts-pies" style="background-color:#ffffff;min-height:400px;padding: 10px"></div>
            </div> --}}
        </div>



    </div>
@endsection
@section('footer')
    <script>
        var api = "{{ route('admin_getChart') }}";
        var legend = [];
        var series = [];
        var xaxis = [];

        
        $(document).ready(function(obj) {

$.ajax({
    type: "POST",
    url: api,
    success: function(data) {
        if (data.expire == 1) {
       
            setTimeout(function() {

                parent.location.reload(1);


            }, LOGOUT_TIME)

        }
        var list = data.data;
        legend = list['legend'];
        series = list['series'];
        xaxis = list['x-axis'];
        if (data.code == 1) {

        }
    },
});
});
        layui.use(['layer', 'echarts'], function() {
            var $ = layui.jquery,
                layer = layui.layer,
                echarts = layui.echarts;

            /**
             * 报表功能
             */
            var echartsRecords = echarts.init(document.getElementById('echarts-records'), 'walden');

            var optionRecords = {
                title: {
                    text: '活动申请-报告表'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross',
                        label: {
                            backgroundColor: '#6a7985'
                        }
                    }
                },
                legend: {
                    data: legend
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: xaxis
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: series
            };
            echartsRecords.setOption(optionRecords);


        });
    </script>
@endsection
