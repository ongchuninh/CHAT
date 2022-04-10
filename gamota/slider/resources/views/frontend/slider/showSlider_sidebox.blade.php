<!-- Start of Slider_sidebox -->
<div id="banner_detail">
    <div id='banner_news_owl' class="">
        @if (!empty($slider))
        @foreach ($slider as $item)
            <a class="item" href="{{$item->link}}" target="{{$item->target}}" title="{{$item->title}}">
                <img src="{{$item->thumbnail}}" alt="{{$item->title}}"/>
            </a>
        @endforeach
        @else
            <a class='item' href="#" target="_blank">
                <img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt="">
            </a>
            <a class='item' href="#" target="_blank">
                <img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt="">
            </a>
        @endif
    </div>
</div>
<!-- End of Slider_sidebox -->