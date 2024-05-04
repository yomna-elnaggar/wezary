@extends('layouts.app')
@section('content')
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">
                <!-- Account Logo -->
                <div class="account-logo">
                    <a href="{{route('home')}}"><img src="{{ URL::to('assets/img/logo2.png') }}" alt="SoengSouy"></a>
                </div>
                {{-- message --}}
                {!! Toastr::message() !!}
                <!-- /Account Logo -->
                <div class="account-box">
                    <div class="account-wrapper text-right">
                        <h3 class="account-title">إعادة تعيين كلمة المرور</h3>
                        <p class="account-subtitle">.أدخل بريدك الإلكتروني للتسجيل إعادة تعيين كلمة المرور الجديدة</p>
                        <!-- Account Form -->
                        <form method="POST" action="/reset-password">
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
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label>البريد الإلكتروني</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="أدخل بريدك الإلكتروني">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>كلمة المرور</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="أدخل كلمة المرور">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label><strong>اعد كلمة السر</strong></label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="اختر تكرار كلمة المرور">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">إعادة تعيين كلمة المرور</button>
                            </div>
                            <div class="account-footer">
                                <p>هل لديك حساب؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
                            </div>
                        </form>
                        <!-- /Account Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
