@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link border border-bottom-0 rounded py-3 bg-primary text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('courseexam.index') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Course') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body d-grid gap-3">
                    <div class="card border-warning">
                        <div class="card-header border-bottom border-warning">{{ __('User List') }}</div>
                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Course</th>
                                        <th>User Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($users)
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->full_name }}</td>
                                                <td>{{ $user->gender->gender }}</td>
                                                <td>{{ $user->onlinecourse->course }}</td>
                                                <td>{{ __('For standalone system only') }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('adminexam.destroy', ['adminexam' => $user->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="@if($user->trashed()) Enable Account @else Disable Account @endif" 
                                                            class="btn @if($user->trashed()) btn-outline-success @else btn-outline-danger @endif">
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                @isset($users)
                                    {{ $users->links() }}
                                @endisset
                            </div>
                        </div>
                    </div>

                    <div class="card border-warning">
                        <div class="card-header border-bottom border-warning">{{ __('Subject List') }}</div>
                        <div class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($subjects)
                                        @foreach($subjects as $subject)
                                            @php
                                                $subjectID = 'subject'.$subject->id;
                                            @endphp
                                            <tr>
                                                <td id="{{ $subjectID }}">{{ $subject->subject }}</td>
                                                <td>{{ $subject->user->full_name }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-outline-success editSubject" id="{{ $subject->id }}">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                @isset($subjects)
                                    {{ $subjects->links() }}
                                @endisset
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
                    <span class="text-light">{{ __('Edit Subject') }}</span>
                    <a href="javascript:void(0);" id="closeDialog" class="ms-auto">
                        <i class="fa fa-times fa-lg text-light" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <form method="POST" class="p-md-4" id="modalForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <input type="text" name="subject" id="subjectname" class="form-control" autocomplete="off">
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

        $('.editSubject').on('click', function() {
            $(modal).show();
            $('#modalForm').attr("action", "/online-exam/adminexam/" + this.id);
            $('#subjectname').val($('#subject' + this.id).html());
        });
    });
</script>
@endsection
