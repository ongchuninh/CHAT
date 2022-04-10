@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['gallery', 'gallery.all'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('gallery.gallery'), trans('gallery.list')],
		'url'	=>	[
			route('admin.gallery.index'),
		],
	],
])

@section('page_title', trans('gallery.list-gallery'))

@section('tool_bar')
	@can('admin.gallery.create')
		<a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('gallery.add-new-gallery')</span>
		</a>
	@endcan
@endsection

@section('content')
	@php
		if( isset($filter['status']) && $filter['status'] == 'disable' )
			$bulkactions = [ 
				['action' => 'admin/gallery/appplyStatus/enable', 'name' => trans('cms.enable'), 'method' => 'POST' ],
				['action' => 'admin/gallery/appplyStatus/destroy', 'name' => trans('cms.destroy'), 'method' => 'DELETE'],
			];
		else
			$bulkactions = [
				['action' => 'admin/gallery/appplyStatus/disable', 'name' => trans('cms.disable'), 'method' => 'POST']
			];
	@endphp
	@component('Cms::components.table-function', [
		'total' => $gallery->total(),
		'paginate' => $gallery->appends($filter)->render(),
		'bulkactions' => $bulkactions,
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
	                <div class="form-group">
	                    <label class="control-label col-md-3">@lang('gallery.category.category')</label>
	                    <div class="col-md-9">
	                    	{!! Form::select('category_id', Gamota\Gallery\Category::get()->mapWithKeys(function ($item) {
	                    		return [$item->id => $item->name];
	                    	})->all(), isset($filter['category_id']) ? $filter['category_id'] : '', ['class' => 'form-control', 'placeholder' => '']) !!}
	                    </div>
	                </div>
	            </div>
	            <div class="col-sm-6 md-pl-0">
	                <div class="form-group">
	                    <label class="control-label col-md-3">@lang('gallery.status')</label>
	                    <div class="col-md-9">
	                    	{!! Form::select('status', \Gamota\Gallery\Gallery::statusable()->mapWithKeys(function ($item) {
								return [$item['slug'] => $item['name']];
							})->all(), isset($filter['status']) ? $filter['status'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="control-label col-md-3">@lang('gallery.author')</label>
	                    <div class="col-md-9">
	                    	{!! Form::findUser('author_id', isset($filter['author_id']) ? $filter['author_id'] : null) !!}
	                    </div>
	                </div>
	            </div>
            </div>
		@endslot

		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th width="50" class="text-center">
				{!! \Gamota\Gallery\Gallery::linkSort(trans('gallery.id'), 'id') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Gallery\Gallery::linkSort(trans('gallery.title'), 'title') !!}
			</th>
			<th>
				@lang('gallery.thumbnail')
			</th>
			<th>
				@lang('gallery.author')
			</th>
			<th>
				{!! \Gamota\Gallery\Gallery::linkSort(trans('gallery.date_update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($gallery as $gallery_item)
				<tr class="odd gradeX hover-display-container {{ $gallery_item->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $gallery_item->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $gallery_item->id }}</strong>
					</td>
					<td>
						@can('admin.gallery.edit', $gallery_item)
							<a href="{{ route('admin.gallery.edit', ['id' => $gallery_item->id]) }}">
								<strong>{{ $gallery_item->title }}</strong>
							</a>
						@endcan
						@cannot('admin.gallery.edit', $gallery_item)
							<strong>{{ $gallery_item->title }}</strong>
						@endcannot
					</td>
					<td><img src="{{ thumbnail_url($gallery_item->thumbnail, ['height' => '70', 'width' => '70']) }}" /></td>
					<td>
						<img class="img-circle" style="width: 30px;" src="{{ thumbnail_url($gallery_item->author->avatar, ['width' =>50, 'height' => 50]) }}" alt="" /> {{ $gallery_item->author->full_name }}
					</td>
					<td>
						{{ $gallery_item->updated_at->diffForHumans() }}
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
	                        	@if(Route::has('gallery.show'))
	                            	<li><a href="{{ route('gallery.show', ['slug' => $gallery_item->slug, 'id' => $gallery_item->id]) }}"><i class="fa fa-eye"></i> @lang('cms.view')</a></li>
	                            	<li role="presentation" class="divider"></li>
	                            @endif
	                            
	                            @can('admin.gallery.edit', $gallery_item)
		                            <li><a href="{{ route('admin.gallery.edit',['id' => $gallery_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
		                            <li role="presentation" class="divider"></li>
		                        @endcan
	                        	
	                        	@can('admin.gallery.disable', $gallery_item)
		                        	@if($gallery_item->isEnable())
		                        		<li><a data-function="disable" data-method="put" href="{{ route('admin.gallery.disable', ['id' => $gallery_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.disable')</a></li>
		                        	@endif
	                        	@endcan

	                            @if($gallery_item->isDisable())
	                        		@can('admin.gallery.enable', $gallery_item)
	                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.gallery.enable', ['id' => $gallery_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.enable')</a></li>
	                            		<li role="presentation" class="divider"></li>
	                            	@endcan

	                            	@can('admin.gallery.destroy', $gallery_item)
	                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.gallery.destroy', ['id' => $gallery_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
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