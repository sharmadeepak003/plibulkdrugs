@extends('layouts.master')

@section('title')
Login - PLI Bulk Drugs
@endsection

@push('styles')
<link href="{{ asset('css/login/login.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="main-body">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-5 offset-1">
                <div class="card">
                    <div class="card-header">
                        <h3>Sign In</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>

                                <input id="identity" type="text"
                                    class="form-control @if($errors->has('pan')) {{ $errors->has('pan') ? ' is-invalid' : '' }} @elseif($errors->has('email')) {{ $errors->has('email') ? ' is-invalid' : '' }} @endif"
                                    name="identity" value="{{ old('identity') }}" placeholder="PAN of Applicant / Company"
                                    required autofocus>

                                @if ($errors->has('pan') OR $errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                    <strong>{{ $errors->first('pan') }}</strong>
                                </span>
                                @endif

                            </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password" autocomplete="off" required>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row align-items-center remember">
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
<div class="input-group form-group">
                                <img class="col-md-4" src="{{ route('captcha') }}" alt="CAPTCHA Image" id="captchaImage">
                                <input  class="form-control col-md-6 m-1"  type="text" name="captcha" >
                            </div>
                                @error('captcha')
                                    <span class ="text-warning" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                                        <div class="form-group">
                                <button type="submit" class="btn float-right login_btn">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                <a class="btn colyellow" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>

                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center links">
                            Please login with your PAN as user ID
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-5 col-lg-5 offset-1">
                <div class="row" style="width: 120%;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-info instr-card-header">
                                <b>Important Instructions</b>
                            </div>
                            <div class="card-body instr-card-body">
                                <ul class="list-group" style="background-color: #000; font-size:13px; font-weight:600;height: 358px;">
                                    <li class="list-group-item"><i class="fas fa-chevron-right"></i> Please arrange for all the information before filling
                                        application</li>
                                    {{-- <li class="list-group-item"><i class="fas fa-chevron-right"></i> Please use a strong password to protect your account like Is at least 8 characters long, Contains at least one lowercase letter, Contains at least one uppercase letter, Contains at least one digit and Contains at least one special character from
                                        @$!%*?&
                                    </li> --}}
                                    <li class="list-group-item"><i class="fas fa-chevron-right"></i><span class="text-danger"> Password should be</span> at least 8 characters long, including one lowercase letter, one uppercase letter, one number, and one special character from @$!%*?&
                                    </li>
                                    <li class="list-group-item"><i class="fas fa-chevron-right"></i> <span class="text-danger">DO NOT</span> provide your
                                        username and password
                                        anywhere other than in this page</li>
                                    <li class="list-group-item"><i class="fas fa-chevron-right"></i> Your username and password are highly confidential.
                                        <span class="text-danger">NEVER</span>
                                        part with them. IFCI will never ask for this information</li>
                                    <li class="list-group-item"><i class="fas fa-chevron-right"></i> <span class="text-danger">ALWAYS</span> visit the portal
                                        directly instead of
                                        clicking on the links provided in emails or third party websites</li>
                                    <li class="list-group-item"><i class="fas fa-chevron-right"></i>
                                        <span class="text-danger">NEVER</span> respond to any popup,email, SMS or
                                        phone call, no matter how appealing or official looking, seeking your
                                        personal information such as username, password(s), mobile number, etc.
                                        Such communications are sent or created by fraudsters to trick you into
                                        parting with your credentials
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/landing/crypto-js.min.js') }}"></script>
<script src="{{ asset('js/landing/aes.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
       document.querySelector('#loginForm').addEventListener('submit', (e) => {
        e.preventDefault();
        var id = document.getElementById("identity");
        var pwd = document.getElementById("password");

        var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
        var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");


        var encId = CryptoJS.AES.encrypt(id.value, key, {iv,padding: CryptoJS.pad.ZeroPadding,});
        var encPwd = CryptoJS.AES.encrypt(pwd.value, key, {iv,padding: CryptoJS.pad.ZeroPadding,});


        id.value = encId.toString();
        pwd.value = encPwd.toString();
        var loginForm = document.getElementById("loginForm");
        loginForm.submit();
});
    </script>
@endpush
