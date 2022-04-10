@extends('Cms::layouts.default',[
    'active_admin_menu'     => ['option', 'option.games'],
    'breadcrumbs'           => [
        'title' => [trans('Options::option.option'), 'Thiết lập trang Games', trans('cms.edit')],
        'url'   => [
            route('admin.option.home'),
        ],
    ],
])

@section('page_title', 'Thiết lập trang Games')

@section('content')
    
    {!! Form::ajax(['url' => route('admin.option.updateGames'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($links_id) ? 'PUT' : 'POST']) !!}
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


