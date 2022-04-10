@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['slider', 'slider.all'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('slider.slider'), trans('slider.list')],
		'url'	=>	[
			route('admin.slider.index'),
		],
	],
])

@section('page_title', trans('slider.list-slider'))

@section('tool_bar')
	@can('admin.slider.create')
		<a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('slider.add-new-slider')</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' => $slider->total(),
		'paginate' => $slider->appends($filter)->render(),
		'bulkactions' => [
			['action' => '', 'name' => trans('cms.enable'), 'method' => 'PUT' ],
			['action' => '', 'name' => trans('cms.disable'), 'method' => 'PUT'],
			['action' => '', 'name' => trans('cms.destroy'), 'method' => 'DELETE'],
		],
	])
		@slot('filter')
			<div class="row">
				<div class="col-sm-6 md-pr-0">
	            	<div class="form-group">
	                    <label class="control-label col-md-3">@lang('cms.search')</label>
	                    <div class="col-md-9">
	                         <input type="text" class="form-control" name="title" value="{{ $filter['title'] or '' }}" />
	                    </div>
	                </div>
	            </div>
	            <div class="col-sm-6 md-pl-0">
	                <div class="form-group">
	                    <label class="control-label col-md-3">@lang('slider.status')</label>
	                    <div class="col-md-9">
	                    	{!! Form::select('status', \Gamota\Slider\Slider::statusable()->mapWithKeys(function ($item) {
								return [$item['slug'] => $item['name']];
							})->all(), isset($filter['status']) ? $filter['status'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
	                    </div>
	                </div>
	            </div>
            </div>
            <!-- <div class="row">
            	<div class="col-sm-6 md-pr-0">
            		<div class="form-group">
	                    <label class="control-label col-md-3">@lang('slider.author')</label>
	                    <div class="col-md-9">
	                    	{!! Form::findUser('author_id', isset($filter['author_id']) ? $filter['author_id'] : null) !!}
	                    </div>
	                </div>
            	</div>
            </div> -->
		@endslot

		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th width="50" class="text-center">
				{!! \Gamota\Slider\Slider::linkSort(trans('slider.id'), 'id') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Slider\Slider::linkSort(trans('slider.title'), 'title') !!}
			</th>
			<th>@lang('slider.thumbnail')</th>
			<th>@lang('slider.link')</th>
			<th>@lang('slider.target')</th>
			<th>
				@lang('slider.author')
			</th>
			<th>
				{!! \Gamota\Slider\Slider::linkSort(trans('slider.date_update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($slider as $slider_item)
				<tr class="odd gradeX hover-display-container {{ $slider_item->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $slider_item->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $slider_item->id }}</strong>
					</td>
					<td>
						@can('admin.slider.edit', $slider_item)
							<a href="{{ route('admin.slider.edit', ['id' => $slider_item->id]) }}">
								<strong>{{ $slider_item->title }}</strong>
							</a>
						@endcan
						@cannot('admin.slider.edit', $slider_item)
							<strong>{{ $slider_item->title }}</strong>
						@endcannot
					</td>
					<td><img src="{{ thumbnail_url($slider_item->thumbnail, ['height' => '70', 'width' => '70']) }}" /></td>
					<td><a href="{{ $slider_item->link }}">{{ $slider_item->link }}</a></td>
					<td>{{ $slider_item->target }}</td>

					<td>
						<img class="img-circle" style="width: 30px;" src="{{ thumbnail_url($slider_item->author->avatar, ['width' =>50, 'height' => 50]) }}" alt="" /> {{ $slider_item->author->full_name }}
					</td>

					<td>
						{{ ( isset($slider_item->updated_at) ? $slider_item->updated_at->diffForHumans() : '' )  }}
					</td>
					<td>
						<div class="btn-group pull-right">
							<a href="" class="btn btn-circle btn-xs grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								<span class="hidden-xs">
									@lang('cms.action')
									<span class="fa fa-angle-down"> </span>
								</span>
								<span class="visible-xs">
									<span class="fa fa-cog"> </span>
								</span>
	                        </a>
	                        <ul class="dropdown-menu pull-right">
	                        	@if(Route::has('slider.show'))
	                            	<li><a href="{{ route('slider.show', ['slug' => $slider_item->slug, 'id' => $slider_item->id]) }}"><i class="fa fa-eye"></i> @lang('cms.view')</a></li>
	                            	<li role="presentation" class="divider"></li>
	                            @endif
	                            
	                            @can('admin.slider.edit', $slider_item)
		                            <li><a href="{{ route('admin.slider.edit',['id' => $slider_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
		                            <li role="presentation" class="divider"></li>
		                        @endcan
	                        	
	                        	@can('admin.slider.disable', $slider_item)
		                        	@if($slider_item->isEnable())
		                        		<li><a data-function="disable" data-method="put" href="{{ route('admin.slider.disable', ['id' => $slider_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.disable')</a></li>
		                        	@endif
	                        	@endcan

	                            @if($slider_item->isDisable())
	                        		@can('admin.slider.enable', $slider_item)
	                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.slider.enable', ['id' => $slider_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.enable')</a></li>
	                            		<li role="presentation" class="divider"></li>
	                            	@endcan

	                            	@can('admin.slider.destroy', $slider_item)
	                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.slider.destroy', ['id' => $slider_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
	                            	@endcan
	                        	@endif
	                        </ul>
	                    </div>
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection