<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تحقق من عنوان بريدك الإلكتروني</div>
                  <div class="card-body">
                   @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                           {{ __('تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني.') }}
                       </div>
                   @endif
                   <a href="{{ url('/reset-password/'.$token) }}">اضغط هنا</a>
               </div>
           </div>
       </div>
   </div>
</div>
