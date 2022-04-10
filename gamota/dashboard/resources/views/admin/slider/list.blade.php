@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['slider', 'slider.all'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('slider.slider'), trans('slider.list')],
		'url'	=> [
			route('admin.slider.show_all')
		],
	],
])

@section('page_title', 'Danh sach Slider')
@section('tool_bar')
	@can('admin.slider.create')
		<a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Add slider</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'bulkactions' => [
			['action' => '', 'name' => ''],
			['action' => '', 'name' => ''],
			['action' => '', 'name' => ''],
		],
	])
		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th class="text-center">
				Id
			</th>
			<th class="text-center">
				Title
			</th>
			<th class="text-center">
				Image
			</th>
			<th class="text-center">
				Link
			</th>
			<th class="text-center">
				Status
			</th>
		@endslot
		@slot('data')
			@foreach($sliders as $slider_item)
				<tr class="hover-display-container">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $slider_item->id, ['class' => 'check-all']) !!}
					</td>
					<td class="text-center hidden-xs"><strong>{{ $slider_item->id }}</strong></td>
					<td class="text-center hidden-xs"><strong>{{ $slider_item->title }}</strong></td>
					<td class="text-center hidden-xs"><strong>{{ $slider_item->image}}</strong></td>
					<td class="text-center hidden-xs"><strong>{{ $slider_item->link }}</strong></td>
					<td class="text-center hidden-xs"><strong>{{ $slider_item->status }}</strong></td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@endsection