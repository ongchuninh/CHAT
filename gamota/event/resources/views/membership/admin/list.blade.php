@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['membership', 'membership.all'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('membership.membership'), trans('membership.list')],
		'url'	=>	[
			route('admin.event.membership.index'),
		],
	],
])

@section('page_title', trans('membership.list-membership'))

@section('content')

	@component('Cms::components.table-function', [
		'total' => $member->total(),
		'paginate' => $member->appends($filter)->render(),
		//'bulkactions' => '',
	])
		@slot('filter')
			<div class="row">
				<div class="col-sm-6 md-pr-0">
	            	<div class="form-group">
	                    <label class="control-label col-md-3">@lang('cms.search')</label>
	                    <div class="col-md-9">
	                         <input type="text" class="form-control" name="keyword" value="{{ $filter['keyword'] or '' }}" placeholder="User Id, Lv name ..." />
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
				{!! \Gamota\Event\Membership::linkSort(trans('gallery.id'), 'id') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Event\Membership::linkSort(trans('membership.user_id'), 'user_id') !!}
			</th>

			<th class="text-center">
				{!! \Gamota\Event\Membership::linkSort(trans('membership.total_g'), 'total_g') !!}
			</th>

			<th class="text-center">
				{!! \Gamota\Event\Membership::linkSort(trans('membership.total_m'), 'total_m') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.lv_name') !!}
			</th>

			<th class="text-center">
				{!! \Gamota\Event\Membership::linkSort(trans('membership.date_update'), 'updated_at') !!}
			</th>
			<th></th>
		@endslot
		@php
		//dd($member);
		@endphp
		@slot('data')
			@foreach($member as $item)
				<tr class="odd gradeX hover-display-container {{ $item->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $item->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $item->id }}</strong>
					</td>
					<td class="text-center">
						@can('admin.gallery.edit', $item)
							<a href="{{ route('admin.gallery.edit', ['id' => $item->id]) }}">
								{{ $item->user_id }}
							</a>
						@endcan
						@cannot('admin.gallery.edit', $item)
							<strong>{{ $item->user_id }}</strong>
						@endcannot
					</td>
					<td class="text-center">
						{{ $item->total_g }}
					</td>
					<td class="text-center">
						{{ $item->total_m }}
					</td>
					<td class="text-center">
						{{ $item->lv_name }}
					</td>
					<td class="text-center">
						{{ $item->updated_at->diffForHumans() }}
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
	                            	<li><a href="{{ route('gallery.show', ['user_id' => $item->user_id, 'id' => $item->id]) }}"><i class="fa fa-eye"></i> @lang('cms.view')</a></li>
	                            	<li role="presentation" class="divider"></li>
	                            @endif
	                        </ul>
	                    </div>
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection