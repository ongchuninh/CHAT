@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['links', 'links.all'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('links.links'), trans('links.list-links')],
		'url'	=>	[
			route('admin.links.index'),
		],
	],
])

@section('page_title', trans('links.list-links'))

@section('tool_bar')
	@can('admin.links.create')
		<a href="{{ route('admin.links.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('links.add-new-links')</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' => $links->total(),
		'paginate' => $links->appends($filter)->render(),
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
	                    <label class="control-label col-md-3">@lang('links.status')</label>
	                    <div class="col-md-9">
	                    	{!! Form::select('status', \Gamota\Links\Links::statusable()->mapWithKeys(function ($item) {
								return [$item['slug'] => $item['name']];
							})->all(), isset($filter['status']) ? $filter['status'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
	                    </div>
	                </div>
	            </div>
            </div>
            <div class="row">
            	<div class="col-sm-6 md-pr-0">
            		<div class="form-group">
	                    <label class="control-label col-md-3">@lang('links.author')</label>
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
				{!! \Gamota\Links\Links::linkSort(trans('links.id'), 'id') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Links\Links::linkSort(trans('links.title'), 'title') !!}
			</th>
			<th>@lang('links.slug')</th>
			<th>@lang('links.url')</th>
			<th>
				@lang('links.author')
			</th>
			<th>
				{!! \Gamota\Links\Links::linkSort(trans('links.date_update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($links as $links_item)
				<tr class="odd gradeX hover-display-container {{ $links_item->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $links_item->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $links_item->id }}</strong>
					</td>
					<td>
						@can('admin.links.edit', $links_item)
							<a href="{{ route('admin.links.edit', ['id' => $links_item->id]) }}">
								<strong>{{ $links_item->title }}</strong>
							</a>
						@endcan
						@cannot('admin.links.edit', $links_item)
							<strong>{{ $links_item->title }}</strong>
						@endcannot
					</td>
					<td>{{ $links_item->slug }}</td>
					<td>{{ $links_item->url }}</td>

					<td>
						<img class="img-circle" style="width: 30px;" src="{{ thumbnail_url($links_item->author->avatar, ['width' =>50, 'height' => 50]) }}" alt="" /> {{ $links_item->author->full_name }}
					</td>

					<td>
						{{ ( isset($links_item->updated_at) ? $links_item->updated_at->diffForHumans() : '' )  }}
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
	                        	@if(Route::has('links.show'))
	                            	<li><a href="{{ route('links.show', ['slug' => $links_item->slug, 'id' => $links_item->id]) }}"><i class="fa fa-eye"></i> @lang('cms.view')</a></li>
	                            	<li role="presentation" class="divider"></li>
	                            @endif
	                            
	                            @can('admin.links.edit', $links_item)
		                            <li><a href="{{ route('admin.links.edit',['id' => $links_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
		                            <li role="presentation" class="divider"></li>
		                        @endcan
	                        	
	                        	@can('admin.links.disable', $links_item)
		                        	@if($links_item->isEnable())
		                        		<li><a data-function="disable" data-method="put" href="{{ route('admin.links.disable', ['id' => $links_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.disable')</a></li>
		                        	@endif
	                        	@endcan

	                            @if($links_item->isDisable())
	                        		@can('admin.links.enable', $links_item)
	                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.links.enable', ['id' => $links_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.enable')</a></li>
	                            		<li role="presentation" class="divider"></li>
	                            	@endcan

	                            	@can('admin.links.destroy', $links_item)
	                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.links.destroy', ['id' => $links_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
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