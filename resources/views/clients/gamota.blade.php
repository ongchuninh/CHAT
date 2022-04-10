@extends('layouts.clients.index')
@section('title')
{{ isset((Helper::getSettingJson('custom_gamota')->title_seo))?Helper::getSettingJson('custom_gamota')->title_seo:'Gamota'}}
@endsection
@section('seo')
<meta name="keywords" content="{{ isset((Helper::getSettingJson('custom_gamota')->keyword_seo))?Helper::getSettingJson('custom_gamota')->keyword_seo:""}}">
<meta name="description" content="{{ isset((Helper::getSettingJson('custom_gamota')->description_seo))?Helper::getSettingJson('custom_gamota')->description_seo:""}}">
<meta property="og:title" content="{{ isset((Helper::getSettingJson('custom_gamota')->title_seo))?Helper::getSettingJson('custom_gamota')->title_seo:""}}" />

<meta property="og:description" content="{{ isset((Helper::getSettingJson('custom_gamota')->description_seo))?Helper::getSettingJson('custom_gamota')->description_seo:""}}" />
<meta property="og:image" content="{{ Helper::getSettingJson('default-thumbnail') }}" />

@endsection
@section('content')
<div class="gamota">
    <img src="clients/images/gamota.png" alt="gamota" />
</div>
<div class="wrap-text">
    <div class="title"><div class="title">{{ isset((Helper::getSettingJson('custom_language')->gamota->title->{$lan->code}))
        ?Helper::getSettingJson('custom_language')->gamota->title->{$lan->code}
        :Helper::getSettingJson('custom_language')->gamota->title->vi }}</div></div>
    <div class="des">{{ isset($custom_gamota->text_content->content->{$lan->code})?$custom_gamota->text_content->content->{$lan->code}:"" }}</div>
</div>
<div class="wrap-timeline">
    <div class="timeline">
        <ul>
            @if (!empty($custom_gamota->timeline->image))
                @foreach ($custom_gamota->timeline->image as $key => $value)
                <li>
                    <div class="icon" style="background-image: url({{ $value }});"></div>
                    <div class="year">{{ $custom_gamota->timeline->year[$key] }}</div>
                    <div class="des"><div class="text">{{ $custom_gamota->timeline->content->{$lan->code}[$key] }}></div></div>
                </li>
                @endforeach
            @endif
            
          
        </ul>
    </div>
</div>
@if(!empty($custom_gamota->about->image))
    @foreach($custom_gamota->about->image as $key => $value)
        @if($key % 2 == 0)
        <div class="wrap-puslish">
            <div class="left" style="background: url({{ $value }})">
                <div class="title">{{ $custom_gamota->about->title->{$lan->code}[$key] }}</div>
            </div>
            <div class="right">
                <blockquote>{!! $custom_gamota->about->content->{$lan->code}[$key] !!}</blockquote>
                <div class="text">Contact Information<br>bd@gamota.com</div>
            </div>
        </div>
        @else
        <div class="wrap-co-puslish">
            <div class="left">
                <blockquote>{!! $custom_gamota->about->content->{$lan->code}[$key] !!}</blockquote>
                <div class="text">Contact Information<br>bd@gamota.com</div>
            </div>
            <div class="right" style="background: url({{ $value }})" >
                <div class="title">{{ $custom_gamota->about->title->{$lan->code}[$key] }}</div>
            </div>
        </div>
        @endif
    @endforeach
@endif
@endsection