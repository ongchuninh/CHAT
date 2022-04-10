@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['setting', 'setting.appearance', 'setting.appearance.frontend'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('frontend.frontend'), trans('frontend.list-frontend')],
		'url'	=>	[
			route('admin.appearance.frontend.index'),
		],
	],
])

@section('page_title', trans('frontend.list-frontend'))

@section('tool_bar')
	@can('admin.appearance.frontend.create')
		<a href="{{ route('admin.appearance.frontend.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('frontend.add-new-frontend')</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' => $frontend->total(),
		'paginate' => $frontend->appends($filter)->render(),
		'bulkactions' => [
			['action' => 'admin/appearance/frontend/applyStatus/destroy', 'name' => trans('cms.destroy'), 'method' => 'DELETE']
		],
	])

		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th width="50" class="text-center">
				{!! \Gamota\Appearance\Frontend::linkSort(trans('frontend.id'), 'id') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Appearance\Frontend::linkSort(trans('frontend.title'), 'title') !!}
			</th>
			<th>
				@lang('frontend.author')
			</th>
			<th>
				{!! \Gamota\Appearance\Frontend::linkSort(trans('frontend.date_update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($frontend as $frontend_item)
				<tr class="odd gradeX hover-display-container {{ $frontend_item->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $frontend_item->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $frontend_item->id }}</strong>
					</td>
					<td>
						@can('admin.appearance.frontend.edit', $frontend_item)
							<a href="{{ route('admin.appearance.frontend.edit', ['id' => $frontend_item->id]) }}">
								<strong>{{ $frontend_item->name }}</strong>
							</a>
						@endcan
						@cannot('admin.appearance.frontend.edit', $frontend_item)
							<strong>{{ $frontend_item->name }}</strong>
						@endcannot
					</td>
					<td>
						<img class="img-circle" style="width: 30px;" src="{{ thumbnail_url($frontend_item->author->avatar, ['width' =>50, 'height' => 50]) }}" alt="" /> {{ $frontend_item->author->full_name }}
					</td>
					<td>
						{{ $frontend_item->updated_at->diffForHumans() }}
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
	                            @can('admin.appearance.frontend.edit', $frontend_item)
		                            <li><a href="{{ route('admin.appearance.frontend.edit',['id' => $frontend_item->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
		                            <li role="presentation" class="divider"></li>
		                        @endcan

                            	@can('admin.appearance.frontend.destroy', $frontend_item)
                            		<li><a data-function="destroy" data-method="delete" href="{{ route('admin.appearance.frontend.destroy', ['id' => $frontend_item->id]) }}"><i class="fa fa-times"></i> @lang('cms.destroy')</a></li>
                            	@endcan
	                        </ul>
	                    </div>
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection