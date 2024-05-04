@extends('layouts.app')
@section('content')
    <div class="main-wrapper">
        <div class="account-content">
            
            <div class="container">
                <!-- Account Logo -->
                <div class="account-logo">
                    <a href="{{route('home')}}"><img src="{{ URL::to('assets/img/logo2.png') }}" alt="Soeng Souy"></a>
                </div>
                {{-- message --}}
                {!! Toastr::message() !!}
                <!-- /Account Logo -->
                <div class="account-box">
                    <div class="account-wrapper text-right">
                        <h3 class="account-title">هل نسيت كلمة السر</h3>
                        <p class="account-subtitle">.أدخل بريدك الإلكتروني وأرسل لك رابط إعادة تعيين كلمة المرور</p>
                        <!-- Account Form -->
                        <form method="POST" action="/forget-password">
                            @csrf
                            <style>
                                /* Custom CSS to align label and placeholder to the right */
                                .form-group label {
                                    text-align: right;
                                }
                                .form-control::placeholder {
                                    text-align: right;
                                    direction: rtl;
                                }
                            </style>
                            <div class="form-group">
                                <label>عنوان البريد الإلكتروني</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="   البريد الإلكتروني  ">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">حفظ</button>
                            </div>
                            <div class="account-footer">
                                <p>لا تملك حسابا حتى الآن؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
                            </div>
                        </form>
                        <!-- /Account Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
