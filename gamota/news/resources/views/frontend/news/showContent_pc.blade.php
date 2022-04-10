<!-- Start of content PC -->
<div class="bd">
    <div class="box pr">
        <ul>
            @foreach ($tintuc as $vl)
            <li>
                <span class="time fr">{{date( 'd/m',strtotime($vl->created) )}}</span>
                <a href="{{asset('/').($vl->slug == '' ? str_slug($vl->title) : $vl->slug).'-'.$vl->id.'.html' }}" target='_blank' title='{{$vl->title}}'>{{Helper::CutText($vl->title,50)}}</a>
            </li>
            @endforeach
        </ul>
        <a href="{{asset('tin-tuc.html')}}" class="more pa" target="_blank"></a>
    </div>
    <div class="box pr">
        <ul>
            @foreach ($sukien as $vl)
            <li>
                <span class="time fr">{{date( 'd/m',strtotime($vl->created) )}}</span>
                <a href="{{asset('/').($vl->slug == '' ? str_slug($vl->title) : $vl->slug).'-'.$vl->id.'.html' }}" target='_blank' title='{{$vl->title}}'>{{Helper::CutText($vl->title,50)}}</a>
            </li>
            @endforeach
        </ul>
        <a href="{{asset('su-kien.html')}}" class="more pa" target="_blank"></a>
    </div>
    <div class="box pr">
        <ul>
            @foreach ($camnang as $vl)
            <li>
                <span class="time fr">{{date( 'd/m',strtotime($vl->created) )}}</span>
                <a href="{{asset('/').($vl->slug == '' ? str_slug($vl->title) : $vl->slug).'-'.$vl->id.'.html' }}" target='_blank' title='{{$vl->title}}'>{{Helper::CutText($vl->title,50)}}</a>
            </li>
            @endforeach
        </ul>
        <a href="{{asset('cam-nang.html')}}" class="more pa" target="_blank"></a>
    </div>
</div>
<!-- End of content PC -->