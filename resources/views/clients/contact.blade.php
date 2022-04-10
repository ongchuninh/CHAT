@extends('layouts.clients.index')
@section('title')
{{ isset( Helper::getSettingJson('custom_contact')->title_seo ) ? Helper::getSettingJson('custom_contact')->title_seo : 'Liên Hệ'}}
@endsection
{{-- Helper::getSettingJson('custom_contact')->title_seo --}}
@section('seo')
<meta name="keywords" content="{{ isset((Helper::getSettingJson('custom_contact')->keyword_seo))?Helper::getSettingJson('custom_contact')->keyword_seo:""}}">
<meta name="description" content="{{ isset((Helper::getSettingJson('custom_contact')->description_seo))?Helper::getSettingJson('custom_contact')->description_seo:""}}">
<meta property="og:title" content="{{ isset((Helper::getSettingJson('custom_contact')->title_seo))?Helper::getSettingJson('custom_contact')->title_seo:""}}" />

<meta property="og:description" content="{{ isset((Helper::getSettingJson('custom_contact')->description_seo))?Helper::getSettingJson('custom_contact')->description_seo:""}}" />
<meta property="og:image" content="{{ Helper::getSettingJson('default-thumbnail') }}" />

@endsection
@section('css')
    <style>
        .errors-validate{
            font-size: 13px;
        }
        .parsley-error{
            border: 1px solid red!important;
        }
    </style>   
@endsection
@section('content')
<div class="breadcrumb-game">
    <div class="breadcrumb-title">{{ isset((Helper::getSettingJson('custom_language')->text->contact->{$lan->code}))
        ?Helper::getSettingJson('custom_language')->text->contact->{$lan->code}
        :Helper::getSettingJson('custom_language')->text->contact->vi }}</div>
</div>
<div class="wrap-contact-page">
    <div class="left">
        <div class="contact-info">
            <div class="title-contact">{{ isset((Helper::getSettingJson('custom_language')->contact->title->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->contact->title->{$lan->code}
                :Helper::getSettingJson('custom_language')->contact->title->vi }}</div>
            <div class="des-contact">{{ isset((Helper::getSettingJson('custom_language')->contact->question->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->contact->question->{$lan->code}
                :Helper::getSettingJson('custom_language')->contact->question->vi }}</div>
        </div>
        <div class="address">
            <div class="title-address">Head Offfice</div>
            <div class="address-info"><span>{{ isset((Helper::getSettingJson('custom_language')->location->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->location->{$lan->code}
                :Helper::getSettingJson('custom_language')->location->vi }}</span></div>
            <div class="phone-info">1900 6855</div>
        </div>
        <div class="contact-bd">
            <div class="title-bd">{{ isset((Helper::getSettingJson('custom_general')->admin_email_title[0]))
                ?Helper::getSettingJson('custom_general')->admin_email_title[0] : '' }}</div>
            <div class="bd-mail">{{ isset((Helper::getSettingJson('custom_general')->admin_email[0]))
                ?Helper::getSettingJson('custom_general')->admin_email[0] : '' }}</div>
            <a href="mailto:{{ isset((Helper::getSettingJson('custom_general')->admin_email[0]))
                ?Helper::getSettingJson('custom_general')->admin_email[0] : '' }}" target="_blank" class="contact-now">{{ isset((Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}
                :Helper::getSettingJson('custom_language')->btn->contact->vi }}</a>
        </div>
       
        
    </div>
    <div class="right">
        <div class="contact-form">
            <form action="" method="post" id="contactForm">
                @csrf
                <div class="wrap-row">
                    <div class="form-50">
                        <label for="name">Name*</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="form-50">
                        <label for="email">Email*</label>
                        <input type="email" id="email" name="email">
                    </div>
                </div>
                <div class="wrap-row">
                    <div class="form-100">
                        <label for="subject">Subject*</label>
                        <input type="text" id="subject" name="subject">
                    </div>
                </div>
                <div class="wrap-row">
                    <div class="form-100">
                        <label for="message">Message</label>
                        <textarea rows="6" name="message" ></textarea>
                    </div>
                </div>
                <div class="wrap-row">
                    <button type="submit" id="submit-form" class="send-now">{{ isset((Helper::getSettingJson('custom_language')->btn->send_now->{$lan->code}))
                        ?Helper::getSettingJson('custom_language')->btn->send_now->{$lan->code}
                        :Helper::getSettingJson('custom_language')->btn->send_now->vi }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="/assets/js/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            var add_errs = function (list_err = []) {
                let list = ``;
                list_err.forEach(noti => {
                    list += `<span class = "errors-validate" style = "color: red;">${noti}</span>`;
                });
                //return `<ul class="parsley-errors-list filled" id="parsley-id-9">${list}</ul>`;
                return list;
            };
            $('#contactForm').submit(function(e){
                e.preventDefault();
               
                $("#submit-form").attr("disabled","disabled");

                
               
                $('.errors-validate').remove();
                $('.parsley-error').removeClass('parsley-error');
                let formData = new FormData($(this)[0]),
                token = '{{ csrf_token() }}';
                formData.set('_token', token);
               
                $.ajax({
                    url: '{{ route('api.contact') }}',
                    method: 'post',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(res)
                    {
                        $("#submit-form").removeAttr("disabled");
                        let msg = res.msg;
                        if (res.errors){
                            if (msg.hasOwnProperty('name')){
                                $('#name').addClass('parsley-error');
                                $('#name').after(add_errs(msg.name))
                            }
                            if(msg.hasOwnProperty('email')){
                                $('#email').addClass('parsley-error');
                                $('#email').after(add_errs(msg.email))
                            }
                            if(msg.hasOwnProperty('subject')){
                                $('#subject').addClass('parsley-error');
                                $('#subject').after(add_errs(msg.subject))
                            }
                        
                            
                        }else{
                            swal({
                                title: 'Thông báo !',
                                icon: 'success',
                                text: 'Gửi yêu cầu thành công',
                                closeOnClickOutside: false,
                                }).then(()=>{
                                    window.location.href = window.location.origin;
                                });
                           
                        }
                    }
                })
            })
        })
    </script>
@endsection