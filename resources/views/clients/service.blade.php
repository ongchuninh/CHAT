@extends('layouts.clients.index')
@section('title')
{{ isset((Helper::getSettingJson('custom_service')->title_seo))?Helper::getSettingJson('custom_service')->title_seo:'Dịch Vụ'}}
@endsection
@section('seo')
<meta name="keywords" content="{{ isset((Helper::getSettingJson('custom_service')->keyword_seo))?Helper::getSettingJson('custom_service')->keyword_seo:""}}">
<meta name="description" content="{{ isset((Helper::getSettingJson('custom_service')->description_seo))?Helper::getSettingJson('custom_service')->description_seo:""}}">
<meta property="og:title" content="{{ isset((Helper::getSettingJson('custom_service')->title_seo))?Helper::getSettingJson('custom_service')->title_seo:""}}" />

<meta property="og:description" content="{{ isset((Helper::getSettingJson('custom_service')->description_seo))?Helper::getSettingJson('custom_service')->description_seo:""}}" />
<meta property="og:image" content="{{ Helper::getSettingJson('default-thumbnail') }}" />

@endsection
@section('content')
<div class="banner-service">
    <img src="{{ ($custom_service->background->image != "")?$custom_service->background->image:"clients/images/banner-service.png" }}" alt="banner" />
</div>
<div class="wrap-text-service">
    <div class="wrap-number">
        <div class="text">
            <div class="num">3</div>
            <div class="des">{{ isset((Helper::getSettingJson('custom_language')->service->nph->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->service->nph->{$lan->code}
                :'NPH lớn nhất tại Việt Nam' }}</div>
        </div>
        <div class="text">
              <div class="num">100</div>
              <div class="des">{{ isset((Helper::getSettingJson('custom_language')->service->game_release->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->service->game_release->{$lan->code}
                :'Tựa game đã phát hành' }}</div>
        </div>
        <div class="text">
            <div class="num">10</div>
            <div class="des">{{ isset((Helper::getSettingJson('custom_language')->service->feature->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->service->feature->{$lan->code}
                :'Game lên feature kho tải' }}</div>
        </div>
        <div class="text">
              <div class="num">15M</div>
              <div class="des">{{ isset((Helper::getSettingJson('custom_language')->service->user->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->service->user->{$lan->code}
                :'Người chơi' }}</div>
        </div>
    </div>
    <div class="text-service">
       
        {{ $custom_service->text_content->content->{$lan->code} }}
        
    </div>
</div>
<div class="list-service">
    @if($custom_service->about->image)
        @foreach($custom_service->about->image as $key => $value)
            @if($key % 2 == 0)
            <div class="item-service">
                <div class="left" style="background-image: url('{{ $value }}');"></div>
                <div class="right">
                    <div class="title">{{ $custom_service->about->title->{ $lan->code }[$key] }}</div>
                    <div class="des-service">
                        {!! $custom_service->about->content->{ $lan->code }[$key] !!}
                    </div>
                    <div class="contact-info">
                        <a href="/contact">{{ isset((Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}))
                            ?Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}
                            :Helper::getSettingJson('custom_language')->btn->contact->vi }}</a>
                    </div>
                </div>
            </div>
            @else
            <div class="item-service">
                <div class="left">
                    <div class="title">{{ $custom_service->about->title->{ $lan->code }[$key] }}</div>
                    <div class="des-service">
                        {!! $custom_service->about->content->{ $lan->code }[$key] !!}
                    </div>
                    <div class="contact-info">
                    <a href="/contact">{{ isset((Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}))
                        ?Helper::getSettingJson('custom_language')->btn->contact->{$lan->code}
                        :Helper::getSettingJson('custom_language')->btn->contact->vi }}</a>
                    </div>
                </div>
                <div class="right" style="background-image: url('{{ $value }}');">
                   
                </div>
            </div>
            @endif
        @endforeach
    @endif
</div>
@endsection