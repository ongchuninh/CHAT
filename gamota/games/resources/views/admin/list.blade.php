
@extends('Cms::layouts.default', [
	'active_admin_menu'	=> ['games', 'games.all'],
	'breadcrumbs' 		=> [
		'title'	=>	['Game', 'Danh sách game'],
		'url'	=>	[
			route('admin.game.index'),
		],
	],
])

@section('page_title', 'Danh sách game')
@push('css')
	<style>
		.form-update{
			display: inline-block;
		}
	</style>	
@endpush

@section('tool_bar')
	@can('admin.games.create')
		<a href="{{ route('admin.game.create') }}" class="btn btn-primary">
			<i class="fa fa-plus"></i> <span class="hidden-xs">Thêm mới</span>
		</a>
	@endcan
	{!! Form::ajax(['url' => route('admin.games.updateGame'), 'class' => 'form-horizontal form-bordered form-row-stripped form-update', 'method' => 'POST']) !!}
	<button type="submit"  class="btn btn-primary">
		<i class="fa fa-plus"></i> <span class="hidden-xs">Cập nhật Game</span>
	</button>
	{!! Form::close() !!}
@endsection

@section('content')
	@component('Cms::components.table-function', [
		'total' => $games->total(),
		'paginate' => $games->appends($filter)->render(),
		'bulkactions' => [
			
			['action' => 'admin/game/appply/destroy', 'name' => trans('cms.destroy'), 'method' => 'DELETE'],
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
			<div class="col-sm-6 md-pl-0">
				<div class="form-group">
					<label class="control-label col-md-3">@lang('news.status')</label>
					<div class="col-md-9">
						{!! Form::select('status', \Gamota\Games\Game::statusable()->mapWithKeys(function ($item) {
							return [$item['slug'] => $item['name']];
						})->all(), isset($filter['status']) ? $filter['status'] : NULL, ['class' => 'form-control', 'placeholder' => '']) !!}
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
				{{ 'Tên game' }}
			</th>

			<th class="text-center">
				{{ 'Ảnh đại diện' }}
			</th>

			<th class="text-center">
				{{ 'Icon game' }}
			</th>

			<th>
				{{ 'Hiển thị trang chủ' }}
			</th>

			<th>
				{{ 'Trạng thái' }}
			</th>
			
			<th>
				{{ 'Cập nhật' }}
			</th>
			<th></th>
		@endslot

		@slot('data')
			@foreach($games as $value)
				<tr class="odd gradeX hover-display-container {{ $value->html_class }}">
					<td width="50" class="table-checkbox text-center">
						{!! Form::icheck('id', $value->id) !!}
					</td>
					<td class="text-center">
						<strong>{{ $value->id }}</strong>
					</td >
					<td class="text-center">
						@can('admin.games.edit', $value)
							<a href="{{ route('admin.game.edit', ['id' => $value->id]) }}">
								<strong>{{ $value->getInfoLanguage($lan->id)->name }}</strong>
							</a>
						@endcan
						@cannot('admin.games.edit', $value)
							<strong>{{ $value->getInfoLanguage($lan->id)->name }}</strong>
						@endcannot
					</td>
					

					<td class="text-center">
						<img src="{{ $value->thumbnail }}" width="100" />
						
					</td>
					<td class="text-center">
						<img src="{{ $value->icon }}" width="100" />
					</td>

					<td>
						{{ ($value->display == 0)?"Không":"Có"  }}
					</td>

					<td>
						{{ ($value->status == 0)?"InActive":"Active"  }}
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
	                            
	                            @can('admin.games.edit', $value)
		                            <li><a href="{{ route('admin.game.edit',['id' => $value->id]) }}"><i class="fa fa-pencil"></i> @lang('cms.edit')</a></li>
		                            <li role="presentation" class="divider"></li>
		                        @endcan
	                        	
	                        	

	                            
	                        </ul>
							
						</div>
					</td>
				</tr>
			@endforeach
		@endslot
		
	@endcomponent
@endsection