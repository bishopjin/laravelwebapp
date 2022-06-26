@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bolder">{{ __('Edit Access Level') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('inventory.employee.save.access') }}" class="px-md-5">
                        @csrf
                        @foreach($user_details as $details)
                            <div class="form-group pb-3">
                                <label>User ID</label>
                                <input type="text" name="user_id" value="{{ $details->id }}" class="form-control" readonly="">
                            </div>
                            <div class="form-group pb-3">
                                <label>Name</label>
                                <input type="text" value="{{ $details->userprofile->full_name}}" class="form-control" readonly="">
                            </div>
                            <div class="form-group pb-3">
                                <label>Access Level</label>
                                <select class="form-select @error('access_level') is-invalid @enderror" name="access_level" required>
                                    @foreach($access_level as $level)
                                        @if($details->access_level === $level->id)
                                            <option value="{{ $level->id }}" selected="">{{ $level->user_type }}</option>
                                        @else
                                            <option value="{{ $level->id }}">{{ $level->user_type }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('access_level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endforeach
                        
                        <div class="form-group d-flex justify-content-between flex-row py-2">
                            <a href="{{ route('inventory.employee.edit') }}" class="btn btn-outline-info px-5">Back</a>
                            <input type="submit" class="btn btn-outline-primary px-5" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection