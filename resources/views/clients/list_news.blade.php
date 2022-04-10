@extends('layouts.clients.index')
@section('title')
Danh sách tin tức
@endsection
@section('seo')
<meta name="keywords" content="Danh sách tin tức">
<meta name="description" content="Danh sách tin tức">
<meta property="og:title" content="Danh sách tin tức" />


<meta property="og:image" content="{{ Helper::getSettingJson('default-thumbnail') }}" />

@endsection
@section('content')
<div class="breadcrumb-game">
    <div class="breadcrumb-title">{{ isset((Helper::getSettingJson('custom_language')->new->news->{$lan->code}))?Helper::getSettingJson('custom_language')->new->news->{$lan->code}:"TIN TỨC"}}</div>
</div>
{{-- <div class="title-all-game">Tin Tức</div> --}}
<div class="list-all-news">
            @if(!empty($news))
            @foreach ($news as $key => $new)
                    <div class="item-news">
                        <div class="images-news">
                            <img src="{{ $new->thumbnail }}" alt="{{ $new->getInfoLanguage($lan->id)->title }}">
                            <div class="overlay">
                                <a href="javascript:void(0)" class="share-fb">
                                    <span>Chia sẻ</span>
                                    <img src="clients/images/ic-share-fb.svg" alt="share-fb">
                                </a>
                            </div> 
                        </div>
                        <div class="info-news">
                        <div class="title-news"><a href="{{ route('client.newDetail',['cate'=> $new->categories()->first()->name ,'slug'=>$new->slug]) }}">{{ $new->getInfoLanguage($lan->id)->title }}</a></div>
                        <div class="post-time">{{ date('d-m-Y',strtotime($new->created_at)) }}</div>
                        </div>
                    </div>
                
            @endforeach
            @endif
</div>

{{-- <div class="list-all-game">
    @if(!empty($news))
        @foreach ($news as $key => $new)
        <div class="item-game">
            <div class="bg-game" style="background-image: url({{ $new->thumbnail }});"></div>
            <div class="visible-content">
                <div class="info-game">
                    {{ $new->getInfoLanguage($lan->id)->description }}
                </div>
                <div class="name"> {{ $new->getInfoLanguage($lan->id)->title }}</div>
            </div>
           
            <a href="" class="btn-home">Trang chủ</a>
        </div>
        @endforeach
    @endif
    
    

</div> --}}
@endsection
