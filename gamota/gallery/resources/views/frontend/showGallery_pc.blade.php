<div class="hd">
    <span class="more fr">
        <a href="<?= asset('thu-vien.html') ?>" target="_blank">more+</a>
        <a href="<?= asset('thu-vien.html') ?>" target="_blank">more+</a>
        <a href="<?= asset('thu-vien.html') ?>" target="_blank">more+</a>
    </span>
    <ul>
        <li><span>Hình Game</span></li>
        <li><span>Clip Game</span></li>
        <li class="on"><span>Hình Vui Của Người Chơi</span></li>
    </ul>
</div>
<div class="bd slideInUp">
    <div class="video-box">
        <!-- Hinh Game -->
        <ul class="cl">
            @foreach($hinhgame as $vl)
                <li>
                    <a href="{{$vl->thumbnail}}"class='img_gallery' rel='fancybox'>
                        <span class="cover">
                            <img src='{{$vl->thumbnail}}' alt="" />
                        </span>
                        <span class="txt">{{$vl->title}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="video-box">
        <!-- Clip Game -->
        <ul class="cl">
            @foreach ($clipgame as $vl)
            @php
            $img_thumbnail = ($vl->thumbnail != '' ? asset('') . $vl->thumbnail : 'https://i3.ytimg.com/vi/' . $vl->youtube_id . '/hqdefault.jpg');
            @endphp
             <li>
                 <a class="fancybox_video .iframe" href="https://www.youtube.com/embed/<?= $vl->youtube_id ?>?autoplay=1">
                    <span class="cover">
                        <img src={{$img_thumbnail}} alt="" />
                    </span>
                    <i></i>
                    <span class="txt">{{$vl->title}}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="video-box">
        <!-- Hinh Vui Cua Nguoi Choi -->
        <ul class="cl">
        @foreach($hinhvui as $vl)
            <li>
                <a href="{{$vl->thumbnail}}" class='img_gallery' rel='fancybox'>
                    <span class="cover"><img src='{{$vl->thumbnail}}' alt="" /></span>
                    <span class="txt">{{$vl->title}}</span>
                </a>
            </li>

            @endforeach
        </ul>
    </div>
</div>