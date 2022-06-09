@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="{{ route('online.admin.index') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link border border-bottom-0 rounded py-3 bg-primary text-light px-5">
                            {{ __('Course') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary text-light py-4"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <form method="POST" action="{{ route('online.course.save') }}">
                                @csrf
                                <div class="row mb-3 justify-content-center">
                                    <div class="col">
                                        <div class="card border-warning">
                                            <div class="card-header border-bottom border-warning">{{ __('New Course') }}</div>
                                            <div class="card-body">
                                                <div class="form-group py-2">
                                                    <label for="course" class="mb-2">{{ __('Course') }}</label>
                                                    <input id="course" type="text" class="form-control @error('course') is-invalid @enderror" name="course" value="{{ old('course') }}" required autofocus>

                                                    @error('course')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-outline-primary">
                                                        {{ __('Save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>        
                        <div class="col-md-8">
                            <div class="fs-5 fw-bold">{{ __('Course List') }}</div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Course') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($course_list)
                                            @foreach($course_list as $course)
                                                @php
                                                    $courseID = 'course'.$course->id;
                                                @endphp
                                                <tr>
                                                    <td id="{{ $courseID }}">{{ $course->course }}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="btn btn-outline-success editCourse" id="{{ $course->id }}">{{ __('Edit') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    @isset($course_list)
                                        {{ $course_list->links() }}
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <div class="container">
                        <x-footerexam :color="'text-light'"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal/overlay -->
<div class="modal pt-5">
    <div class="modal-dialog">
        <div class="modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary"> 
                    <span class="text-light">{{ __('Edit Course') }}</span>
                    <a href="javascript:void(0);" id="closeDialog" class="ms-auto">
                        <i class="fa fa-times fa-lg text-light" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('online.course.edit') }}" class="p-md-4">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" name="course" id="coursename" class="form-control" autocomplete="off">
                            <input type="hidden" name="course_id" id="editID">
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-end">
                                <input type="submit" value="Save" class="btn btn-outline-primary">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-primary text-light">
                    {{ __('Laravel') }} {{ app()->version() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var modal = $('.modal');
        
        $('#closeDialog').on('click', function(){
            $(modal).hide();
        });

        $('.editCourse').on('click', function() {
            $(modal).show();
            $('#editID').val(this.id);
            $('#coursename').val($('#course' + this.id).html());
        });
    });
</script>
@endsection
