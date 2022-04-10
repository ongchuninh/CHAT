<select name="{{ $name }}" id="select2-button-addons-single-input-group-sm" class="form-control find-user">
     @if(isset($selected) && $selected)
        <option value="{{ $selected }}" selected>{{ Gamota\Dashboar\User::select('id', 'first_name', 'last_name')->find($selected)->full_name }}</option>
    @endif
</select>

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/select2/css/select2.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/select2/css/select2-bootstrap.min.css') }}" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/select2/js/select2.full.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset_url('user', 'js/form-find-user.js') }}"></script>
	<script type="text/javascript">
		$(function(){
			var user = new findUser({
				el: '.find-user',
				url: '{{ route('api.user.index') }}',
				defaultAvatar: '{{ setting('default-avatar') }}',
				placeholder: '@lang('cms.search')',
			});
		});
	</script>
@endpush