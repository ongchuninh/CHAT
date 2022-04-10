@extends('Cms::layouts.default',[
    'active_admin_menu'     => ['links', 'links.category'],
    'breadcrumbs'           => [
        'title' => [trans('links.links'), trans('links.links'), isset($links_id) ? trans('cms.add-new') : trans('cms.edit')],
        'url'   => [
            route('admin.links.index'),
        ],
    ],
])

@section('page_title', isset($links_id) ? trans('links.edit-links') : trans('links.add-new-links'))

@if(isset($links_id))
    @section('page_sub_title', $links->title)
    @section('tool_bar')
        <a href="{{ route('admin.links.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> <span class="hidden-xs">@lang('links.add-new-links')</span>
        </a>
    @endsection
@endif

@section('content')
    {!! Form::ajax(['url' => isset($links_id) ? route('admin.links.update', ['id' => $links->id])  : route('admin.links.store'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($links_id) ? 'PUT' : 'POST']) !!}
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('links.title') <span class="required">*</span>
                </label>
                <div class="col-sm-7">
                    <input value="{{ $links->title }}" name="links[title]" type="text" placeholder="" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('links.slug')
                </label>
                <div class="col-sm-7">
                    <input value="{{ $links->slug }}" name="links[slug]" type="text" placeholder="" class="form-control">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" checked="" id="create-slug">
                        @lang('links.from-links-title')
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('links.url') <span class="required">*</span>
                </label>
                <div class="col-sm-7">
                    <input value="{{ $links->url }}" name="links[url]" type="text" placeholder="" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('links.target')
                </label>
                <div class="col-sm-7">
                    {!! Form::select('links[target]', ['_blank' => '_blank' , '_self' => '_self'], ( !$links->target ? '_blank' : $links->target ), ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3 pull-left">
                    @lang('links.status') <span class="required">*</span>
                </label>
                <div class="col-sm-7">
                    {!! Form::select('links[status]', $links->statusable()->mapWithKeys(function ($item) {
                        return [$item['slug'] => $item['name']];
                    })->all(), $links->status_slug, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
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
                var title = $('input[name="links[title]"]').val();
                var slug = strSlug(title);
                $('input[name="links[slug]"]').val(slug);
            }
        });

        $('input[name="links[title]"]').keyup(function() {
            if ($('#create-slug').is(':checked')) {
                var title = $(this).val();
                var slug = strSlug(title);
                $('input[name="links[slug]"]').val(slug);    
            }
        });
    </script>
@endpush
