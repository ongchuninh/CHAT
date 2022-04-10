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

		@slot('export')
			<form action="{!! route('admin.event.membership.export') !!}" class="form-horizontal form-bordered form-row-stripped">
	            <div class="form-actions util-btn-margin-bottom-5">
	                <div class="row">
	                    <div class="col-md-12 text-right">
	                    	<button type="submit" class="btn btn-info full-width-xs">
	                    		<i class="fa fa-cloud-download"></i> Export
	                    	</button>
	                    </div>
	                </div>
	            </div>
	        </form>
		@endslot

		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th width="50" class="text-center">
				{!! \Gamota\Event\Membership::linkSort(trans('member.id'), 'id') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Event\Membership::linkSort(trans('membership.user_id'), 'user_id') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.total_g') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.total_m') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.lv_name') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.server_id') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.role_id') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.role_name') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.fullname') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.email') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.phone') !!}
			</th>

			<th class="text-center">
				{!! trans('membership.address') !!}
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
						{{ $item->id }}
					</td>
					<td class="text-center">
						{{ $item->user_id }}
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
						{{ $item->server_id }}
					</td>
					<td class="text-center">
						{{ $item->role_id }}
					</td>
					<td class="text-center">
						{{ $item->role_name }}
					</td>
					<td class="text-center">
						{{ $item->fullname }}
					</td>
					<td class="text-center">
						{{ $item->email }}
					</td>
					<td class="text-center">
						{{ $item->phone }}
					</td>
					<td class="text-center">
						{{ $item->address }}
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