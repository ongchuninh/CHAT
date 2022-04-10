@extends('layouts.clients.index')
@section('title')
{{ isset((Helper::getSettingJson('custom_games')->title_seo))?Helper::getSettingJson('custom_games')->title_seo:'Games'}}
@endsection
@section('seo')
<meta name="keywords" content="{{ isset((Helper::getSettingJson('custom_games')->keyword_seo))?Helper::getSettingJson('custom_games')->keyword_seo:""}}">
<meta name="description" content="{{ isset((Helper::getSettingJson('custom_games')->description_seo))?Helper::getSettingJson('custom_games')->description_seo:""}}">
<meta property="og:title" content="{{ isset((Helper::getSettingJson('custom_games')->title_seo))?Helper::getSettingJson('custom_games')->title_seo:""}}" />

<meta property="og:description" content="{{ isset((Helper::getSettingJson('custom_games')->description_seo))?Helper::getSettingJson('custom_games')->description_seo:""}}" />
<meta property="og:image" content="{{ Helper::getSettingJson('default-thumbnail') }}" />

@endsection
@section('content')
<div class="breadcrumb-game">
    <div class="breadcrumb-title">Game</div>
</div>
<div class="title-all-game">Game</div>
<div class="list-all-game">
    @if(!empty($games))
        @foreach ($games as $key => $game)
        <div class="item-game">
            <div class="bg-game" style="background-image: url({{ $game->thumbnail }});"></div>
            <div class="visible-content">
                <div class="info-game">
                    {{ $game->getInfoLanguage($lan->id)->description }}
                </div>
                <div class="name"> {{ $game->getInfoLanguage($lan->id)->name }}</div>
            </div>
            <div class="hidden-content">
                <div class="icon-game">
                    <img src="{{ $game->icon }}" alt="game-name" />
                </div>
                <div class="qr-game">
                    <img src="{{ $game->qr_code }}" alt="game-name" />
                </div>
            </div>
            <a href="{{ $game->link }}" class="btn-home">{{ isset((Helper::getSettingJson('custom_language')->slide->home->{$lan->code}))
                ?Helper::getSettingJson('custom_language')->slide->home->{$lan->code}
                :Helper::getSettingJson('custom_language')->slide->home->vi }}</a>
        </div>
        @endforeach
    @endif
    
    

</div>
@endsection