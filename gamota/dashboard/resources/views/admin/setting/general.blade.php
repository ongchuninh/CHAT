@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['setting', 'setting.general'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('setting.setting'), trans('setting.general')],
		'url'	=> [route('admin.setting.general')],
	],
])

@section('page_title', trans('setting.general-setting'))

@section('content')
	{!! Form::ajax(['method' => 'PUT', 'url' => route('admin.setting.general.update'), 'class' => 'form-horizontal']) !!}
		<div class="form-body">
			<fieldset>
				<legend>@lang('setting.common-info')</legend>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.language.language')
					</label>
					<div class="col-sm-3">
						{!! Form::select('language', \Language::mapWithKeys(function ($item) {
							return [$item => $item];
						})->all(), $language, ['class' => 'form-control width-auto', 'placeholder' => ''] )!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.name')
					</label>
					<div class="col-sm-3">
						<input type="text" name="company_name" class="form-control" value="{{ $company_name }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.phone-number')
					</label>
					<div class="col-sm-3">
						<input type="text" name="company_phone" class="form-control" value="{{ $company_phone }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.email')
					</label>
					<div class="col-sm-3">
						<input type="text" name="company_email" class="form-control" value="{{ $company_email }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.address')
					</label>
					<div class="col-sm-3">
						<textarea name="company_address" class="form-control" >{{ $company_address }}</textarea>
					</div>
				</div>
				<div class="form-group media-box-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.company.logo')
					</label>
					<div class="col-sm-9">
						{{-- {!! Form::btnMediaBox('logo', $logo, $logo) !!} --}}
						<div class="row">
						<div class="col-md-7">
							<div class="input-box" style="position: relative;width: 100%;">
								<input id="thumbnail" type="text" name="logo" class="form-control"
									value="{{ isset($logo)? $logo :'' }}"
										readonly="" placeholder="Đường dẫn ảnh"
										style="position: relative;width: 100%;">

								<button type="button" class="btn btn-success btn-add"
										style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
								</button>
							</div>
						</div>
						<div class="col-md-3 text-center" id="avatar">
							@if(isset($logo))
							<img src="{{ $logo }}" class="imgProduct img-thumbnail" width="200">
							@endif
						</div>
						</div>
					</div>
				</div>
			</fieldset>
			<!-- Begin of Cai dat facebook, google -->
			<fieldset>
				<legend>@lang('setting.social-setting')</legend>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.social.google-analytics-script')
					</label>
					<div class="col-sm-3">
						<textarea name="google_analytics_script" class="form-control" >{{ $google_analytics_script }}</textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.social.facebook-ads-script')
					</label>
					<div class="col-sm-3">
						<textarea name="facebook_ads_script" class="form-control" >{{ $facebook_ads_script }}</textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.social.facebook-fanpage')
					</label>
					<div class="col-sm-3">
						<input type="text" name="facebook_fanpage" class="form-control" value="{{ $facebook_fanpage }}" />
					</div>
				</div>

				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.social.facebook-group')
					</label>
					<div class="col-sm-3">
						<input type="text" name="facebook_group" class="form-control" value="{{ $facebook_group }}" />
					</div>
				</div>

			</fieldset>
			<!-- End of Cai dat facebook, google -->
			<fieldset>
				<legend>@lang('setting.seo-setting')</legend>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.seo.home-title')
					</label>
					<div class="col-sm-3">
						<input type="text" name="home_title" class="form-control" value="{{ $home_title }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.seo.home-keyword')
					</label>
					<div class="col-sm-3">
						<input type="text" name="home_keyword" class="form-control" value="{{ $home_keyword }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.seo.home-description')
					</label>
					<div class="col-sm-3">
						<textarea name="home_description" class="form-control">{{ $home_description }}</textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>@lang('setting.image-setting')</legend>
				<div class="form-group media-box-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.image.default-thumnail')
					</label>
					<div class="col-sm-9">
						{{-- {!! Form::btnMediaBox('default_thumbnail', $default_thumbnail, $default_thumbnail) !!} --}}
						<div class="row">
						<div class="col-md-7">
							<div class="input-box" style="position: relative;width: 100%;">
								<input id="thumbnail" type="text" name="default_thumbnail" class="form-control"
									value="{{ isset($default_thumbnail)? $default_thumbnail :'' }}"
										readonly="" placeholder="Đường dẫn ảnh"
										style="position: relative;width: 100%;">

								<button type="button" class="btn btn-success btn-add"
										style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
								</button>
							</div>
						</div>
						<div class="col-md-3 text-center" id="avatar">
							@if(isset($default_thumbnail))
							<img src="{{ $default_thumbnail }}" class="imgProduct img-thumbnail" width="200">
							@endif
						</div>
						</div>
					</div>
				</div>
				<div class="form-group media-box-group">
					<label class="control-lalel col-sm-3 pull-left">
						@lang('setting.image.default-avatar')
					</label>
					<div class="col-sm-9">
						{{-- {!! Form::btnMediaBox('default_avatar', $default_avatar, $default_avatar) !!} --}}
						<div class="row">
						<div class="col-md-7">
							<div class="input-box" style="position: relative;width: 100%;">
								<input id="thumbnail" type="text" name="default_avatar" class="form-control"
									value="{{ isset($default_avatar)? $default_avatar :'' }}"
										readonly="" placeholder="Đường dẫn ảnh"
										style="position: relative;width: 100%;">

								<button type="button" class="btn btn-success btn-add"
										style="position: absolute;right: 0;top: 0; height: 34px">Thêm ảnh
								</button>
							</div>
						</div>
						<div class="col-md-3 text-center avatar" id="avatar" data-a="123">
							@if(isset($default_avatar))
							<img src="{{ $default_avatar }}" class="imgProduct img-thumbnail" width="200">
							@endif
						</div>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			{!! Form::btnSaveCancel() !!}
		</div>
	{!! Form::close() !!}
@endsection



@push('js_footer')
	<script src="/assets/ckeditor/ckeditor.js"></script>
	<script src="/assets/ckfinder/ckfinder.js"></script>

	<script type="text/javascript">

		
		$(function(){
			$('#confirm-order').change(function(){
    			if ($(this).val() == 'true') {
    				$('#order-status-not-confirm').show();
    			} else {
    				$('#order-status-not-confirm').hide();
    			}
    		});

			$('#order-notify-email').change(function(){
    			if ($(this).val() == 'true') {
    				$('#order-notify-email-user-role').show();
    			} else {
    				$('#order-notify-email-user-role').hide();
    			}
    		});
		});
		$(document).ready(function(){
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
        })
	</script>
@endpush
