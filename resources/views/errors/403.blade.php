@extends('layouts.app')
@section('content')
    <div class="main-wrapper">
        <div class="error-box">
            <h1>403</h1>
            <h3><i class="fa fa-warning"></i> أُووبس! هناك خطأ ما</h3>
            <p>إجراء غير مصرح به</p>
            <a href="{{route('home')}}" class="btn btn-custom">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>
@endsection
