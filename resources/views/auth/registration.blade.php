<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bug Tracker') }}</title>

        <link rel="stylesheet" href="/css/app.css">

    </head>
    <body class="row">
        <div class="container justify-content-center mt-5">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="card text-center col-md-4 mt-5">
                    <div class="card-title">
                        <br>
                        <br>
                        <h3 href="#"><b>Bug Tracker </b>app</h3>
                    </div>

                    <div class="card-body">
                            <h4 class="">Register as:</h4>
                                <div class="row justify-content-center">
                                        <a class="btn btn-success p-3 m-1 col-md-5" href="/register/user">User</a>
                                        <a class="btn btn-primary p-3 m-1 col-md-5" href="/register/admin">Admin</a>
                                        <a class="btn btn-warning p-3 m-1 col-md-5" href="/register/project_manager">Manager</a>
                                        <a class="btn btn-dark p-3 m-1 col-md-5" href="/register/developer">Developer</a>
                                        <a class="col-md-10 text-secondary" href="/">I want to Login</a>
                                </div>
                        </div>
                        <!-- /.form-box -->
                    </div><!-- /.card -->
                <div class="col-md-4"></div>
            </div>
        </div>
    </body>
</html>
