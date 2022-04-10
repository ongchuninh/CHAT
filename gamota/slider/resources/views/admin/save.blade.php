@extends('Cms::layouts.default',[
    'active_admin_menu'     => ['slider', 'slider.category'],
    'breadcrumbs'           => [
        'title' => [trans('slider.slider'), trans('slider.slider'), isset($slider_id) ? trans('cms.add-new') : trans('cms.edit')],
        'url'   => [
            route('admin.slider.index'),
        ],
    ],
])

@section('page_title', isset($slider_id) ? trans('slider.edit-slider') : trans('slider.add-new-slider'))

@if(isset($slider_id))
    @section('page_sub_title', $slider->title)
    @section('tool_bar')
        <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> <span class="hidden-xs">@lang('slider.add-new-slider')</span>
        </a>
    @endsection
@endif

@section('content')
    {!! Form::ajax(['url' => isset($slider_id) ? route('admin.slider.update', ['id' => $slider->id])  : route('admin.slider.store'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($slider_id) ? 'PUT' : 'POST']) !!}
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('slider.title') <span class="required">*</span>
                </label>
                <div class="col-sm-7">
                    <input value="{{ $slider->title }}" name="slider[title]" type="text" placeholder="" class="form-control">
                </div>
            </div>
            <div class="form-group media-box-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('slider.thumbnail')
                </label>
                <div class="col-sm-7">
                    {!! Form::btnMediaBox('slider[thumbnail]', $slider->thumbnail, thumbnail_url($slider->thumbnail, ['width' => '100', 'height' => '100'])) !!}
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('slider.slug')
                </label>
                <div class="col-sm-7">
                    <input value="{{ $slider->slug }}" name="slider[slug]" type="text" placeholder="" class="form-control">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" checked="" id="create-slug">
                        @lang('slider.from-slider-title')
                    </label>
                </div>
            </div> -->

            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('slider.url') <span class="required">*</span>
                </label>
                <div class="col-sm-7">
                    <input value="{{ $slider->link }}" name="slider[link]" type="text" placeholder="http://gamota.com/" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('slider.target')
                </label>
                <div class="col-sm-7">
                    {!! Form::select('slider[target]', ['_blank' => '_blank' , '_self' => '_self'], (($slider->target) == null) ? '_blank' : $slider->target, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('slider.status') <span class="required">*</span>
                </label>
                <div class="col-sm-7">
                    {!! Form::select('slider[status]', $slider->statusable()->mapWithKeys(function ($item) {
                        return [$item['slug'] => $item['name']];
                    })->all(), $slider->status_slug, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
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
    <script type="text/javascript">
        $('#create-slug').click(function() {
            if(this.checked) {
                var title = $('input[name="slider[title]"]').val();
                var slug = strSlug(title);
                $('input[name="slider[slug]"]').val(slug);
            }
        });

        $('input[name="slider[title]"]').keyup(function() {
            if ($('#create-slug').is(':checked')) {
                var title = $(this).val();
                var slug = strSlug(title);
                $('input[name="slider[slug]"]').val(slug);    
            }
        });
    </script>
@endpush
