
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bug Tracker') }}</title>

    <link rel="stylesheet" href="/css/app.css">
{{--    <!-- 1. Addchat css -->--}}
{{--    <link href="<?php echo asset('assets/addchat/css/addchat.min.css') ?>" rel="stylesheet">--}}
</head>
<body class="hold-transition sidebar-mini">
{{--<!-- 2. AddChat widget -->--}}
{{--<div id="addchat_app"--}}
{{--     data-baseurl="<?php echo url('') ?>"--}}
{{--     data-csrfname="<?php echo 'X-CSRF-Token' ?>"--}}
{{--     data-csrftoken="<?php echo csrf_token() ?>"--}}
{{--></div>--}}
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications side Menu -->
{{--            <li class="nav-item dropdown" >--}}
{{--                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">--}}
{{--                    <p><i class="fa fa-bell"></i> Notifications</p>--}}
{{--                    <span class="badge badge-warning navbar-badge">2</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <!-- User actions   -->
            <li>
            <li class="nav-item dropdown">
                <a class="nav-link " data-toggle="dropdown" href="#">
                    <i class="fa fa-user"></i> <span class="dark"> User Actions</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <router-link to="/profile" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i>Profile
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link to="/dashboard" class="brand-link">
            <img src="/images/bug.png" alt="Bug tracker Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Bug Tracker</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div>
                    <img class=" img-circle" style="width: 40px; height: 40px"
                         src="/images/profile/{{ Auth::user()->profile_pic }}"
                    class="img-circle elevation-2"
                         alt="User Image">
                </div>
                <div class="info">
                    <router-link to="/profile" class="d-block">Logged in as:
                        <div>
                            <strong class="text-warning">{{ Auth::user()->role }}</strong>
                            <p class="text-success m-0 p-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        </div>
                    </router-link>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link active">
                            <i class="nav-icon fa fa-accelerometer"></i>
                            <p>
                                Dashboard
                            </p>
                        </router-link>
                    </li>
                    @canany(['isAdmin', 'isProject_manager','isSupreme'])
                    <li class="nav-item has-treeview">
                        <a class="nav-link bg-warning">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>
                                Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('isSupreme')
                            <li class="nav-item">
                                <router-link to="/manageroles" href="#" class="nav-link">
                                    <i class="fa fa-cogs nav-icon
                            text-warning"></i>
                                    <p>Role Assignment</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/users" class="nav-link ">
                                    <i class="fa fa-users nav-icon
                                    text-success"></i>
                                    <p>Manage Users</p>
                                </router-link>
                            </li>
                            @endcan
                            <li class="nav-item">
                                <router-link to="/projects" class="nav-link ">
                                    <i class="fa fa-briefcase nav-icon"></i>
                                    <p>Projects</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/tickets" class="nav-link ">
                                    <i class="fa fa-file nav-icon"></i>
                                    <p>Tickets</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    @endcanany
                    <li class="nav-item">
                        <router-link to="/myprojects" class="nav-link ">
                            <i class="fa fa-list-alt nav-icon
                                    text-lime"></i>
                            <p>My Projects</p>
                        </router-link>
                    </li>

                    @can(['isDeveloper'])
                    <li class="nav-item">
                        <router-link to="/mytickets" class="nav-link">
                            <i class="nav-icon fas fa-th-list text-info"></i>
                            <p>
                                My Tickets
                            </p>
                        </router-link>
                    </li>
                    @endcan
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- route outlet -->
                <!-- component matched by the route will render here -->
                <router-view :user="{{ auth()->user() }}"></router-view>
                <!-- set progressbar -->
                <vue-progress-bar></vue-progress-bar>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Keep shipping
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2020 <a href="https://chegesimon.netlify.app/">Chege Simon</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->
@auth
    <script>
        window.user = @json(auth()->user())
    </script>
@endauth
<script src="/js/app.js">
</script>
{{--<!-- 3. AddChat JS -->--}}
{{--<!-- Modern browsers -->--}}
{{--<script type="module" src="<?php echo asset('assets/addchat/js/addchat.min.js') ?>"></script>--}}
{{--<!-- Fallback support for Older browsers -->--}}
{{--<script nomodule src="<?php echo asset('assets/addchat/js/addchat-legacy.min.js') ?>"></script>--}}
</body>
</html>
