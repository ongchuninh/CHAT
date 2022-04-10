@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['promise', 'promise.index'],
	'breadcrumbs' 		=> [
		'title'	=>	[trans('promise.promise'), trans('promise.list')],
		'url'	=>	[
			route('admin.promise.index'),
		],
	],
])

@section('promise_title', trans('promise.list-promise'))

@section('content')
	@component('Cms::components.table-function', [
		'total' => $promise->total(),
		'paginate' => $promise->appends($filter)->render(),
	])
		@slot('filter')
			<div class="row">
                <div class="col-sm-6 md-pr-0">
					<div class="form-group">
	                    <label class="control-label col-md-3">@lang('promise.email')</label>
	                    <div class="col-md-9">
							<input type="text" class="form-control" name="email" value="{{ $filter['email'] or '' }}" />
						</div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3">@lang('promise.phone')</label>
                        <div class="col-md-9">
							<input type="text" class="form-control" name="phone" value="{{ $filter['phone'] or '' }}" />
                        </div>
					</div>
                </div>
            </div>
		@endslot

		@slot('heading')
			<th width="50" class="text-center">
				{!! \Gamota\Promise\Promise::linkSort(trans('promise.id'), 'id') !!}
			</th>
			<th>
				{!! \Gamota\Promise\Promise::linkSort(trans('promise.email'), 'email') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Promise\Promise::linkSort(trans('promise.phone'), 'phone') !!}
			</th>
			<th>
				{!! \Gamota\Promise\Promise::linkSort(trans('promise.is_send'), 'is_send') !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Promise\Promise::linkSort('ip', 'ip') !!}
			</th>
			<th>
				{!! \Gamota\Promise\Promise::linkSort('gift_code', 'gift_code') !!}
			</th>
			<th class="text-center">{!! \Gamota\Promise\Promise::linkSort(trans('promise.updated_at'), 'updated_at') !!}</th>
		@endslot

		@slot('data')
			@foreach($promise as $promise_item)
				<tr class="odd gradeX hover-display-container {{ $promise_item->html_class }}">
					<td class="text-center">
						<strong>{{ $promise_item->id }}</strong>
					</td>
					<td>
						<strong>{{ $promise_item->email }}</strong>
					</td>
					<td class="text-center">
						<strong>{{ $promise_item->phone }}</strong>
					</td>
					<td>
						<strong>{{ $promise_item->is_send ? 'Đã gửi' : 'Chưa gửi'}}</strong>
					</td>
					<td class="text-center">
						<strong>{{ $promise_item->ip }}</strong>
					</td>
					<td>
						<strong>{{ $promise_item->gift_code }}</strong>
					</td>
					<td class="text-center">
						{{ $promise_item->updated_at->diffForHumans() }}
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection
