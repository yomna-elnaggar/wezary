@extends('layouts.app')
@section('content')
    <div class="main-wrapper">
        <div class="account-content">
            {{-- <a href="{{ route('form/job/list') }}" class="btn btn-primary apply-btn">Apply Job</a> --}}
            <div class="container">
                <!-- Account Logo -->
                <div class="account-logo">
                    <a href="index.html"><img src="{{ URL::to('assets/img/logo2.png') }}" alt="Soeng Souy"></a>
                </div>
                {{-- message --}}
                {!! Toastr::message() !!}
                <!-- /Account Logo -->
                <div class="account-box">
                    <div class="account-wrapper text-right">
                        <h3 class="account-title">تسجيل الدخول</h3>
                        <p class="account-subtitle">الوصول إلى لوحة القيادة لدينا</p>
                        <!-- Account Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <style>
                                /* Custom CSS to align labels and placeholders to the right */
                                .form-group label {
                                    text-align: right;
                                }
                                .form-control::placeholder {
                                    text-align: right;
                                    direction: rtl;
                                }
                            </style>
                            <div class="form-group">
                                <label>البريد الإلكتروني</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="أدخل البريد الإلكتروني">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>كلمة المرور</label>
                                    </div>
                                </div>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="أدخل كلمة المرور">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label></label>
                                    </div>
                                    <div class="col-auto">
                                        <a class="text-muted" href="{{ route('forget-password') }}">
                                           هل نسيت كلمة السر؟
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">تسجيل الدخول</button>
                            </div>
                            <div class="account-footer">
                                <p>لا تملك حسابا حتى الآن؟ <a href="{{ route('register') }}">انشاء حساب</a></p>
                            </div>
                        </form>
                        <!-- /Account Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
