<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mariano Dashboard</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @csrf
    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="icon" type="png" href="{{ asset("images/mariano_fav.png") }}">
    <link rel="shortcut icon" type="png" href="{{ asset("images/mariano_fav.png") }}">

    <link rel="stylesheet" href="{{ asset("css/normalize.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    {{-- <link rel="stylesheet" href="{{ asset("css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/themify-icons.css") }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset("css/pe-icon-7-stroke.min.css") }}"> --}}
    <link rel="stylesheet" href="{{ asset("css/flag-icon.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/cs-skin-elastic.css") }}">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{ asset('plugins/noty/noty.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/noty/themes/sunset.css') }}">

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="{{ asset("css/chartist.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/jqvmap.min.css") }}" rel="stylesheet">

    <link href="{{ asset("css/weather-icons.css") }}" rel="stylesheet" />
    <link href="{{ asset("css/fullcalendar.min.css") }}" rel="stylesheet" />
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

   <style>
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 275px;
        }
        #flotPie1  {
            width:350px;height:450px;
        }
        #flotPie1 td {
            padding:3px;
        }
        /* #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        } */
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }

    </style>
</head>

<body>
    <!-- Left Panel -->
    @include('layouts.admin.sidebar')
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        @include('layouts.admin.nav')
        <!-- /#header -->
        <!-- Content -->
        @yield('content')
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <!-- <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; 2022 Mariano
                    </div>
                 
                </div>
            </div>
        </footer> -->
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    <script src="{{ asset("js/jquery.min.js") }}"></script>
    
    <script src="{{ asset("js/popper.min.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("js/jquery.matchHeight.min.js") }}"></script>
    {{-- <script src="{{ asset("js/main.js") }}"></script> --}}

    <!--  Chart js -->
    <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>

    <!--Chartist Chart-->
    <script src="{{ asset("js/chartist.min.js") }}"></script>
    <script src="{{ asset("js/chartist-plugin-legend.min.js") }}"></script>

    <script src="{{ asset("js/jquery.flot.min.js") }}"></script>
    <script src="{{ asset("js/jquery.flot.pie.min.js") }}"></script>
    <script src="{{ asset("js/jquery.flot.spline.min.js") }}"></script>

    <script src="{{ asset("js/jquery.simpleWeather.min.js") }}"></script>
    <script src="{{ asset("js/init/weather-init.js") }}"></script>

    <script src="{{ asset("js/moment.min.js") }}"></script>
    <script src="{{ asset("js/fullcalendar.min.js") }}"></script>
    <script src="{{ asset("js/init/fullcalendar-init.js") }}"></script>
    <script src="{{ asset('plugins/noty/noty.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('plugins/select2/js/select2.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  
    <script>
        $('.daterange').daterangepicker({
            autoUpdateInput: false,
            // minDate: moment(),
            locale: {
                format: 'DD-MM-YYYY'
            },
            // maxSpan: {
            //     days: 9
            // },
        });
        $('.daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $("input[name='startDate']").val(picker.startDate.format('YYYY-MM-DD'));
            $("input[name='endDate']").val(picker.endDate.format('YYYY-MM-DD'));
        });
        $('#session_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $("input[name='SstartDate']").val(picker.startDate.format('YYYY-MM-DD'));
            $("input[name='SendDate']").val(picker.endDate.format('YYYY-MM-DD'));
        });
    </script>

    <script>
        $(document).ready(function() {
        $('.select').select2({
                theme: "classic",
                width: "100%"
            });
        });
        
    </script>
    @if (Session::has('notification'))
    <script>
        var n = new Noty({
            type: '{{ Session::get('notification')['status'] }}'
            , text: '{{ Session::get('notification')['message'] }}'
            , timeout: 3000
        }).show();
 
    </script>
    @endif

    <!--Local Stuff-->
    @yield("footer-script")
</body>
</html>
