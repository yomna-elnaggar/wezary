@extends('layouts.app')
@section('content')
    <div class="main-wrapper">	
        <div class="error-box">
            <h1>404</h1>
            <h3><i class="fa fa-warning"></i> أُووبس! الصفحة غير موجودة!</h3>
            <p>الصفحة المطلوبة لم يتم العثور على</p>
            <a href="{{ route('home') }}" class="btn btn-custom">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>
@endsection