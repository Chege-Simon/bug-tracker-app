@extends('layouts.app')

@section('content')

    <div class=" row">
        <div class="col-md-4">

        </div>
        <div class=" col-md-4">
            <div class="login-logo">
                <a href="#"><b>{{ config('app.name', 'Easy Issue') }}
                    </b>app</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror

                        </div>
                        <div class="row">
                            <div class="col-7 ml-4">
                                <div class="icheck-primary">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mb-1">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                I forgot my password
                            </a>
                        @endif
                    </p>
                    <p class="btn btn-link">
                        <a href="/registration" class="text-center">Register a new account</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
        <div class="col-md-3 m-5">
            <h3>Demo Accounts</h3>
            <div class="alert alert-info p-3" style="width: 80%; height:
            15%">password
                to all
                demo
                accounts:-
                <code class="text-red">password</code>
            </div>
            <div class="container text-left mt-5">
                <p>Admin Role:</p>
                <code class="text-red">admin@bug.com</code>
                <p>Project Manager Role:</p>
                <code class="text-red">project_manager@bug.com</code>
                <p>Normal User Role:</p>
                <code class="text-red">user@bug.com</code>
                <p>Developer Role:</p>
                <code class="text-red">developer@bug.com</code>
{{--                <p>Supreme Admin Role:</p>--}}
{{--                <code class="text-red">supreme@bug.com</code>--}}
            </div>
        </div>
    </div>

@endsection
