@extends('Cms::layouts.default',[
    'active_admin_menu'     => ['option', 'option.home'],
    'breadcrumbs'           => [
        'title' => [trans('Options::option.option'), trans('Options::option.home'), trans('cms.edit')],
        'url'   => [
            route('admin.option.home'),
        ],
    ],
])
@push('css')
    <style>
        h4{
            margin-top: 35px;
            font-weight: 500;
        }
    </style>
@endpush

@section('page_title', trans('Options::option.home'))

@section('content')
    
    {!! Form::ajax(['url' => route('admin.option.updateHome'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($links_id) ? 'PUT' : 'POST']) !!}
        <div>
            <h4>Thiết lập SEO</h4>
            <hr>
            <div class="form-group media-box-group">
                <label class="control-label col-md-2">
                    Tiêu đề seo
                </label>
                <div class="col-md-8">
                    <input type="text" name="title_seo" value="{{ isset($data->title_seo) ? $data->title_seo : '' }}" class="form-control">
                </div>
            </div>
            <div class="form-group media-box-group">
                <label class="control-label col-md-2">
                    Mô tả seo
                </label>
                <div class="col-md-8">
                    <textarea name="description_seo" class="form-control" cols="30" rows="10">{{ isset($data->description_seo) ? $data->description_seo : '' }}</textarea>
                </div>
            </div>

            <div class="form-group media-box-group">
                <label class="control-label col-md-2">
                    Từ khóa seo
                </label>
                <div class="col-md-8">
                    <textarea name="keyword_seo" class="form-control" cols="30" rows="10">{{ isset($data->keyword_seo) ? $data->keyword_seo : '' }}</textarea>
                </div>
            </div>

            
            <h4>Thiết lập Slide</h4>
            <hr>
           
            <div class="form-group" style="margin-top: 20px;">
                <label class="control-label col-md-2"> Slide <button type="button"  class="btn btn-success add-wall-slide""><i class="fa fa-plus"></i></button></label>
                
                <div class="col-md-8 list-wall-slide">
                    @if(!empty($data->home_slide))       
                
                    @foreach($data->home_slide->slide as $k => $value)
                        <div class="list-wall-slide-detail">
                            <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                                <div class="col-md-2">
                                    
                                    <button type="button" class="btn btn-danger remove-wall-slide"><i class="fa fa-times"></i></button>
                                    <button type="button" class="btn btn-success add-wall-slide"><i class="fa fa-plus"></i></button>
                                
                                </div>
                                <div class="col-md-7">
                                    <div class="input-box" style="position: relative;width: 100%;">
                                        <input id="thumbnail" type="text" name="home_slide[slide][]" class="form-control"
                                                value="{{ $value }}"
                                                readonly="" placeholder="Đường dẫn ảnh"
                                                style="position: relative;width: 100%;">

                                        <button type="button" class="btn btn-success btn-add"
                                                style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                        </button>
                                    </div>

                                </div>
                                <div class="col-md-3 text-center" id="avatar">
                                    <img src="{{ $value }}" class="imgProduct img-thumbnail" width="200">
                                </div>
                            </div>
                            <div class="form-group media-box-group">
                                <label class="control-label col-md-2">
                                    Chọn game
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control" name="home_slide[game_id][]"><option selected="selected" value="">
                                        @foreach ($games as $key => $game)
                                            <option value="{{ $game->id }}" 
                                                
                                            @if ($game->id == $data->home_slide->game_id[$k]  )
                                                selected
                                            @endif    
                                            >{{ $game->getInfoLanguage(1)->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
                
            </div>

            <h4>Thiết lập task Service</h4>
            <hr>
            <div class="form-group" style="margin-top: 20px;">
                <label class="control-label col-md-2"> Ảnh Service </label>
            
                <div class="col-md-8">
                    <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                       
                        <div class="col-md-9">
                            <div class="input-box" style="position: relative;width: 100%;">
                                <input id="thumbnail" type="text" name="home_service[image]" class="form-control"
                                        value="{{ isset($data->home_service->image)?$data->home_service->image:'' }}"
                                        readonly="" placeholder="Đường dẫn ảnh"
                                        style="position: relative;width: 100%;">

                                <button type="button" class="btn btn-success btn-add"
                                        style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                </button>
                            </div>

                        </div>
                        <div class="col-md-3 text-center" id="avatar">
                            @if(isset($data->home_service->image))
                            <img src="{{ isset($data->home_service->image)?$data->home_service->image:'' }}" class="imgProduct img-thumbnail" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        
            <h4>Thiết lập STUDIOS & PARTNER</h4>
            <hr>
             
            <div class="form-group" style="margin-top: 20px;">
                <label class="control-label col-md-2"> Đối tác <button type="button"  class="btn btn-success add-partner""><i class="fa fa-plus"></i></button></label>
            
                <div class="col-md-8 list-partner">
                        
                    @if(!empty($data->home_partner))     
                    @foreach($data->home_partner->image as $k => $value)
                        <div class="list-partner-detail">
                            <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                                <div class="col-md-2">
                                    
                                    <button type="button" class="btn btn-danger remove-partner"><i class="fa fa-times"></i></button>
                                    <button type="button" class="btn btn-success add-partner"><i class="fa fa-plus"></i></button>
                                
                                </div>
                                <div class="col-md-7">
                                    <div class="input-box" style="position: relative;width: 100%;">
                                        <input id="thumbnail" type="text" name="home_partner[image][]" class="form-control"
                                                value="{{ $value }}"
                                                readonly="" placeholder="Đường dẫn ảnh"
                                                style="position: relative;width: 100%;">

                                        <button type="button" class="btn btn-success btn-add"
                                                style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                        </button>
                                    </div>

                                </div>
                                <div class="col-md-3 text-center" id="avatar">
                                    <img src="{{ $value }}" class="imgProduct img-thumbnail" width="200">
                                </div>
                            </div>
                            <div class="form-group media-box-group">
                                <label class="control-label col-md-2">
                                    Link
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="home_partner[link][]" value="{{ $data->home_partner->link[$k] }}" class="form-control" >
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
                
            </div>
            

        </div>
        <div class="form-actions util-btn-margin-bottom-5">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                   
                    <button type="submit" class="btn btn-primary full-width-xs" name="save_only">
                        <i class="fa fa-save"></i> Lưu thay đổi
                    </button>
                    
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@push('js_footer')
    <script src="/assets/ckeditor/ckeditor.js"></script>
    <script src="/assets/ckfinder/ckfinder.js"></script>
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

            $('body').on('click', '.add-wall-slide', function(){
                let html = `<div class="list-wall-slide-detail">
                                <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                                    <div class="col-md-2">
                                        
                                        <button type="button" class="btn btn-danger remove-wall-slide"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-success add-wall-slide"><i class="fa fa-plus"></i></button>
                                    
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-box" style="position: relative;width: 100%;">
                                            <input id="thumbnail" type="text" name="home_slide[slide][]" class="form-control"
                                                    value=""
                                                    readonly="" placeholder="Đường dẫn ảnh"
                                                    style="position: relative;width: 100%;">

                                            <button type="button" class="btn btn-success btn-add"
                                                    style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                            </button>
                                        </div>

                                    </div>
                                    <div class="col-md-3 text-center" id="avatar">
                                        
                                    </div>
                                </div>
                                <div class="form-group media-box-group">
                                    <label class="control-label col-md-2">
                                        Chọn game
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="home_slide[game_id][]"><option selected="selected" value="">
                                            @foreach ($games as $key => $game)
                                                <option value="{{ $game->id }}"  
                                                >{{ $game->getInfoLanguage(1)->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>`;

                $('.list-wall-slide').append(html);
                

            });
            $('body').on('click', '.remove-wall-slide', function(){
                
                $(this).closest('.list-wall-slide-detail').remove();
                                  
            });

            $('body').on('click', '.add-partner', function(){
                let html = `<div class="list-partner-detail">
                                <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                                    <div class="col-md-2">
                                        
                                        <button type="button" class="btn btn-danger remove-partner"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-success add-partner"><i class="fa fa-plus"></i></button>
                                    
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-box" style="position: relative;width: 100%;">
                                            <input id="thumbnail" type="text" name="home_partner[image][]" class="form-control"
                                                    value=""
                                                    readonly="" placeholder="Đường dẫn ảnh"
                                                    style="position: relative;width: 100%;">

                                            <button type="button" class="btn btn-success btn-add"
                                                    style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                            </button>
                                        </div>

                                    </div>
                                    <div class="col-md-3 text-center" id="avatar">
                                        
                                    </div>
                                </div>
                                <div class="form-group media-box-group">
                                    <label class="control-label col-md-2">
                                        Link
                                    </label>
                                    <div class="col-md-8">
                                        <input type="text" name="home_partner[link][]" value="#" class="form-control" >
                                    </div>
                                </div>
                            </div>`;

                $('.list-partner').append(html);
                

            });
            $('body').on('click', '.remove-partner', function(){
                
                $(this).closest('.list-partner-detail').remove();
                                  
            });
        });
    </script>
@endpush
