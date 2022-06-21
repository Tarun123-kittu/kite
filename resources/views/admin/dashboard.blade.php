@extends('layouts.admin.layout')

@section('content')
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">

            <form method="GET">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Period">Period</label>
                            <select name="period" id="period" class="form-control">
                                <option disabled selected>Select</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="month">So far this month</option>
                                <option value="seven_days">last seven days</option>
                                <option value="last_month">Last month</option>
                                <option value="">Custom date</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">

                            <label for="">Date Range</label>
                            <input type="text" value="" placeholder="Creation Date"
                                class='form-control demo sel_date daterange reset' name="creation_date" id="creation_date"
                                autocomplete="off" readonly style="background:white" disabled>
                            <input class="reset" type="hidden" name="startDate">
                            <input class="reset" type="hidden" name="endDate">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Campaign</label>
                            <select name="campaign" id="campaign" class="form-control">
                                <option disabled selected>Select</option>
                                @foreach ($data['campaign'] as $campaign)
                                    <option value="{{ $campaign->campaign }}">{{ $campaign->campaign }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Format</label>
                            <select name="format" id="format" class="form-control">
                                <option disabled selected>Select</option>
                                @foreach ($data['formats'] as $format)
                                    <option value="{{ $format->format }}">{{ $format->format }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="" class="d-block" style="opacity: 0;">SEARCH</label>
                            <button type="submit" class="btn btn-primary cm-btn">Search</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" class="d-block" style="opacity: 0;">SEARCH</label>
                            <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                                class="btn btn-danger cm-btn">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">

                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="count">{{ number_format($data['overview']->sum('impressions')) }}</span>
                                        </div>
                                        <div class="stat-heading">Impressions

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">

                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="count">{{ number_format($data['overview']->sum('views')) }}</span>
                                        </div>
                                        <div class="stat-heading">Views</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">

                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="count">{{ number_format($data['overview']->sum('clicks')) }}</span>
                                        </div>
                                        <div class="stat-heading">Clicks</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">

                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="count">{{ number_format($data['overview']->sum('engagements')) }}</span>
                                        </div>
                                        <div class="stat-heading">Engagements</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">

                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="count">{{ $data['cpcv']->sum('impressions') == 0 ? 0 : round($data['cpcv']->sum('views') / $data['cpcv']->sum('impressions'), 2) }}%</span>
                                        </div>
                                        <div class="stat-heading">CPCV

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">

                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="count">{{ $data['ctr']->sum('impressions') == 0 ? 0 : round($data['ctr']->sum('clicks') / $data['ctr']->sum('impressions'), 2) }}%</span>
                                        </div>
                                        <div class="stat-heading">CTR</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span
                                                class="count">{{ $data['egRate']->sum('impressions') == 0 ? 0 : round($data['egRate']->sum('engagements') / $data['egRate']->sum('impressions'), 2) }}%</span>
                                        </div>
                                        <div class="stat-heading">Engagement Rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-9 ">
                    <div class="card">
                        <div class="card-body p-2 px-4">
                            <h4 class="box-title">Statistics </h4>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-body">
                                    <div id="traffic-chart" class="traffic-chart"></div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>




            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">Formats </h4>
                        </div>
                        <div class="card-body--">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>

                                            <th>Format</th>
                                            <th>Impressions</th>
                                            <th>Views</th>
                                            <th>Clicks</th>
                                            <th>Engagements</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['format'] as $value)
                                            <tr>
                                                <td> {{ $value->format ?? 'N/A' }}</td>
                                                <td> <span class="name">{{ $value->impressions ?? '0' }}</span>
                                                </td>
                                                <td> <span class="product">{{ $value->views ?? '0' }}</span> </td>
                                                <td><span class="count">{{ $value->clicks ?? '0' }}</span></td>
                                                <td><span class="count">{{ $value->engagements ?? '0' }}</span>
                                                </td>

                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card br-0">
                        <div class="card-body">
                            <div class="chart-container ov-h">
                                <div id="flotPie1" class="float-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('footer-script')
    <script>
        jQuery(document).ready(function($) {
            "use strict";
            // Pie chart flotPie1
            var deviceData = <?php echo $data['device']; ?>;
            var piedata = deviceData;

            Highcharts.chart('flotPie1', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Device Usage World wide'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Device',
                    colorByPoint: true,
                    data: piedata
                }]
            });

            var data = <?php echo $data['graph']; ?>;
            var count = data.length;
            var views = [];
            var impressions = [];
            var date = [];
            var i;
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            
            for(i=0 ; i < count ; i++){
                views.push(data[i].views);
                impressions.push(data[i].impressions);
                date.push(data[i].date);
            }
            
            // for (i = 0; i < 12; i++) {

            //     if (data[i]) {
            //         views[(parseInt(data[i].month - 1))] = data[i].views;
            //         impressions[(parseInt(data[i].month - 1))] = data[i].impressions;
            //     }
            //     if (typeof(views[i]) == "undefined") {
            //         console.log(views[i])
            //         views[i] = null;
            //         impressions[i] = null;
            //     }


            // }
        

            Highcharts.chart('traffic-chart', {

                title: {
                    text: 'views and impressions'
                },

                yAxis: {
                    title: {
                        text: 'Numbers'
                    }
                },

                xAxis: {
                    categories: date,

                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                credits: {
                    enabled: false
                },

                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        },
                        /* pointStart: 2010 */
                    }
                },

                series: [{
                    name: 'Views',
                    data: views
                }, {
                    name: 'Impressions',
                    data: impressions
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }

            });


        });


        $("#period").change(function() {
            if ($(this).find(":selected").text() == 'Custom date') {
                $('#creation_date').removeAttr("disabled");
            } else {
                $('#creation_date').attr("disabled", "disabled");
                $('.reset').val("");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#menuToggle").click(function() {
                $("body").toggleClass("open");
            });
        });
    </script>
@endsection
