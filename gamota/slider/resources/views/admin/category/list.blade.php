@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['slider', 'slider.category'],
	'breadcrumbs'		=>	[
		'title' => [trans('slider.slider'), trans('slider.category.category')],
		'url'	=> [
			route('admin.slider.index'),
		],
	],	
])

@section('page_title', trans('slider.slider-category'))

@section('tool_bar')
	@can('admin.slider.category.create')
		<a href="{{ route('admin.slider.category.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('slider.category.add-new-category')</span>
		</a>
	@endcan
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' => $categories->total(),
		'bulkactions' => [
			['action' => '', 'name' => trans('cms.destroy'), 'method' => 'DELETE'],
		],
	])
		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Slider\Category::linkSort(trans('slider.category.id'), 'id') !!}
			</th>
			<th>Thumbnail</th>
			<th>
				{!! \Gamota\Slider\Category::linkSort(trans('slider.category.title'), 'title') !!}
			</th>
			<th>
				{!! \Gamota\Slider\Category::linkSort(trans('slider.category.date_update'), 'updated_at') !!}
			</th>
			<th></th>
			
		@endslot

		@slot('data')
			@include('Slider::admin.components.category-table-item', [
				'categories' => $categories,
			])
		@endslot
	@endcomponent
@endsection
