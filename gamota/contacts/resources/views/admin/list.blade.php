
@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['contacts', 'contacts.all'],
	'breadcrumbs' 		=> [
		'title'	=>	['Liên hệ', 'Danh sách liên hệ'],
		'url'	=>	[
			route('admin.contact.index'),
		],
	],
])

@section('page_title', 'Danh sách game')



@section('content')
	@component('Cms::components.table-function', [
		'total' => $contacts->total(),
		'paginate' => $contacts->appends($filter)->render(),
		'bulkactions' => [
			
			
		],
	])

		@slot('filter')
			<div class="row">
				<div class="col-sm-6 md-pr-0">
					<div class="form-group">
						<label class="control-label col-md-3">@lang('cms.search')</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="name" value="{{ $filter['name'] or '' }}" />
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
				{{ 'id' }}
			</th>
			<th class="text-center">
				{{ 'Họ tên' }}
			</th>

			<th class="text-center">
				{{ 'Email' }}
			</th>	
			<th class="text-center">
				{{ 'Chủ đề' }}
			</th>		
			<th>
				{{ 'Thời gian' }}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($contacts as $value)
				<tr class="odd gradeX hover-display-container {{ $value->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $value->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $value->id }}</strong>
					</td >
					<td class="text-center">
						<strong>{{ $value->name}}</strong>
					</td>
					

					<td class="text-center">
						{{ $value->email }}
						
					</td>
					<td class="text-center">
						{{ $value->subject }} 
					</td>

					

					<td>
						{{ ( isset($value->updated_at) ? $value->updated_at->diffForHumans() : '' )  }}
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
	                            
								<li><a href="{{ route('admin.contact.detail',['contact'=>$value->id]) }}"><i class="fa fa-pencil"></i>Chi tiết</a></li>
								<li role="presentation" class="divider"></li>

	                        </ul>
							
						</div>
					</td>
				</tr>
			@endforeach
		@endslot
		
	@endcomponent
@endsection