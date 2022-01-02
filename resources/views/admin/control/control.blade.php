@extends('common.template')
@section('style')
<style>
    .top-panel {
        border: 1px solid #eceff9;
        border-radius: 5px;
        text-align: center;
    }
    .top-panel > .layui-card-body{
        height: 60px;
    }
    .top-panel-number{
        line-height:60px;
        font-size: 30px;
        border-right:1px solid #eceff9;
    }
    .top-panel-tips{
        line-height:30px;
        font-size: 12px
    }
</style>
    @endsection
    @section('content')
    <div class="layuimini-main">

        <div class="layui-row layui-col-space15">
            <div class="layui-col-xs12 layui-col-md3">
    
                <div class="layui-card top-panel">
                    <div class="layui-card-header">要展示的指标名称</div>
                    <div class="layui-card-body">
                        <div class="layui-row layui-col-space5">
                            <div class="layui-col-xs9 layui-col-md9 top-panel-number">
                                9,054,056
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
            <div class="layui-col-xs12 layui-col-md3">
    
                <div class="layui-card top-panel">
                    <div class="layui-card-header">要展示的指标名称</div>
                    <div class="layui-card-body">
                        <div class="layui-row layui-col-space5">
                            <div class="layui-col-xs9 layui-col-md9 top-panel-number">
                                9,054,056
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
            <div class="layui-col-xs12 layui-col-md3">
    
                <div class="layui-card top-panel">
                    <div class="layui-card-header">要展示的指标名称</div>
                    <div class="layui-card-body">
                        <div class="layui-row layui-col-space5">
                            <div class="layui-col-xs9 layui-col-md9 top-panel-number">
                                9,054,056
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
            <div class="layui-col-xs12 layui-col-md3">
    
                <div class="layui-card top-panel">
                    <div class="layui-card-header">要展示的指标名称</div>
                    <div class="layui-card-body">
                        <div class="layui-row layui-col-space5">
                            <div class="layui-col-xs9 layui-col-md9 top-panel-number">
                                9,054,056
                            </div>
   
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    
        <div class="layui-row layui-col-space15">
            <div class="layui-col-xs12 layui-col-md9">
                <div id="echarts-records" style="background-color:#ffffff;min-height:400px;padding: 10px"></div>
            </div>
            <div class="layui-col-xs12 layui-col-md3">
                <div id="echarts-pies" style="background-color:#ffffff;min-height:400px;padding: 10px"></div>
            </div>
        </div>

    
    
    </div>
    @endsection
@section('footer')
    <script>
        layui.use(['layer', 'echarts'], function () {
            var $ = layui.jquery,
                layer = layui.layer,
                echarts = layui.echarts;
    
            /**
             * 报表功能
             */
            var echartsRecords = echarts.init(document.getElementById('echarts-records'), 'walden');
    
            var optionRecords = {
                title: {
                    text: '指标名称-报表图'
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
                    data: ['邮件营销', '联盟广告', '视频广告', '直接访问', '搜索引擎']
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
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日' ]
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [
                    {
                        name: '邮件营销',
                        type: 'line',
                        stack: '总量',
                        areaStyle: {},
                        data: [00, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name: '联盟广告',
                        type: 'line',
                        areaStyle: {},
                        data: [220, 182, 191, 234, 290, 330, 310]
                    },
                    {
                        name: '视频广告',
                        type: 'line',
                        stack: '总量',
                        areaStyle: {},
                        data: [150, 232, 201, 154, 190, 330, 410]
                    },
                    {
                        name: '直接访问',
                        type: 'line',
                        stack: '总量',
                        areaStyle: {},
                        data: [320, 332, 301, 334, 390, 330, 320]
                    },
                    {
                        name: '搜索引擎',
                        type: 'line',
                        stack: '总量',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        areaStyle: {},
                        data: [820, 932, 901, 934, 1290, 1330, 1320]
                    }
                ]
            };
            echartsRecords.setOption(optionRecords);
    
    
            /**
             * 玫瑰图表
             */
            var echartsPies = echarts.init(document.getElementById('echarts-pies'), 'walden');
            var optionPies = {
                title: {
                    text: '指标名称-玫瑰图',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: ['直接访问', '邮件营销', '联盟广告', '视频广告', '搜索引擎']
                },
                series: [
                    {
                        name: '访问来源',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        roseType: 'radius',
                        data: [
                            {value: 335, name: '直接访问'},
                            {value: 310, name: '邮件营销'},
                            {value: 234, name: '联盟广告'},
                            {value: 135, name: '视频广告'},
                            {value: 368, name: '搜索引擎'}
                        ],
                        emphasis: {
                            itemStyle: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };
            echartsPies.setOption(optionPies);
    
    
            /**
             * 柱状图
             */
            var echartsDataset = echarts.init(document.getElementById('echarts-dataset'), 'walden');
    
            var optionDataset = {
                legend: {},
                tooltip: {},
                dataset: {
                    dimensions: ['product', '2015', '2016', '2017'],
                    source: [
                        {product: 'Matcha Latte', '2015': 43.3, '2016': 85.8, '2017': 93.7},
                        {product: 'Milk Tea', '2015': 83.1, '2016': 73.4, '2017': 55.1},
                        {product: 'Cheese Cocoa', '2015': 86.4, '2016': 65.2, '2017': 82.5},
                        {product: 'Walnut Brownie', '2015': 72.4, '2016': 53.9, '2017': 39.1}
                    ]
                },
                xAxis: {type: 'category'},
                yAxis: {},
                // Declare several bar series, each will be mapped
                // to a column of dataset.source by default.
                series: [
                    {type: 'bar'},
                    {type: 'bar'},
                    {type: 'bar'}
                ]
            };
    
            echartsDataset.setOption(optionDataset);
    
    
            /**
             * 中国地图
             */
            var echartsMap = echarts.init(document.getElementById('echarts-map'), 'walden');
    
    
            var optionMap = {
                legend: {},
                tooltip: {
                    trigger: 'axis',
                    showContent: false
                },
                dataset: {
                    source: [
                        ['product', '2012', '2013', '2014', '2015', '2016', '2017'],
                        ['Matcha Latte', 41.1, 30.4, 65.1, 53.3, 83.8, 98.7],
                        ['Milk Tea', 86.5, 92.1, 85.7, 83.1, 73.4, 55.1],
                        ['Cheese Cocoa', 24.1, 67.2, 79.5, 86.4, 65.2, 82.5],
                        ['Walnut Brownie', 55.2, 67.1, 69.2, 72.4, 53.9, 39.1]
                    ]
                },
                xAxis: {type: 'category'},
                yAxis: {gridIndex: 0},
                grid: {top: '55%'},
                series: [
                    {type: 'line', smooth: true, seriesLayoutBy: 'row'},
                    {type: 'line', smooth: true, seriesLayoutBy: 'row'},
                    {type: 'line', smooth: true, seriesLayoutBy: 'row'},
                    {type: 'line', smooth: true, seriesLayoutBy: 'row'},
                    {
                        type: 'pie',
                        id: 'pie',
                        radius: '30%',
                        center: ['50%', '25%'],
                        label: {
                            formatter: '{b}: {@2012} ({d}%)'
                        },
                        encode: {
                            itemName: 'product',
                            value: '2012',
                            tooltip: '2012'
                        }
                    }
                ]
            };
    
            echartsMap.setOption(optionMap);
    
    
            // echarts 窗口缩放自适应
            window.onresize = function () {
                echartsRecords.resize();
            }
    
        });
    </script>
@endsection
