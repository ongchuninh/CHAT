<header>
    
    <div class="wrap">
        <div class="logo">
            <a href="{{ route('client.home') }}" ><img src="/clients/images/logo-gamota.png" alt="gamota" /></a>
        </div>
        <div class="wrap-language">
            <select id="list-language">
                @if(!empty($languages))
                @foreach($languages as $val)
                    <option @if($val->code == $lan->code){{ 'selected' }}@endif value="{{ $val->code }}">{{ $val->name }}</option>
                @endforeach
                @endif
                
            </select>
        </div>
        <div class="wrap-menu">
            <ul class="main-menu">
                <li>
                    <a href="{{ route('client.home')  }}">{{ trans('home.menu.home') }}</a>
                </li>
                <li>
                    <a href="{{ route('client.gamota')  }}">{{ trans('home.menu.gamota') }}</a>
                </li>
                <li>
                    <a href="{{ route('client.service')  }}">{{ trans('home.menu.service') }}</a>
                </li>
                <li>
                    <a href="{{ route('client.games')  }}">{{ trans('home.menu.product') }}</a>
                </li>
                <li>
                    <a href="{{ route('client.listNews')  }}">{{ trans('home.menu.new') }}</a>
                </li>
                <li>
                    <a href="{{ route('client.contact')  }}">{{ trans('home.menu.contact') }}</a>
                </li>
            </ul>
        </div>
        <div class="wrap-social">
            <a href="https://www.facebook.com/nph.gamota" class="btn-social btn-fb" target="_blank"></a>
            <a href="https://www.linkedin.com/company-beta/2828028/" class="btn-social btn-in" target="_blank"></a>
        </div>
        <a href="javascript:void(0)" class="btn-menu-mob">
          <span class="burger-lines"></span>
        </a>
    </div>
</header>