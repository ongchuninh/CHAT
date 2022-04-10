<!-- BEGIN OF LOAD KCL M -->
<ul class="news_tab news_tab2">
    <li class="on" data-ps="0">Hoạt Động</li>
    <li data-ps="1">Nhân Vật</li>
    <li data-ps="2">Nhiệm Vụ</li>
</ul>

<div class="news_list_cont news_list_cont2" style="display:block;">
    <ul class="news_list">
        @foreach ($hoatdong as $k=>$vl)
            <li>
                <a href="{{asset('/').( $vl->slug == '' ? Helper::create_slug($vl->title) : $vl->slug ).'-'.$vl->id.'.html' }}" title='{{$vl->title}}' target="_blank">
                    {{Helper::CutText($vl->title,50)}}
                </a>
                {{date( 'd/m',strtotime($vl->created) )}}
            </li>
        @endforeach
    </ul>
    <a class="getmore" href="{{asset('tin-tuc.html')}}"></a>
</div>

<div class="news_list_cont news_list_cont2">
    <ul class="news_list">
        @foreach ($nhanvat as $vl)
            <li>
                <a href="{{asset('/').( $vl->slug == '' ? Helper::create_slug($vl->title) : $vl->slug ).'-'.$vl->id.'.html' }}" title='{{$vl->title}}' target="_blank">
                    {{Helper::CutText($vl->title,50)}}
                </a>
                {{date( 'd/m',strtotime($vl->created) )}}
            </li>
        @endforeach
    </ul>
    <a class="getmore" href="{{asset('su-kien.html')}}"></a>
</div>

<div class="news_list_cont news_list_cont2">
    @if(1)
    <ul class="news_list">
        @foreach ($nhiemvu as $vl)
                <li>
                <a href="{{asset('/').( $vl->slug == '' ? Helper::create_slug($vl->title) : $vl->slug ).'-'.$vl->id.'.html' }}" title='{{$vl->title}}' target="_blank">
                    {{Helper::CutText($vl->title,50)}}
                </a>
                {{date( 'd/m',strtotime($vl->created) )}}
            </li>
        @endforeach
    </ul>
    <a class="getmore" href="{{asset('cam-nang.html')}}"></a>
    @endif
</div>
<!-- END OF LOAD CONTENT M -->