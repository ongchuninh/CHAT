@extends('Cms::layouts.default',[
    'active_admin_menu'     => ['option', 'option.plot'],
    'breadcrumbs'           => [
        'title' => [trans('Options::option.option'), 'Thiết lập trang dịch vụ', trans('cms.edit')],
        'url'   => [
            route('admin.option.home'),
        ],
    ],
])

@section('page_title', 'Thiết lập trang dịch vụ')
@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/admin/global/css/n-custom.css" />
@endpush
@section('content')
    
    {!! Form::ajax(['url' => route('admin.option.updateService'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($links_id) ? 'PUT' : 'POST']) !!}
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

            <hr>
            <h4>Thiết lập Ảnh nền</h4>
            <div class="form-group" style="margin-top: 20px;">
                <label class="control-label col-md-2"> Ảnh nền </label>
            
                <div class="col-md-8">
                    <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                       
                        <div class="col-md-9">
                            <div class="input-box" style="position: relative;width: 100%;">
                                <input id="thumbnail" type="text" name="background[image]" class="form-control"
                                        value="{{ isset($data->background->image)?$data->background->image:'' }}"
                                        readonly="" placeholder="Đường dẫn ảnh"
                                        style="position: relative;width: 100%;">

                                <button type="button" class="btn btn-success btn-add"
                                        style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                </button>
                            </div>

                        </div>
                        <div class="col-md-3 text-center" id="avatar">
                            @if(isset($data->background->image))
                            <img src="{{ isset($data->background->image)?$data->background->image:'' }}" class="imgProduct img-thumbnail" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <h4>Thiết lập Task giới thiệu</h4>
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
                                
                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Nội dung
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea name="text[content][{{ $value->code }}]" 
                                        class="form-control" cols="30" rows="10" >{{ isset($data->text_content->content->{$value->code})?$data->text_content->content->{$value->code}:"" }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </figure>
                </div>
            </div>
            <div class="form-group" style="margin-top: 20px;">
                <label class="control-label col-md-2"> Giới thiệu <button type="button"  class="btn btn-success add-about""><i class="fa fa-plus"></i></button></label>
                
                <div class="col-md-8 list-about">
                    @if(!empty($data->about->image))       
                 
                    @foreach($data->about->image as $k => $value)
                        <div class="list-about-detail">
                            
                            <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                                <div class="col-md-2">
                                    
                                    <button type="button" class="btn btn-danger remove-about"><i class="fa fa-times"></i></button>
                                    <button type="button" class="btn btn-success add-about"><i class="fa fa-plus"></i></button>
                                
                                </div>
                                <div class="col-md-7">
                                    <div class="input-box" style="position: relative;width: 100%;">
                                        <input id="thumbnail" type="text" name="about[image][]" class="form-control"
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
                                    Nội dung
                                </label>
                                <div class="col-md-10 ">
                                  
                                    <figure class="tabBlock">
                                        <ul class="tabBlock-tabs">
                                            @foreach($languages as $key => $value)
                                            <li class="tabBlock-tab {{ ($key == 0)?'is-active':'' }}">{{ $value->name }}</li>
                                            @endforeach
                                        </ul>
                                        <div class="tabBlock-content">
                                            @foreach($languages as $key => $value)
                                            <div class="tabBlock-pane">
                                                <div class="form-group media-box-group">
                                                    <label class="control-label col-md-2">
                                                        Tiêu đề
                                                    </label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="about[title][{{ $value->code }}][]" value="{{ $data->about->title->{$value->code}[$k]}}">
                                                    </div>
                                                </div>
                                                <div class="form-group media-box-group about" data-a="{{ $key.$value->code }}">
                                                    <label class="control-label col-sm-2 pull-left">
                                                        Nội dung
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <textarea name="ckeditor{{ $k.$value->code }}" 
                                                        class="ckeditor{{ $k.$value->code }}" id="editor" cols="30" rows="10">{{ $data->about->content->{$value->code}[$k] }}</textarea>
                                                        <input type="hidden" class="ckeditor{{ $k.$value->code }}"  name="about[content][{{ $value->code }}][]" value="{{ $data->about->content->{$value->code}[$k] }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </figure>
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
    <script src="/assets/admin/global/scripts/n-custom.js"></script>
    <script src="/assets/ckeditor/ckeditor.js"></script>
    <script src="/assets/ckfinder/ckfinder.js"></script>
    <script>
        $('document').ready(function(){

            $('textarea#editor').each(function(k,val){
                let name = $(this).attr('name');
                //let class = $(this).attr('name');
                t = $(this);
                let editor = CKEDITOR.replace(name);

                
                editor.on('change', function() {
                    $('input.'+name).val(editor.getData());
                    $(this).closest('.about').find('input').eq(0).val(editor.getData());
                    
                });

                //1
                
            })




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

            

            var index = {{ isset($k)? $k : -1 }};
            $('body').on('click', '.add-about', function(){
                index ++;
                let html = `<div class="list-about-detail">             
                                <div class="row " style="margin-bottom: 20px; padding-top: 7px;">
                                    <div class="col-md-2">
                                        
                                        <button type="button" class="btn btn-danger remove-about"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-success add-about"><i class="fa fa-plus"></i></button>
                                    
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-box" style="position: relative;width: 100%;">
                                            <input id="thumbnail" type="text" name="about[image][]" class="form-control"
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
                                        Nội dung
                                    </label>
                                    <div class="col-md-10 ">                               
                                        <figure class="tabBlock">
                                            <ul class="tabBlock-tabs">
                                                @foreach($languages as $key => $value)
                                                <li class="tabBlock-tab {{ ($key == 0)?'is-active':'' }}">{{ $value->name }}</li>
                                                @endforeach
                                            </ul>
                                            <div class="tabBlock-content">
                                                @foreach($languages as $key => $value)
                                                <div class="tabBlock-pane">
                                                    <div class="form-group media-box-group">
                                                        <label class="control-label col-md-2">
                                                            Tiêu đề
                                                        </label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" name="about[title][{{ $value->code }}][]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group media-box-group about" data-a="{{ $key.$value->code }}">
                                                        <label class="control-label col-sm-2 pull-left">
                                                            Nội dung
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <textarea name="ckeditor${index}{{ $value->code }}" 
                                                            class="ckeditor${index}{{ $value->code }}" id="editor${index}" cols="30" rows="10"></textarea>
                                                            <input type="hidden" class="ckeditor${index}{{ $value->code }}"  name="about[content][{{ $value->code }}][]" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </figure>
                                    </div>
                                </div>
                            </div>`;

                $('.list-about').append(html);
                
                
                
                $('textarea#editor'+index).each(function(k,val){
                    let name = $(this).attr('name');
                    
                    t = $(this);
                    let editor = CKEDITOR.replace(name);

                    
                    editor.on('change', function() {
                        $('input.'+name).val(editor.getData());
                        $(this).closest('.about').find('input').eq(0).val(editor.getData());
                        
                    });

                //1
                    
                })
                TabBlock.init();

                
                
            });
                
                

            
            $('body').on('click', '.remove-about', function(){
                
                $(this).closest('.list-about-detail').remove();
                                
            });
            
            
            
        });
    </script>
@endpush
