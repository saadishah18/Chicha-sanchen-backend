@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Post View Analytics</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <?php
                $view_type = $data['view_type'];
                $output_type = $data['output_type'];
                $post_count = $data['post_count'];
                $halfyear_count = $data['halfyear_count'];
                $year_count = $data['year_count'];
                $total_count = $data['total_count'];
                $today_sum = $data['today_sum'];
                $week_sum = $data['week_sum'];
                $month_sum = $data['month_sum'];
                $halfyear_sum = $data['halfyear_sum'];
                $year_sum = $data['year_sum'];

                $charts_count1 = get_post_views_news('today', 'count');
                $charts_count2 = get_post_views_news('weekly', 'count');
                $charts_count3 = get_post_views_news('monthly', 'count');
                if(request()->has('year_id')&& request()->year_id !=date('Y')){
                    $charts_count4 = get_post_views_news('pre_monthly', 'count', request()->year_id);
                }
                ?>
                <table class="table table-bordered table-responsive" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Viewed Post (Today)</th>
                        <th colspan="3">Viewed Post (Today) </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><img src="https://chart.googleapis.com/chart?cht=p&amp;chd=t:<?php echo get_post_viewed_coverage($view_type,'today',$output_type,'+','100');?>,<?php echo get_post_viewed_coverage($view_type,'today',$output_type,'-','100');?>&amp;chds=0,<?php echo $post_count; ?>&amp;chs=250x180&amp;chdl=<?php echo get_post_viewed_coverage($view_type,'today',$output_type,'+','%'); ?> Read|<?php echo get_post_viewed_coverage($view_type,'today',$output_type,'-','%');?> Unread&amp;chco=206582"></td>
                        <td colspan="3">
                            <div id="curve_chart" style="width: <?php echo $charts_count1*30 ?>px; height: 500px"></div>
                        </td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th>Viewed Post (Week)</th>
                        <th colspan="3">Viewed Post (%) </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><img src="https://chart.googleapis.com/chart?cht=p&amp;chd=t:<?php echo get_post_viewed_coverage($view_type,'week',$output_type,'+','100');?>,<?php echo get_post_viewed_coverage($view_type,'week',$output_type,'-','100');?>&amp;chds=0,<?php echo $post_count; ?>&amp;chs=250x160&amp;chdl=<?php echo get_post_viewed_coverage($view_type,'week',$output_type,'+','%'); ?> Read|<?php echo get_post_viewed_coverage($view_type,'week',$output_type,'-','%');?> Unread&amp;chco=206582"></td>
                        <td colspan="3"><div id="curve_chart_2" style="width: <?php echo $charts_count2*80 ?>px; height: 500px"></div>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th>Viewed Post (Month)</th>
                        <th colspan="3">Viewed Post (%) </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><img src="https://chart.googleapis.com/chart?cht=p&amp;chd=t:<?php echo get_post_viewed_coverage($view_type,'month',$output_type,'+','100');?>,<?php echo get_post_viewed_coverage($view_type,'month',$output_type,'-','100');?>&amp;chds=0,<?php echo $post_count; ?>&amp;chs=250x160&amp;chdl=<?php echo get_post_viewed_coverage($view_type,'month',$output_type,'+','%'); ?> Read|<?php echo get_post_viewed_coverage($view_type,'month',$output_type,'-','%');?> Unread&amp;chco=206582"></td>
                        <td colspan="3"><div id="curve_chart_3" style="width: <?php echo ((int)$charts_count3*50) ?>px; height: 500px"></div></td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <th scope="col">Viewed Post ( This Half Year )</th>
                        <th scope="col">Viewed Post ( This Year )</th>
                        <th scope="col">Viewed Post ( All Past Days )</th>
                        <th scope="col">Views Contribution ( This Year )</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><img src="https://chart.googleapis.com/chart?cht=p3&amp;chd=t:<?php echo $halfyear_count;?>,<?php echo $post_count - $halfyear_count;?>&amp;chds=0,<?php echo $post_count; ?>&amp;chs=250x160&amp;chdl=<?php echo get_post_viewed_coverage($view_type,'halfyear',$output_type,'+','%'); ?> Read|<?php echo get_post_viewed_coverage($view_type,'halfyear',$output_type,'-','%');?> Unread&amp;chco=206582"></td>
                        <td><img src="https://chart.googleapis.com/chart?cht=p3&amp;chd=t:<?php echo $year_count;?>,<?php echo $post_count - $year_count;?>&amp;chds=0,<?php echo $post_count; ?>&amp;chs=250x160&amp;chdl=<?php echo get_post_viewed_coverage($view_type,'year',$output_type,'+','%'); ?> Read|<?php echo get_post_viewed_coverage($view_type,'year',$output_type,'-','%');?> Unread&amp;chco=206582"></td>
                        <td><img src="https://chart.googleapis.com/chart?cht=p3&amp;chd=t:<?php echo $total_count;?>,<?php echo $post_count - $total_count;?>&amp;chds=0,<?php echo $post_count; ?>&amp;chs=250x160&amp;chdl=<?php echo get_post_viewed_coverage($view_type,'total',$output_type,'+','%'); ?> Read|<?php echo get_post_viewed_coverage($view_type,'total',$output_type,'-','%');?> Unread&amp;chco=206582"></td>
                        <td><img src="https://chart.googleapis.com/chart?cht=bvs&amp;chbh=r,0.2,0.5&amp;chd=t:<?php echo $today_sum;?>,<?php echo $week_sum;?>,<?php echo $month_sum;?>,<?php echo $halfyear_sum;?>|<?php echo ($week_sum - $today_sum);?>,<?php echo ($month_sum - $week_sum);?>,<?php echo ($halfyear_sum - $month_sum);?>,<?php echo ($year_sum - $halfyear_sum);?>&amp;chds=0,<?php echo $year_sum; ?>&amp;chxr=1,0,<?php echo $year_sum; ?>&amp;chs=270x140&amp;chxt=x,y&amp;chxp=1,<?php echo $month_sum;?><?php if($year_sum != $month_sum) echo ",".$year_sum;?>&amp;chxl=0:|T / W|W / M|M / HY|HY / Y||1:|<?php echo number_format($month_sum);?><?php if($year_sum != $month_sum) echo "|".number_format($year_sum);?>&amp;chco=206582,C6D9FD"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php
    $charts1 = get_post_views_news('today');
    $charts2 = get_post_views_news('weekly');
    $charts3 = get_post_views_news('monthly');
    if(request()->has('year_id')){
        $charts4 = get_post_views_news('pre_monthly', NULL, request()->year_id);
    }
    ?>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        google.charts.setOnLoadCallback(drawChart2);
        if ("{{!empty($charts3)}}"){
            google.charts.setOnLoadCallback(drawChart3);
        }
        google.charts.setOnLoadCallback(drawChart4);


        function drawChart1() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Today Views'],
                <?php
                $array = array();
                if(!empty($charts1)){
                    foreach($charts1 as $chart1){
                        $array[]  = "['".$chart1['key']."',  ".$chart1['value']."]";
                    }
                    echo implode(',', $array);
                }
                ?>
            ]);

            var options = {
                title: 'Post Views',
                curveType: 'function',
                legend: { position: 'left' },
                pointSize: 10,
            };
            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
        function drawChart2() {
            var data2 = google.visualization.arrayToDataTable([
                ['Year', 'Weekly Views'],
                <?php
                $array = array();
                if(!empty($charts2)){
                    foreach($charts2 as $chart2){
                        $array[]  = "['".$chart2['key']."',  ".$chart2['value']."]";
                    }
                    echo implode(',', $array);
                }
                ?>
            ]);
            var options2 = {
                title: 'Post Views',
                curveType: 'function',
                legend: { position: 'bottom' },
                pointSize: 10,
            };
            var chart2 = new google.visualization.LineChart(document.getElementById('curve_chart_2'));
            chart2.draw(data2, options2);
        }
        function drawChart3() {
            var data3 = google.visualization.arrayToDataTable([
                ['Year', 'Monthly Views'],
                <?php
                $array = array();
                if(!empty($charts3)){
                    foreach($charts3 as $chart3){
                        $array[]  = "['".$chart3['key']."',  ".$chart3['value']."]";
                    }
                    echo implode(',', $array);
                }
                ?>
            ]);
            var options3 = {
                title: 'Post Views',
                curveType: 'function',
                legend: { position: 'bottom' },
                pointSize: 10,
            };
            var chart3 = new google.visualization.LineChart(document.getElementById('curve_chart_3'));
            chart3.draw(data3, options3);
        }
        function drawChart4() {
            var data4 = google.visualization.arrayToDataTable([
                ['Year', 'Monthly Views'],
                <?php
                $array = array();
                if(!empty($charts4)){
                    foreach($charts4 as $chart4){
                        $array[]  = "['".$chart4['key']."',  ".$chart4['value']."]";
                    }
                    echo implode(',', $array);
                }
                ?>
            ]);
            var options4 = {
                title: 'Post Views',
                curveType: 'function',
                legend: { position: 'bottom' },
                pointSize: 10,
            };
            var chart4 = new google.visualization.LineChart(document.getElementById('curve_chart_4'));
            chart4.draw(data4, options4);
        }
    </script>
@endsection
@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection

