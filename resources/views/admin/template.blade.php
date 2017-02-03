<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>Admin</title>

    <!-- Custom Fonts -->
    <link href="{{ url('/css/admin/admin.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('/css/admin/select2.min.css')}}" rel="stylesheet" />
    <link href="{{ url('/js/admin/datetimepicker/build/jquery.datetimepicker.min.css')}}" rel="stylesheet" />

    <link rel="stylesheet" href="{{url('js/admin/jquery-ui.css')}}">
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <!-- /.navbar-header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Admin</a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown-user -->
            <!-- /.dropdown -->

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <!-- /.dropdown-tasks -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <!-- /.dropdown-alerts -->
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{url('admin/logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{url('admin')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>

                    @foreach (config('site')['content'] as $key => $content)

                    <li>
                        <a><i class="fa fa-files-o fa-fw"></i>{{$content['name']}}<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">

                            <li>
                                <a href="{{url('admin', $key)}}">List</a>
                            </li>

                        </ul>
                    </li>
                    @endforeach

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>


    <div id="page-wrapper">
     @include('flash::message')
        @yield('content')
    </div>


</div>
<script>
    var Config = {};
    window.baseUrl = '{{url('/')}}';
</script>

<script src="{{url('js/admin/admin.js')}}"></script>
<script src="{{url('js/admin/ckeditor/ckeditor.js')}}"></script>
<script src="{{url('js/admin/select2.min.js')}}"></script>
<script src="{{url('js/admin/datetimepicker/build/jquery.datetimepicker.full.min.js')}}"></script>
<script src="{{url('js/admin/jquery-ui.js')}}"></script>
<script src="{{url('js/admin/moment.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=csrf_token]').attr('content') }
    });
    var baseUrl = "{{url('/')}}";

</script>
@yield('footer')
</body>
</html>
