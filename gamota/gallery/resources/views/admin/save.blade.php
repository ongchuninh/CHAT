@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['gallery', isset($news_id) ? 'gallery.all' : 'gallery.create'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('gallery.gallery'), isset($gallery_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			route('admin.gallery.index')
		],
	],
])

@section('page_title', isset($gallery_id) ? trans('gallery.edit-gallery') : trans('gallery.add-new-gallery'))

@if(isset($gallery_id))
    @section('page_sub_title', $gallery->title)
    @can('admin.gallery.create')
        @section('tool_bar')
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> <span class="hidden-xs">@lang('gallery.add-new-gallery')</span>
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
                        <a href="#gallery-content" data-toggle="tab" aria-expanded="true"> @lang('gallery.content') </a>
                    </li>
                    <li class="">
                        <a href="#gallery-data" data-toggle="tab" aria-expanded="false"> @lang('gallery.data') </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::ajax(['method' => isset($gallery_id) ? 'PUT' : 'POST' , 'url' => isset($gallery_id) ? route('admin.gallery.update', ['id' => $gallery->id]) : route('admin.gallery.store'), 'class' => 'form-horizontal form-bordered form-row-stripped']) !!}
                <div class="form-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="gallery-content">
                            <div class="form-group">
                                <label class="control-label col-sm-2">@lang('gallery.title')</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <input value="{{ $gallery->title }}" name="gallery[title]" type="text" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="gallery[slug]" value="{{ $gallery->slug }}" placeholder="Slug" class="form-control str-slug" value="{{ $gallery->slug or '' }}" />
                                            <label class="checkbox-inline">
                                                <input type="checkbox" value="true" checked="" id="create-slug">
                                                @lang('gallery.from-gallery-title')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">@lang('gallery.youtube_id')</label>
                                <div class="col-sm-10">
                                    <input value="{{ $gallery->youtube_id }}" name="gallery[youtube_id]" type="text" class="form-control" placeholder="Youtube Id : 7grNM8D2t6g" />
                                    <label class="checkbox-inline">
                                        @lang('gallery.null-for-image')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="gallery-data">
                            <div class="form-group">
                                <label class="control-label col-md-2">
                                    @lang('gallery.category.category') <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    @include('Gallery::admin.components.form-checkbox-category-with-create', [
                                        'categories' =>  Gamota\Gallery\Category::get(),
                                        'name' => 'gallery[category_id][]',
                                        'checked' => $gallery->categories->pluck('id')->all(),
                                        'class' => 'width-auto',
                                    ])
                                </div>
                            </div>
                            <div class="form-group media-box-group">
                                <label class="control-label col-md-2">
                                    @lang('cms.thumbnail')
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::btnMediaBox('gallery[thumbnail]', $gallery->thumbnail, thumbnail_url($gallery->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    @lang('gallery.type') <span class="required">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            {!! Form::radio('gallery[type]', 'image', true, ['class' => '', 'id' => 'image']) !!}

                                            <label for="image">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> 
                                                Image
                                            </label>
                                        </div>

                                        <div class="md-radio">
                                            {!! Form::radio('gallery[type]', 'clip', true, ['class' => '', 'id' => 'clip']) !!}

                                            <label for="clip">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> 
                                                clip
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">
                                    @lang('gallery.status') <span class="required">*</span>
                                </label>
                                <div class="col-sm-10">
                                    {!! Form::select('gallery[status]', $gallery->statusable()->mapWithKeys(function ($item) {
                                        return [$item['slug'] => $item['name']];
                                    })->all(), $gallery->status_slug, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions util-btn-margin-bottom-5">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            @if(!isset($gallery_id))
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
    <script type="text/javascript">
        $(function(){
            $('#create-slug').click(function() {
                if(this.checked) {
                    var title = $('input[name="gallery[title]"]').val();
                    var slug = strSlug(title);
                    $('input[name="gallery[slug]"]').val(slug);
                }
            });

            $('input[name="gallery[title]"]').keyup(function() {
                if ($('#create-slug').is(':checked')) {
                    var title = $(this).val();
                    var slug = strSlug(title);
                    $('input[name="gallery[slug]"]').val(slug); 
                }
            });
        });
    </script>
@endpush
