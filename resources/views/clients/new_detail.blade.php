@extends('layouts.clients.index')
@section('title')
{{ ($new->meta_title != "")?$new->meta_title:$new->title }}
@endsection
@section('seo')
<meta name="keywords" content="{{ ($new->meta_keyword != "")?$new->meta_keyword:$new->title }}">
<meta name="description" content="{{ ($new->meta_description != "")?$new->meta_description:$new->title }}">
<meta property="og:title" content="{{ ($new->meta_title != "")?$new->meta_title:$new->title }}" />



<meta property="og:image" content="{{ ($new->thumbnail != "")?$new->thumbnail:Helper::getSettingJson('default-thumbnail')}}" />
@endsection
@section('content')

<div class="breadcrumb-game">
    <div class="breadcrumb-title">{{ isset((Helper::getSettingJson('custom_language')->new->news->{$lan->code}))?Helper::getSettingJson('custom_language')->new->news->{$lan->code}:"TIN TỨC"}}</div>
</div>
{{-- <div class="title-all-game">Tin Tức</div> --}}
<div class="new-detail">
    <div class="col-content">
        <div class="task">
            <a href="javascript:void(0)" class="task-item task-share-fb">
                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2629 8.05247H11.5659V6.19521C11.5659 5.49772 12.0062 5.3351 12.3163 5.3351C12.6257 5.3351 14.2195 5.3351 14.2195 5.3351V2.2688L11.5984 2.25806C8.68866 2.25806 8.0265 4.54501 8.0265 6.00852V8.05247H6.34375V11.2121H8.0265C8.0265 15.2671 8.0265 20.1529 8.0265 20.1529H11.5659C11.5659 20.1529 11.5659 15.2189 11.5659 11.2121H13.9542L14.2629 8.05247Z" fill="#404040" />
                </svg>
            </a>
            <a href="javascript:void(0)" class="task-item back-to-top">
                <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.28242 11.6875L3.5625 11.0002L9.5 5.3125L15.4375 11.0002L14.7213 11.6875L9.5 6.69043L4.28242 11.6875Z" fill="black"/>
                </svg>
            </a>
        </div>
        <div class="content">
            <div class="post-title">{{ $new->getInfoLanguage($lan->id)->title }}</div>
            <div class="post-time">{{ date('d-m-Y',strtotime($new->created_at)) }}</div>
            <div class="post-content">
                {!! $new->getInfoLanguage($lan->id)->content !!}
            </div>
        </div>
    </div>
    <div class="sidebar">
        <div class="title">GAME mới</div>
        @if(!empty($games))
        @foreach($games as $game)
        <div class="box-game">
            <div class="game-image">
                <img src="{{ $game->icon }}" alt="{{ $game->getInfoLanguage($lan->id)->name }}">
            </div>
            <div class="game-info">
                <div class="game-name">{{ $game->getInfoLanguage($lan->id)->name }}</div>
                <div class="game-name">{{ $game->categories()->first()->name }}</div>
                <div class="total-play">{{ $game->total_play }}</div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>


@endsection