@extends('layouts.admin.app')

@section('content')    
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Smat</b>Serve App</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in</p>
        <!-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->
                <form action="{{url('login')}}" method="post">
                    @csrf
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        
                        <input type="email" id="email" class="form-control" name="email" placeholder="Email">
                        <!-- <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div> -->
                        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                        
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                        <!-- <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div> -->
                        @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                    </div>

                    <div class="row">
                        <!-- <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div> -->
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div> -->
                <!-- /.social-auth-links -->

                {{-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p> --}}
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection