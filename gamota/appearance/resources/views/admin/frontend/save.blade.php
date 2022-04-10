@extends('Cms::layouts.default',[
    'active_admin_menu'     => ['setting', 'setting.appearance', 'setting.appearance.frontend'],
    'breadcrumbs'           => [
        'title' => [trans('frontend.frontend'), isset($frontend_id) ? trans('cms.add-new') : trans('cms.edit')],
        'url'   => [
            route('admin.appearance.frontend.index'),
        ],
    ],
])

@section('page_title', isset($frontend_id) ? trans('appearance.frontend.edit-frontend') : trans('appearance.frontend.add-new-frontend'))

@if(isset($category_id))
    @section('page_sub_title', $frontend->title)
    @section('tool_bar')
        <a href="{{ route('admin.appearance.frontend.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> <span class="hidden-xs">@lang('appearance.frontend.add-new-frontend')</span>
        </a>
    @endsection
@endif

@section('content')
    {!! Form::ajax(['url' => isset($frontend_id) ? route('admin.appearance.frontend.update', ['id' => $frontend->id])  : route('admin.appearance.frontend.store'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($frontend_id) ? 'PUT' : 'POST']) !!}
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-sm-2 pull-left">
                    @lang('frontend.title') <span class="required">*</span>
                </label>
                <div class="col-sm-10">
                    <input value="{{ $frontend->name }}" name="frontend[name]" type="text" placeholder="" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2 pull-left">
                    @lang('frontend.slug')
                </label>
                <div class="col-sm-10">
                    <input value="{{ $frontend->slug }}" name="frontend[slug]" type="text" placeholder="" class="form-control">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" checked="" id="create-slug">
                        @lang('frontend.from-frontend-title')
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">
                    @lang('frontend.content') <span class="required">*</span>
                </label>
                <div class="col-md-10">
                    {!! Form::tinymce('frontend[content]', $frontend->content) !!}
                </div>
            </div>

        </div>
        <div class="form-actions util-btn-margin-bottom-5">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    @if(! isset($frontend_id))
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
                var title = $('input[name="frontend[name]"]').val();
                var slug = strSlug(title);
                $('input[name="frontend[slug]"]').val(slug);
            }
        });

        $('input[name="frontend[name]"]').keyup(function() {
            if ($('#create-slug').is(':checked')) {
                var title = $(this).val();
                var slug = strSlug(title);
                $('input[name="frontend[slug]"]').val(slug);    
            }
        });
    </script>
@endpush
