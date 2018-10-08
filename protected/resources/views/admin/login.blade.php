@extends('admin.layouts.app-login')
@section('content')

    <div class="row">

    <div class="col-lg-6">
        <img src="{{ URL::asset('img/bg-gotongroyong.jpg') }}" style="height: 100%; width: 100%;" alt="image login">
    </div>

    <div class="col-lg-6">
        <div class="login-box" style="margin-top: 15%; margin-bottom: 20%;">
            <div class="login-logo">
                <a href="../../index2.html"><b>GotongRoyong Admin Dashboard</b></a>
            </div>
                {{--<h1 class="text-center">--}}
                    {{--<a href="#">--}}
                        {{--<b>Manaya Admin Dashboard</b>--}}
                    {{--</a>--}}
                {{--</h1>--}}
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Future Donation Solution</p>
                    @if(Session::get('gagal'))
                        <p style="color: red;" class="login-box-msg">{{ Session::get('gagal') }}</p>
                    @endif

                    <form action="{{ route('login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ old('email') }}" required autofocus placeholder="E-mail">

                            {{--<input type="text" class="form-control" name="username" placeholder="Username">--}}
                            <div class="input-group-append">
                                <span class="fa fa-envelope input-group-text"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <div class="input-group mb-3">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" placeholder="Password" required>

                            <div class="input-group-append">
                                <span class="fa fa-lock input-group-text"></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <div class="row">
                            <div class="col-8">
                                <div class="checkbox icheck">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" >Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    {{--<div class="social-auth-links text-center mb-3">--}}
                        {{--<p>- OR -</p>--}}
                        {{--<a href="#" class="btn btn-block btn-primary">--}}
                            {{--<i class="fa fa-facebook mr-2"></i> Sign in using Facebook--}}
                        {{--</a>--}}
                        {{--<a href="#" class="btn btn-block btn-danger">--}}
                            {{--<i class="fa fa-google-plus mr-2"></i> Sign in using Google+--}}
                        {{--</a>--}}
                    {{--</div>--}}
                    <!-- /.social-auth-links -->

                    <p class="mb-1">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>

                        {{--<a href="#">I forgot my password</a>--}}
                    </p>
                    <p class="mb-0">
                        <a href="http://gotongroyong.in" class="text-center">Become partner</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
    </div>

    </div>
@endsection