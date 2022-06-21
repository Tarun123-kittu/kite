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

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="icon" type="png" href="/images/mariano_fav.png">
    <link rel="shortcut icon" type="png" href="/images/mariano_fav.png">

    <link rel="stylesheet" href="{{ asset("css/normalize.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/themify-icons.css") }}">
    <link rel="stylesheet" href="{{ asset("css/pe-icon-7-stroke.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/flag-icon.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/cs-skin-elastic.css") }}">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <link rel="stylesheet" href="{{ asset('plugins/noty/noty.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/noty/themes/sunset.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body class="bg-dark">
    @yield('content')

   

    <script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ asset('plugins/noty/noty.js') }}"></script>
    <script src="{{ asset("js/popper.min.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("js/jquery.matchHeight.min.js") }}"></script>

    @if(Session::has('notification'))
    <script>
        var n = new Noty({type:'{{Session::get('notification')['status']}}',text:'{{Session::get('notification')['message']}}',timeout:3000}).show();
    </script>
    @endif
    @yield('footer-script')


</body>
</html>
