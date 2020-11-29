<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="Dashtic - Bootstrap Webapp Responsive Dashboard Simple Admin Panel Premium HTML5 Template" name="description">
    <meta content="Spruko Technologies Private Limited" name="author">
    <meta name="keywords" content="Admin, Admin Template, Dashboard, Responsive, Admin Dashboard, Bootstrap, Bootstrap 4, Clean, Backend, Jquery, Modern, Web App, Admin Panel, Ui, Premium Admin Templates, Flat, Admin Theme, Ui Kit, Bootstrap Admin, Responsive Admin, Application, Template, Admin Themes, Dashboard Template"/>
    @include('layouts.head')
</head>

<body class="app sidebar-mini light-mode default-sidebar">
    @livewireStyles

    <!---Global-loader-->
    <div id="global-loader" >
        <img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
    </div>

    <div class="page">
        <div class="page-main">

            @include('layouts.side-menu')
            <div class="app-content main-content">
                <div class="side-app">
                    @include('layouts.header')
                    @yield('page-header')
                    @yield('content')
                    @include('layouts.footer')
                </div><!-- End Page -->
                @include('layouts.footer-scripts')
            </div>
        </div>
    </div>
    @livewireScripts

</body>
</html>
