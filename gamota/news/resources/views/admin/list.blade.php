@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['news', 'news.all'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('news.news'), trans('news.list')],
		'url'	=>	[
			route('admin.news.index'),
		],
	],
])

@section('page_title', trans('news.list-news'))

@section('tool_bar')
	@can('admin.news.create')
		<a href="{{ route('admin.news.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('news.add-new-news')</span>
		</a>
	@endcan
@endsection

@section('content')
	@php
		if( isset($filter['status']) && $filter['status']=='disable' )
			$bulkactions = [ 
				['action' => 'admin/news/appplyStatusNews/enable', 'name' => trans('cms.enable'), 'method' => 'POST' ],
				['action' => 'admin/news/appplyStatusNews/destroy', 'name' => trans('cms.destroy'), 'method' => 'DELETE'],
			];
		else
			$bulkactions = [
				['action' => 'admin/news/appplyStatusNews/disable', 'name' => trans('cms.disable'), 'method' => 'POST']
			];
	@endphp
	@component('Cms::components.table-function', [
		'total' => $newses->total(),
		'paginate' => $newses->appends($filter)->render(),
		'bulkactions' => $bulkactions,
	])
		@slot('filter')
			<div class="row">
				<div class="col-sm-6 ">
	            	<div class="form-group">
	                    <label class="control-label col-md-3">@lang('cms.search')</label>
	                    <div class="col-md-9">
	                         <input type="text" class="form-control" name="title" value="{{ $filter['title'] or '' }}" />
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="control-label col-md-3">@lang('news.category.category')</label>
	                    <div class="col-md-9">
	                    	{!! Form::select('category_id', Gamota\News\Category::get()->mapWithKeys(function ($item) {
	                    		return [$item->id => $item->name];
	                    	})->all(), isset($filter['category_id']) ? $filter['category_id'] : '', ['class' => 'form-control', 'placeholder' => '']) !!}
	                    </div>
	                </div>
				</div>
				<div class="col-sm-6 ">
	                <div class="form-group">
	                    <label class="control-label col-md-3">@lang('news.status')</label>
	                    <div class="col-md-9">
	                    	{!! Form::select('status', \Gamota\News\News::statusable()->mapWithKeys(function ($item) {
								return [$item['slug'] => $item['name']];
							})->all(), isset($filter['status']) ? $filter['status'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="control-label col-md-3">@lang('news.author')</label>
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
				{!! \Gamota\News\News::linkSort(trans('news.id'), 'id') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\News\News::linkSort(trans('news.title'), 'title') !!}
			</th>
			<th>@lang('news.thumbnail')</th>
			<th>
				@lang('news.author')
			</th>
			<th>
				{!! \Gamota\News\News::linkSort(trans('news.date_update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($newses as $news_item)
				<tr class="odd gradeX hover-display-container {{ $news_item->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $news_item->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $news_item->id }}</strong>
					</td>
					<td>
						@can('admin.news.edit', $news_item)
							<a href="{{ route('admin.news.edit', ['id' => $news_item->id]) }}">
								<strong>{{ $news_item->title }}</strong>
							</a>
						@endcan
						@cannot('admin.news.edit', $news_item)
							<strong>{{ $news_item->title }}</strong>
						@endcannot
					</td>
					<td><img src="{{ thumbnail_url($news_item->thumbnail, ['height' => '70', 'width' => '70']) }}" style="width:100px" /></td>
					<td>
						<img class="img-circle" style="width: 30px;" src="{{ thumbnail_url($news_item->author->avatar, ['width' =>50, 'height' => 50]) }}" alt="" /> {{ $news_item->author->full_name }}
					</td>
					<td>
						{{ ( isset($news_item->updated_at) ? $news_item->updated_at->diffForHumans() : '' )  }}
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
	                        	@if(Route::has('news.show'))
	                            	<li><a href="{{ route('news.show', ['slug' => $news_item->slug, 'id' => $news_item->id]) }}"><i class="fa fa-eye"></i> @lang('cms.view')</a></li>
	                            	<li role="presentation" class="divider"></li>
	                            @endif
	                            
	                            @can('admin.news.edit', $news_item)
		                            <li><a href="{{ route('admin.news.edit',['id' => $news_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
		                            <li role="presentation" class="divider"></li>
		                        @endcan
	                        	
	                        	@can('admin.news.disable', $news_item)
		                        	@if($news_item->isEnable())
		                        		<li><a data-function="disable" data-method="put" href="{{ route('admin.news.disable', ['id' => $news_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.disable')</a></li>
		                        	@endif
	                        	@endcan

	                            @if($news_item->isDisable())
	                        		@can('admin.news.enable', $news_item)
	                            		<li><a data-function="enable" data-method="put" href="{{ route('admin.news.enable', ['id' => $news_item->id]) }}"><i class="fa fa-recycle"></i> @lang('cms.enable')</a></li>
	                            		<li role="presentation" class="divider"></li>
	                            	@endcan

	                            	@can('admin.news.destroy', $news_item)
	                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.news.destroy', ['id' => $news_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
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