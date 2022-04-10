<!-- BEGIN OF LOAD CONTENT M -->
<ul class="news_tab news_tab1">
    <li class="on" data-ps="0"><a href="javascript:;">Tin Tức</a></li>
    <li data-ps="1"><a href="javascript:;">Sự Kiện</a></li>
    <li data-ps="2"><a href="javascript:;">Cẩm Nang</a></li>
</ul>

<div class="news_list_cont news_list_cont1" style="display:block;">
    <ul class="news_list">
        @foreach ($tintuc as $vl)
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

<div class="news_list_cont news_list_cont1">
    <ul class="news_list">
        @foreach ($sukien as $vl)
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

<div class="news_list_cont news_list_cont1">
    <ul class="news_list">
        @foreach ($camnang as $vl)
                <li>
                <a href="{{asset('/').( $vl->slug == '' ? Helper::create_slug($vl->title) : $vl->slug ).'-'.$vl->id.'.html' }}" title='{{$vl->title}}' target="_blank">
                    {{Helper::CutText($vl->title,50)}}
                </a>
                {{date( 'd/m',strtotime($vl->created) )}}
            </li>
        @endforeach
    </ul>
    <a class="getmore" href="{{asset('cam-nang.html')}}"></a>
</div>
<!-- END OF LOAD CONTENT M -->