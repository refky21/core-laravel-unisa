@extends('core::base.auth.auth_layout')
@section('title')
{{translate('Login')}}
@endsection
@section('main_content')
<div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-5 d-flex justify-content-center">
                    <a href="{{route('core.login')}}">
                        <img src="{{asset('/public/backend/assets/images/brand-logos/desktop-logo.png')}}" alt="logo" class="desktop-logo">
                    </a>
                </div>
                <div class="card custom-card">
                    <div class="card-body p-5">
                        <p class="h5 fw-semibold mb-2 text-center">{{translate('Login To')}}</p>
                        <p class="mb-4 text-muted op-7 fw-normal text-center">{{ getGeneralSetting('system_name') }}</p>
                        <form action="{{route('core.attemptLogin')}}" method="post">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="email" class="form-label text-default">{{translate('Email')}}</label>
                                <input class="form-control form-control-lg" type="email" id="email" name="email"  placeholder="{{translate('Email Address')}}" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="password" class="form-label text-default d-block">{{translate('Password')}}<a href="{{route('core.password.reset.link')}}" class="float-end text-danger">{{translate('Forgot Password?')}}</a></label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg"  placeholder="{{translate('********')}}">
                                    <button class="btn btn-light" type="button" onclick="createpassword('password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    @if ($errors->has('password'))
                                        <div class="text-danger mt-2">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                                <button type="submit" class="btn btn-lg btn-primary">{{translate('Log In')}}</button>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="fs-12 text-muted mt-3">Dont have an account? <a href="sign-up-basic.html" class="text-primary">Sign Up</a></p>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
