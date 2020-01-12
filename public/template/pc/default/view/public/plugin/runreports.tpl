<script src="__STATIC__/plugin/graphics/bar1/esl.js"></script>
<script src="__STATIC__/plugin/graphics/bar1/config.js"></script>
<style>
    html, body, #main {
        width: 100%;
        height: 100%;
        margin: 0;
    }
    #main {
        width: 1200px;
        background: #fff;
    }
</style>
<script>
    require([
        '__STATIC__/plugin/graphics/bar1/echarts'
                // 'echarts/chart/bar',
                // 'echarts/component/legend',
                // 'echarts/component/grid',
                // 'echarts/component/tooltip'
    ], function (echarts) {

        var chart = echarts.init(document.getElementById('main'), null, {

        });

        var labelOption = {
            normal: {
                show: true,
                position: 'insideBottom',
                rotate: 90,
                textStyle: {
                    align: 'left',
                    verticalAlign: 'middle'
                }
            }
        };

        option = {
            color: ['#003366', '#006699', '#4cabce', '#e5323e'],
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data: ['订单总额', '商品总数', '商品成本', '物流费用']
            },
            toolbox: {
                show: true,
                orient: 'vertical',
                left: 'right',
                top: 'center',
                feature: {
                    mark: {show: true},
                    dataView: {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            calculable: true,
            xAxis: [
                {
                    type: 'category',
                    axisTick: {show: false},
//                    data: ['2019-01', '2019-02', '2019-03', '2019-04', '2019-05', '2019-05', '2019-05', '2019-05']
                    data: {$date_list}
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '订单总额',
                    type: 'bar',
                    barGap: 0,
                    label: labelOption,
                    data: {$total_order_list}
                },
                {
                    name: '商品总数',
                    type: 'bar',
                    label: labelOption,
                    data: {$total_goods_num_list}
                },
                {
                    name: '商品成本',
                    type: 'bar',
                    label: labelOption,
                    data: {$cost_goods_list}
                },
                {
                    name: '物流费用',
                    type: 'bar',
                    label: labelOption,
                    data: {$logistics_cost_list}
                }
            ]
        }

        chart.setOption(option);
    });

</script>