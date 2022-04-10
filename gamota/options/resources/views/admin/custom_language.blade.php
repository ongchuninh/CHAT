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
    
    {!! Form::ajax(['url' => route('admin.option.updateLanguage'), 'class' => 'form-horizontal form-bordered form-row-stripped', 'method' => isset($links_id) ? 'PUT' : 'POST']) !!}
        <div>
            <hr>
            <h4>Thiết lập ngôn ngữ</h4>
            <div class="form-group media-box-group">
                <div class="col-sm-11">
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
                                        Trang chủ
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="home[{{ $value->code }}]" value="{{ isset($data->home->{$value->code})?$data->home->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Trang chủ game
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="slide[home][{{ $value->code }}]" value="{{ isset($data->slide->home->{$value->code})?$data->slide->home->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Khám phá thêm
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="btn[game_more][{{ $value->code }}]" value="{{ isset($data->btn->game_more->{$value->code})?$data->btn->game_more->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Liên hệ ngay
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="btn[contact][{{ $value->code }}]" value="{{ isset($data->btn->contact->{$value->code})?$data->btn->contact->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Gửi ngay
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="btn[send_now][{{ $value->code }}]" value="{{ isset($data->btn->send_now->{$value->code})?$data->btn->send_now->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Dịch vụ của chúng tôi
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="our_service[{{ $value->code }}]" value="{{ isset($data->our_service->{$value->code})?$data->our_service->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        QUÁ TRÌNH PHÁT TRIỂN
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="gamota[title][{{ $value->code }}]" value="{{ isset($data->gamota->title->{$value->code})?$data->gamota->title->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Liên Hệ
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="text[contact][{{ $value->code }}]" value="{{ isset($data->text->contact->{$value->code})?$data->text->contact->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        NPH lớn nhất tại Việt Nam
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="service[nph][{{ $value->code }}]" value="{{ isset($data->service->nph->{$value->code})?$data->service->nph->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Tựa game đã phát hành
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="service[game_release][{{ $value->code }}]" value="{{ isset($data->service->game_release ->{$value->code})?$data->service->game_release ->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Game lên feature kho tải
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="service[feature][{{ $value->code }}]" value="{{ isset($data->service->feature->{$value->code})?$data->service->feature->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Người chơi
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="service[user][{{ $value->code }}]" value="{{ isset($data->service->user->{$value->code})?$data->service->user->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>


                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Địa chỉ công ty
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="location[{{ $value->code }}]" value="{{ isset($data->location->{$value->code})?$data->location->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Tiêu đề liên hệ
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="contact[title][{{ $value->code }}]" value="{{ isset($data->contact->title->{$value->code})?$data->contact->title->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>
                                
                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Nội dung liên hệ
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea name="contact[question][{{ $value->code }}]"
                                        class="form-control" cols="30" rows="10" >{{ isset($data->contact->question->{$value->code})?$data->contact->question->{$value->code}:"" }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Tin tức
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="new[news][{{ $value->code }}]" value="{{ isset($data->new->news->{$value->code})?$data->new->news->{$value->code}:"" }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group media-box-group">
                                    <label class="control-label col-sm-2 pull-left">
                                        Tin tức mới nhất
                                    </label>
                                    <div class="col-sm-9">
                                        <input name="new[newsest][{{ $value->code }}]" value="{{ isset($data->new->newsest->{$value->code})?$data->new->newsest->{$value->code}:"" }}" class="form-control" />
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
   
@endpush
