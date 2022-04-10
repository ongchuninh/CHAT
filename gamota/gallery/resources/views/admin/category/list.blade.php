@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['gallery', 'gallery.category'],
	'breadcrumbs'		=>	[
		'title' => [trans('gallery.gallery'), trans('gallery.category.category')],
		'url'	=> [
			route('admin.gallery.index'),
		],
	],	
])

@section('page_title', trans('gallery.gallery-category'))

@section('tool_bar')
	@can('admin.gallery.category.create')
		<a href="{{ route('admin.gallery.category.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('gallery.category.add-new-category')</span>
		</a>
	@endcan
@endsection

@section('content')

	@component('Cms::components.table-function', [
		'total' => $categories->total(),
		'bulkactions' => [
			['action' => 'admin/gallery/category/appplyStatus/destroy', 'name' => trans('cms.destroy'), 'method' => 'DELETE'],
		],
	])
		@slot('heading')
			<th width="50" class="table-checkbox text-center">
				{!! Form::icheck(null, null, ['class' => 'check-all']) !!}
			</th>
			<th class="text-center">
				{!! \Gamota\Gallery\Category::linkSort(trans('gallery.category.id'), 'id') !!}
			</th>
			<th>Thumbnail</th>
			<th>
				{!! \Gamota\Gallery\Category::linkSort(trans('gallery.category.title'), 'title') !!}
			</th>
			<th>
				{!! \Gamota\Gallery\Category::linkSort(trans('gallery.category.date_update'), 'updated_at') !!}
			</th>
			<th></th>
			
		@endslot

		@slot('data')
			@include('Gallery::admin.components.category-table-item', [
				'categories' => $categories,
			])
		@endslot
	@endcomponent
@endsection
