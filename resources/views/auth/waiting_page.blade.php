@extends('layouts.app')

@section('content')
    <div class="main-wrapper">
        <div class="waiting-box">
            <h1>مرحبًا! انتظر موافقة المشرف</h1>
            <h3><i class="fa fa-clock-o"></i> يُرجى الانتظار لموافقة المشرف</h3>
            <p>تتم معالجة طلب التسجيل الخاص بك وقد تم إرساله للمشرف للمراجعة. يرجى الانتظار حتى يتم الموافقة عليه للوصول إلى النظام.</p>
            <p>شكرًا لك على صبرك!</p>
            <a href="{{ route('login') }}" class="btn btn-custom">تسجيل الدخول</a>
        </div>
    </div>
@endsection
