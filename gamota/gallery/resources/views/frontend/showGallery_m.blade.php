<ul class="media_tab">
    <li class="tab_m">Hình Game</li>
    <li><img src="{{ asset('assets/frontend/home/mb/img/tab_wl_line.png')}}" /></li>
    <li class="tab_m">Clip Game</li>
    <li><img src="{{ asset('assets/frontend/home/mb/img/tab_wl_line.png')}}" /></li>
    <li class="tab_m on">Hình Vui Của Người Chơi</li>
</ul>
<div class="media_wrap">
    <div class="media_cont">
        <a class="media_more" href="{{ asset('thu-vien.html')}}">more+</a>
        <ul>
            @foreach($hinhgame as $vl)
            <li>
                <a href="{{$vl->thumbnail}}" class='img_gallery' rel='fancybox'>
                    <img class="list_img" src='{{$vl->thumbnail}}' alt="" onerror="this.src='<?= asset('') ?>assets/frontend/home/img/df_img_game.jpg'" />
                </a>
                <p>{{$vl->title}}</p>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="media_cont">
        <a class="media_more" href="<?= asset('') ?>thu-vien.html">more+</a>
        <ul>
            @foreach ($clipgame as $vl)
            @php
            $img_thumbnail = ($vl->thumbnail != '' ? asset('') . $vl->thumbnail : 'https://i3.ytimg.com/vi/' . $vl->youtube_id . '/hqdefault.jpg');
            @endphp
            <li>
                <a class="fancybox_video .iframe" data-toggle="modal" data-target="#videoModal" data-src="https://www.youtube.com/embed/<?= $vl->youtube_id ?>?autoplay=1" href="javascript:void(0)">
                    <span class="icon_play"></span>
                    <img class="list_img" src='<?= $img_thumbnail ?>' alt="" onerror="this.src='<?= asset('') ?>assets/frontend/home/img/CLIP_df.jpg'" />
                </a>
                <p><?= $vl->title ?></p>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="media_cont" style="display:block;">
        <a class="media_more" href="<?= asset('') ?>thu-vien.html">more+</a>
        <ul>
            @foreach($hinhvui as $vl)
            <li>
                <a href="{{$vl->thumbnail}}" class='img_gallery' rel='fancybox'>
                    <img class="list_img" src='{{$vl->thumbnail}}' alt="" onerror="this.src='<?= asset('') ?>assets/frontend/home/img/df_img_game.jpg'" />
                </a>
                <p>{{$vl->title}}</p>
            </li>
            @endforeach

        </ul>
    </div>
</div>