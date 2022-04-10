@extends('Cms::layouts.default',[
    'active_admin_menu'     => ['option', 'option.general'],
    'breadcrumbs'           => [
        'title' => [trans('Options::option.option'), 'Thiết lập chung', trans('cms.edit')],
        'url'   => [
            route('admin.option.home'),
        ],
    ],
])

@section('page_title', 'Thiết lập chung')
@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/admin/global/css/n-custom.css" />
@endpush

@section('content')
    
    {!! Form::ajax(['url' => route('admin.option.updateGeneral'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($links_id) ? 'PUT' : 'POST']) !!}
        <div>
            <h4>Thiết lập Email nhận tin</h4>
            <hr>
            <div class="row">
                <label class="control-label col-md-2"> Danh sách email <button type="button"  class="btn btn-success add-list-email""><i class="fa fa-plus"></i></button></label>
                <div class="col-md-8 list-email">
                    @if(!empty($data->admin_email))
                    @foreach($data->admin_email as $key => $value)
                    <div class="list-email-detail">
                        <div class="form-group media-box-group">
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-success add-list-email" ><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-danger remove-list-email" ><i class="fa fa-times"></i></button>
                            </div>
                            <div class="col-lg-10">
                                <div class="row" style="margin-bottom:15px;">
                                    <label class="col-sm-3 pull-left">
                                        Tiêu đề liên hệ
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="col-md-9 form-control" name="admin_email_title[]" type="text" value="{{ isset($data->admin_email_title[$key])?$data->admin_email_title[$key]:'' }}" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:15px;">
                                    <label class="col-sm-3 pull-left">
                                        Email nhận tin
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="col-md-9 form-control" name="admin_email[]" type="email" value="{{ $value }}" />
                                    </div>
                                </div>
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
    <script>
        $(document).ready(function(){
            $('body').on('click','.add-list-email',function(){
                
               
                let html =  `<div class="list-email-detail">
                                <div class="form-group media-box-group">
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-success add-list-email" ><i class="fa fa-plus"></i></button>
                                        <button type="button" class="btn btn-danger remove-list-email" ><i class="fa fa-times"></i></button>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="row" style="margin-bottom:15px;">
                                            <label class="col-sm-3 pull-left">
                                                Tiêu đề liên hệ
                                            </label>
                                            <div class="col-sm-8">
                                                <input class="col-md-9 form-control" name="admin_email_title[]" type="text" value="" />
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom:15px;">
                                            <label class="col-sm-3 pull-left">
                                                Email nhận tin
                                            </label>
                                            <div class="col-sm-8">
                                                <input class="col-md-9 form-control" name="admin_email[]" type="email" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                $('.list-email').append(html);
                
            })

            $('body').on('click','.remove-list-email',function(){
                $(this).closest('.list-email-detail').remove();
            })

            
        })
    </script>
@endpush


