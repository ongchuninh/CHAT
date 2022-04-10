@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['news', isset($news_id) ? 'news.all' : 'news.create'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('news.news'), isset($news_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			route('admin.news.index')
		],
	],
])

@section('page_title', isset($news_id) ? trans('news.edit-news') : trans('news.add-new-news'))
@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/admin/global/css/n-custom.css" />
@endpush

@if(isset($news_id))
    @section('page_sub_title', $news->title)
    @can('admin.news.create')
        @section('tool_bar')
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> <span class="hidden-xs">@lang('news.add-new-news')</span>
            </a>
        @endsection
    @endcan
@endif


@section('content')
    <div class="portlet light bordered form-fit">
        <div class="portlet-title with-tab">
            <div class="tab-default">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#news-content" data-toggle="tab" aria-expanded="true"> @lang('news.content') </a>
                    </li>
                    <li class="">
                        <a href="#news-data" data-toggle="tab" aria-expanded="false"> @lang('news.data') </a>
                    </li>
                    <li class="">
                        <a href="#news-seo" data-toggle="tab" aria-expanded="false"> @lang('news.seo') </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::ajax(['method' => isset($news_id) ? 'PUT' : 'POST' , 'url' => isset($news_id) ? route('admin.news.update', ['id' => $news->id]) : route('admin.news.store'), 'class' => 'form-horizontal form-bordered form-row-stripped']) !!}
                <div class="form-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="news-content">
                            <div class="form-group">
                                <label class="control-label col-sm-2">@lang('news.title')</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <figure class="tabBlock">
                                                <ul class="tabBlock-tabs">
                                                    @foreach($languages as $key => $value)
                                                    <li class="tabBlock-tab {{ ($key == 0)?'is-active':'' }}">{{ $value->name }}</li>
                                                    @endforeach
                                                </ul>
                                                <div class="tabBlock-content">
                                                    @foreach($languages as $key => $value)
                                                    <div class="tabBlock-pane">
                                                        
                                                        <input name="news[title][{{ $value->code }}]"
                                                        value="{{ isset($news->id)?$news->getInfoLanguage($value->id)->title:'' }}"
                                                        type="text" class="form-control" id="inputSlug" />
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </figure>
                                        
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Slug</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="news[slug]" value="{{ $news->slug }}" placeholder="Slug" class="form-control str-slug" id="slug" value="{{ $news->slug or '' }}" />
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('news.content') <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    
                                    <figure class="tabBlock">
                                        <ul class="tabBlock-tabs">
                                            @foreach($languages as $key => $value)
                                            <li class="tabBlock-tab {{ ($key == 0)?'is-active':'' }}">{{ $value->name }}</li>
                                            @endforeach
                                        </ul>
                                        <div class="tabBlock-content">
                                            @foreach($languages as $key => $value)
                                            <div class="tabBlock-pane">
                                                
                                                <textarea name="ckeditor{{ $value->code }}" 
                                                    class="ckeditor{{ $value->code }}" id="editor" cols="30" rows="10">{{ isset($news->id)?$news->getInfoLanguage($value->id)->content:'' }}</textarea>
                                                    <input type="hidden" class="ckeditor{{ $value->code }}"  name="news[content][{{ $value->code }}]" value="{{ isset($news->id)?$news->getInfoLanguage($value->id)->content:'' }}">
                                            </div>
                                            @endforeach
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="news-data">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('news.category.category') <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    @include('News::admin.components.form-checkbox-category-with-create', [
                                        'categories' =>  Gamota\News\Category::get(),
                                        'name' => 'news[category_id][]',
                                        'checked' => $news->categories->pluck('id')->all(),
                                        'class' => 'width-auto',
                                    ])
                                </div>
                            </div>
                            <div class="form-group media-box-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.thumbnail')
                                </label>
                                <div class="col-sm-10 ckfinder">
                                    <div class="col-md-9">
                                        <div class="input-box" style="position: relative;width: 100%;">
                                            <input id="thumbnail" type="text" name="news[thumbnail]" class="form-control"
                                                    value="{{ isset($news->thumbnail)?$news->thumbnail:'' }}"
                                                    readonly="" placeholder="Đường dẫn ảnh"
                                                    style="position: relative;width: 100%;">
            
                                            <button type="button" class="btn btn-success btn-add"
                                                    style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
                                            </button>
                                        </div>
            
                                    </div>
                                    <div class="col-md-3 text-center" id="avatar">
                                        @if(isset($news->thumbnail))
                                        <img src="{{ isset($news->thumbnail)?$news->thumbnail:'' }}" class="imgProduct img-thumbnail" width="200">
                                        @endif
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    @lang('news.status') <span class="required">*</span>
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::select('news[status]', $news->statusable()->mapWithKeys(function ($item) {
                                        return [$item['slug'] => $item['name']];
                                    })->all(), $news->status_slug, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="news-seo">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.meta-title')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="news[meta_title]" class="form-control" value="{{ $news->meta_title }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.meta-description')
                                </label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="news[meta_description]">{{ $news->meta_description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.meta-keyword')
                                </label>
                                <div class="col-md-10">
                                    <input type="text" name="news[meta_keyword]" class="form-control" value="{{ $news->meta_keyword }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                
                </div>
                <div class="form-actions util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            @if(!isset($news_id))
                                {!! Form::btnSaveNew() !!}
                            @else
                                {!! Form::btnSaveOut() !!}
                            @endif
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('js_footer')
<script src="/assets/admin/global/scripts/n-custom.js"></script>
<script src="/assets/ckeditor/ckeditor.js"></script>
<script src="/assets/ckfinder/ckfinder.js"></script>
<script>
    $('document').ready(function(){

        $('textarea#editor').each(function(k,val){
                let name = $(this).attr('name');
               
                t = $(this);
                let editor = CKEDITOR.replace(name);

                
                editor.on('change', function() {
                    $('input.'+name).val(editor.getData());
                    $(this).closest('.about').find('input').eq(0).val(editor.getData());
                    
                });
                
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

                        t.closest('.ckfinder').find('#avatar').eq(0).html("<img src='" + file.getUrl() + "' class='imgProduct img-thumbnail' width='200'/>");

                    } );
                }
            } );

        });  
    });
</script>
<script type="text/javascript">
    $(function(){
        $('#create-slug').click(function() {
            if(this.checked) {
                var title = $('input[name="news[title]"]').val();
                var slug = strSlug(title);
                $('input[name="news[slug]"]').val(slug);
            }
        });

        $('input[name="news[title]"]').keyup(function() {
            if ($('#create-slug').is(':checked')) {
                var title = $(this).val();
                var slug = strSlug(title);
                $('input[name="news[slug]"]').val(slug); 
            }
        });
    });
</script>
@endpush
