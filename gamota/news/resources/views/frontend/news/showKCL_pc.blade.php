<div class="hd">
    <ul class="cl">
        <li class="on" data-ps="0"><a href="javascript:;">Hoạt Động</a></li>
        <li data-ps="1"><a href="javascript:;">Nhân Vật</a></li>
        <li data-ps="2"><a href="javascript:;">Nhiệm Vụ</a></li>
    </ul>
</div>
<div class="bd">
    <div class="box pr active">
        <ul>
            @foreach ($hoatdong as $vl)
            <li>
                <span class="time fr">{{date( 'd/m',strtotime($vl->created) )}}</span>
                <a href="{{asset('/').( $vl->slug == '' ? Helper::create_slug($vl->title) : $vl->slug ).'-'.$vl->id.'.html' }}" target='_blank' title='{{$vl->title}}'>{{Helper::CutText($vl->title,50)}}</a>
            </li>
            @endforeach
        </ul>
        <a href="<?= asset('phu-ban.html') ?>" class="more pa" target="_blank"></a>
    </div>
    <div class="box pr">
        <ul>
            @foreach ($nhanvat as $vl)
            <li>
                <span class="time fr">{{date( 'd/m',strtotime($vl->created) )}}</span>
                <a href="{{asset('/').( $vl->slug == '' ? Helper::create_slug($vl->title) : $vl->slug ).'-'.$vl->id.'.html' }}" target='_blank' title='{{$vl->title}}'>{{Helper::CutText($vl->title,50)}}</a>
            </li>
            @endforeach
        </ul>
        <a href="<?= asset('nhan-vat.html') ?>" class="more pa" target="_blank"></a>
    </div>
    <?php if (1) { ?>
        <div class="box pr">
            <ul>
                @foreach ($nhiemvu as $vl)
                <li>
                    <span class="time fr">{{date( 'd/m',strtotime($vl->created) )}}</span>
                    <a href="{{asset('/').( $vl->slug == '' ? Helper::create_slug($vl->title) : $vl->slug ).'-'.$vl->id.'.html' }}" target='_blank' title='{{$vl->title}}'>{{Helper::CutText($vl->title,50)}}</a>
                </li>
                @endforeach
            </ul>
            <a href="<?= asset('nhiem-vu.html') ?>" class="more pa" target="_blank"></a>
        </div>
    <?php } ?>
</div>