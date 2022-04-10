@extends('Cms::layouts.default',[
    
    'active_admin_menu' 	=> ['games', isset($game->id) ? 'games.index' : 'games.create'],
    'breadcrumbs'           => [
        'title' => ["Game", !isset($game->id) ? trans('cms.add-new') : trans('cms.edit')],
        'url'   => [
            route('admin.game.index'),
        ],
    ],
])

@section('page_title', isset($game->id) ? 'Chỉnh sửa game' : 'Thêm mới game')
@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/admin/global/css/n-custom.css" />
@endpush


@if(isset($game_id))
    @section('page_sub_title', $game->name)
    @section('tool_bar')
        <a href="{{ route('admin.game.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> <span class="hidden-xs">Thêm mới game</span>
        </a>
    @endsection
@endif

@section('content')
    
    {!! Form::ajax(['url' => isset($game->id) ? route('admin.game.update', ['id' => $game->id])  : route('admin.game.store'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($game->id) ? 'PUT' : 'POST']) !!}
        <div class="form-body">
           

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Thể loại game <span class="required">*</span>
                </label>
                <div class="col-sm-8">
                    <select class="form-control" name="game[category_id]">
                        @foreach($gameCate as $cate)
                            @if($game->id)
                            @foreach($game->categories as $val)
                            <option
                                {{ ($val->id == $cate->id)? 'selected' : ''  }}
                                value="{{ $cate->id }}">{{ $cate->name }}</option>
                            @endforeach
                            @else
                            <option
                                
                                value="{{ $cate->id }}">{{ $cate->name }}</option>
                            @endif
                            
                        @endforeach
                    </select>
                </div>
            </div>  

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Ảnh đại diện <span class="required">*</span>
                </label>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-box" style="position: relative;width: 100%;">
                                <input id="thumbnail" type="text" name="game[thumbnail]" class="form-control"
                                        value="{{ (isset($game->thumbnail))?$game->thumbnail:'' }}"
                                        readonly="" placeholder="Đường dẫn ảnh"
                                        style="position: relative;width: 100%;">

                                <button type="button" class="btn btn-success btn-add"
                                        style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" id="avatar">
                            @if (isset($game->thumbnail))
                                <img src="{{ $game->thumbnail }}" class="imgProduct img-thumbnail" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Ảnh đại diện LG <span class="required">*</span>
                </label>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-box" style="position: relative;width: 100%;">
                                <input id="thumbnail" type="text" name="game[thumbnail_lg]" class="form-control"
                                        value="{{ (isset($game->thumbnail_lg))?$game->thumbnail_lg:'' }}"
                                        readonly="" placeholder="Đường dẫn ảnh"
                                        style="position: relative;width: 100%;">

                                <button type="button" class="btn btn-success btn-add"
                                        style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" id="avatar">
                            @if (isset($game->thumbnail_lg))
                                <img src="{{ $game->thumbnail_lg }}" class="imgProduct img-thumbnail" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Icon game <span class="required">*</span>
                </label>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-box" style="position: relative;width: 100%;">
                                <input id="thumbnail" type="text" name="game[icon]" class="form-control"
                                        value="{{ (isset($game->icon))?$game->icon:'' }}"
                                        readonly="" placeholder="Đường dẫn ảnh"
                                        style="position: relative;width: 100%;">

                                <button type="button" class="btn btn-success btn-add"
                                        style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" id="avatar">
                            @if (isset($game->icon))
                                <img src="{{ $game->icon }}" class="imgProduct img-thumbnail" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    QR Code
                </label>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-box" style="position: relative;width: 100%;">
                                <input id="thumbnail" type="text" name="game[qr_code]" class="form-control"
                                        value="{{ (isset($game->qr_code))?$game->qr_code:'' }}"
                                        readonly="" placeholder="Đường dẫn ảnh"
                                        style="position: relative;width: 100%;">

                                <button type="button" class="btn btn-success btn-add"
                                        style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" id="avatar">
                            @if (isset($game->qr_code))
                                <img src="{{ $game->qr_code }}" class="imgProduct img-thumbnail" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Game ID <span class="required">*</span>
                </label>
                <div class="col-sm-8">
                    <input type="text" value="{{ isset($game->game_id)?$game->game_id:'' }}" name="game[game_id]" class="form-control">
                </div>
            </div>
            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                   Link game
                </label>
                <div class="col-sm-8">
                    <input type="text"  value="{{ isset($game->link)?$game->link:'' }}"  class="form-control" name="game[link]">
                </div>
            </div>
            
            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                   GMA ID
                </label>
                <div class="col-sm-8">
                    <input type="text"  value="{{ isset($game->gma_id)?$game->gma_id:'' }}"  class="form-control" name="game[gma_id]">
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                   Facebook Page Id
                </label>
                <div class="col-sm-8">
                    <input type="text"  value="{{ isset($game->fb_page_id)?$game->fb_page_id:'' }}" class="form-control" name="game[fb_page_id]">
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    API Key
                </label>
                <div class="col-sm-8">
                    <input type="text" value="{{ isset($game->api_key)?$game->api_key:'' }}"  class="form-control" name="game[api_key]">
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                   Số lượng người chơi
                </label>
                <div class="col-sm-8">
                    <input type="number"  value="{{ isset($game->total_play)?$game->total_play:'' }}" class="form-control" name="game[total_play]">
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Hiển thị trang chủ <span class="required">*</span>
                </label>
                <div class="col-sm-8">
                    <select class="form-control" name="game[display]">
                        <option @if (isset($game->display))
                            {{ ($game->display == 1)? 'selected' : ''  }}
                        @endif  value="1">Hiển thị</option>
                        <option @if (isset($game->status))
                            {{ ($game->display == 0)? 'selected' : ''  }}
                        @endif  value="0">Không hiển thị</option>
                    </select>
                </div>
            </div>

           
            {{-- <div class="form-group media-box-group">
                <label class="control-label col-sm-2 pull-left">
                    Trạng thái <span class="required">*</span>
                </label>
                <div class="col-sm-8">
                    <select class="form-control" name="game[status]">
                        <option @if (isset($game->status))
                            {{ ($game->status == 1)? 'selected' : ''  }}
                        @endif  value="1">Active</option>
                        <option @if (isset($game->status))
                            {{ ($game->status == 0)? 'selected' : ''  }}
                        @endif  value="0">InActive</option>
                    </select>
                </div>
            </div> --}}
            <div class="form-group">
                <label class="control-label col-sm-2">
                    Trạng thái <span class="required">*</span>
                </label>
                <div class="col-sm-10">
                    {!! Form::select('game[status]', $game->statusable()->mapWithKeys(function ($item) {
                        return [$item['slug'] => $item['name']];
                    })->all(), $game->status_slug, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
                </div>
            </div>

            <hr>
            <h4>Thêm thông tin cho các ngôn ngữ</h4>
            <div class="form-group media-box-group">
                <div class="col-sm-10">
                    <figure class="tabBlock">
                        <ul class="tabBlock-tabs">
                            @foreach($languages as $key => $value)
                            <li class="tabBlock-tab {{ ($key == 0)?'is-active':'' }}">{{ $value->name }}</li>
                            @endforeach
                        </ul>
                        <div class="tabBlock-content">
                            @foreach($languages as $key => $value)
                            <div class="tabBlock-pane">
                                <div class="form-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Tên game <span class="required">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input value="{{ isset($game->id)? $game->getInfoLanguage($value->id)->name :'' }}" name="game[name][{{ $value->code }}]" type="text" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Mô tả
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea name="game[description][{{ $value->code }}]" class="form-control" cols="30" rows="10">{{ isset($game->id)? $game->getInfoLanguage($value->id)->description :'' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </figure>
                </div>
            </div>

            
        </div>
        <div class="form-actions util-btn-margin-bottom-5">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    @if(! isset($category_id))
                        {!! Form::btnSaveNew() !!}
                    @else
                        {!! Form::btnSaveOut() !!}
                    @endif
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@push('js_footer')
   
    <script src="/assets/ckeditor/ckeditor.js"></script>
    <script src="/assets/ckfinder/ckfinder.js"></script>
    <script src="/assets/admin/global/scripts/n-custom.js"></script>
    <script>
        $('document').ready(function(){
            $('body').on('click','.btn-add',function(){
                var t = $(this);
                CKFinder.popup( {
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function( finder ) {
                        finder.on( 'files:choose', function( evt ) {
                            var file = evt.data.files.first();

                            t.parent().find('#thumbnail').eq(0).val(file.getUrl());

                            t.closest('.row').find('#avatar').eq(0).html("<img src='" + file.getUrl() + "' class='imgProduct img-thumbnail' width='200'/>");

                        } );
                    }
                } );

            });

            

            

            
        });
    </script>
    <script type="text/javascript">
        $('#create-slug').click(function() {
            if(this.checked) {
                var title = $('input[name="game[title]"]').val();
                var slug = strSlug(title);
                $('input[name="game[slug]"]').val(slug);
            }
        });

        $('input[name="game[title]"]').keyup(function() {
            if ($('#create-slug').is(':checked')) {
                var title = $(this).val();
                var slug = strSlug(title);
                $('input[name="game[slug]"]').val(slug);    
            }
        });
        
    </script>
@endpush
