<div class="fw-bold h5">
	@php
		$title = $name ?? null;
		$rolename = $name ?? '';
	@endphp
	{{ $title != null ? $title.'\'s role permissions' : '' }}
</div>
@isset($permissions)
	<form method="POST" action="{{ route('roles.permission.update') }}">
		@csrf
		@method('PUT')

	    @foreach($permissions as $permission)
    		@php
    			$match = false;
    			foreach($rolepermissions as $roleprm)
    			{
    				if ($roleprm->id == $permission->id)
    				{
    					$match = true;
    					break;
    				}
    			}
    		@endphp
	        <div class="form-group pb-2">
	            <input type="checkbox" name="permission[]" id="{{ $permission->name }}" value="{{ $permission->name }}" 
	            	class="form-check-input" {{ $match ? 'checked' : '' }}>
	            <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
	        </div>
	    @endforeach
	    <div class="form-group">
	    	<input type="hidden" name="rolename" value="{{ $rolename }}">
	    	<input type="submit" class="btn btn-primary" value="Save">
	    </div>
	</form>
@endisset