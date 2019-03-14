<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Alexis</title>
                <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('assets/img/games.ico')}}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="{{asset('assets/css/vendor.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/jquery-ui/jquery-ui.css')}}">
        <link rel="stylesheet" href="{{asset('assets/datatables/datatables.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/datatables/Responsive-2.2.2/css/responsive.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('assets/datepicker/css/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/select2/select2.css')}}">
        <link rel="stylesheet" href="{{asset('assets/select2/select2-bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/jquery-confirm/jquery-confirm.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/jquery-toast/jquery.toast.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
        {{-- <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC|Chakra+Petch|Quantico|Russo+One" rel="stylesheet"> --}}
        {{-- <link rel="stylesheet" href="{{asset('assets/fonts/Chakra_Petch/ChakraPetch-Regular.ttf')}}"> --}}

        <!-- Theme initialization -->
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';


            var firstUrl = "{{ url('/') }}";

            if (themeName)
            {
                // $(document.head).append('<link rel="stylesheet" id="theme-style" href="' + firstUrl +'/assets/css/app-' + themeName + '.css">');
                document.write('<link rel="stylesheet" id="theme-style" href="' + firstUrl +'/assets/css/app-' + themeName + '.css">');
            }
            else
            {
                // $(document.head).append('<link rel="stylesheet" id="theme-style" href="' + firstUrl +'/assets/css/app.css">');
                document.write('<link rel="stylesheet" id="theme-style" href="' + firstUrl +'/assets/css/app.css">');
            }
        </script>
        <style type="text/css">
            .sidebar .sidebar-menu > li > a i {
    
                width: 15px !important;

            }
            .sidebar .sidebar-menu > li > a i.arrow {
    
                width: 8px !important;

            }
            .datetimepicker {
                position: absolute;
                background: white;
                border: 1px solid #ddd;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/alamraya-style.css')}}">
        
</head>