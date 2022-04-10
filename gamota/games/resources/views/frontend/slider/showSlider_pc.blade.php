<ul>
   @if (count($slider))
       @foreach ($slider as $item)
           <li>
               <a href="{{$item->link}}" target="{{$item->target}}" title="{{$item->title}}">
               <img src="{{$item->thumbnail}}" alt="{{$item->title}}" onerror="this.src='{{asset('')}}assets/frontend/home/img/defautSilde.jpg'">
               </a>
            </li>
       @endforeach
   @else
        <li><a href="#" target="_blank"><img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt=""></a></li>
        <li><a href="#" target="_blank"><img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt=""></a></li>
        <li><a href="#" target="_blank"><img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt=""></a></li>
        <li><a href="#" target="_blank"><img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt=""></a></li>
        <li><a href="#" target="_blank"><img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt=""></a></li>
        <li><a href="#" target="_blank"><img src="{{asset('')}}assets/frontend/home/img/defautSilde.jpg" alt=""></a></li>
    @endif
</ul>