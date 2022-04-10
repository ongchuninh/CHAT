<!-- BEGIN OF LOAD SLIDER M -->
<div class="swiper-container" id="lb_swiper">
    <div class="swiper-wrapper">    
    @if (count($slider))
       @foreach ($slider as $item)
        <div class="swiper-slide">
            <a  href="{{$item->link}}" target="{{$item->target}}" title="{{$item->title}}" >
                <img src="{{$item->thumbnail}}" alt="{{$item->title}}" onerror="this.src='{{asset('')}}assets/frontend/home/img/defautSilde.jpg'">
            </a>
        </div>
        @endforeach
    @else               
        <div class="swiper-slide">
            <a href="#">
                <img src="{{asset('assets/frontend/home/img/defautSilde.jpg')}}" alt="">
            </a>
        </div>                 
        <div class="swiper-slide">
            <a href="#">
                <img src="{{asset('assets/frontend/home/img/defautSilde.jpg')}}" alt="">
            </a>
        </div>                 
        <div class="swiper-slide">
            <a href="#">
                <img src="{{asset('assets/frontend/home/img/defautSilde.jpg')}}" alt="">
            </a>
        </div>                 
        <div class="swiper-slide">
            <a href="#">
                <img src="{{asset('assets/frontend/home/img/defautSilde.jpg')}}" alt="">
            </a>
        </div>                  
    @endif
    </div>
</div>
    <div class="swiper-pagination"></div>
<!-- END OF LOAD SLIDER M -->