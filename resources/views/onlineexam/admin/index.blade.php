@extends('layouts.app')

@section('content')
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
                        <a href="{{ route('course.show') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
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
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Course</th>
                                        <th>User Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($result)
                                        @foreach($result as $index => $user)
                                            @if(($user->access_level === 'Student' AND isset($user->course)) OR $user->access_level === 'Faculty')
                                                @php
                                                    if($index === 0)
                                                    {
                                                        $index+=1;
                                                    }
                                                    else { $index++; }
                                                @endphp
                                                <tr>
                                                    <td>{{ $index }}</td>
                                                    <td>{{ $user->lastname }}, {{ $user->firstname }} {{ $user->middlename }}</td>
                                                    <td>{{ $user->gender }}</td>
                                                    <td>{{ $user->course ?? 'None' }}</td>
                                                    <td>{{ $user->access_level }}</td>
                                                    <td>
                                                        <form method="POST" action="{{ route('user.delete') }}">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <input type="hidden" name="access_level" value="{{ $user->access_level }}">
                                                            <input type="hidden" name="isactive" value="{{ $user->isactive }}">
                                                            <input type="submit" value="@if($user->isactive) Disable Account @else Enable Account @endif" 
                                                                class="btn @if($user->isactive) btn-outline-danger @else btn-outline-success @endif">
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                @isset($result)
                                    {{ $result->links() }}
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
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($subject_list)
                                        @foreach($subject_list as $index => $subject)
                                            @php
                                                if($index === 0)
                                                {
                                                    $index+=1;
                                                }
                                                else { $index++; }
                                                $subjectID = 'subject'.$subject->id;
                                            @endphp
                                            <tr>
                                                <td>{{ $index }}</td>
                                                <td id="{{ $subjectID }}">{{ $subject->subject }}</td>
                                                <td>{{ $subject->lastname }}, {{ $subject->firstname }} {{ $subject->middlename }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-outline-success editSubject" id="{{ $subject->id }}">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                @isset($subject_list)
                                    {{ $subject_list->links() }}
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
                <footer></footer>
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
                    <form method="POST" action="{{ route('subject.edit') }}" class="p-md-4">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" name="subject" id="subjectname" class="form-control" autocomplete="off">
                            <input type="hidden" name="subject_id" id="editID">
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
            $('#editID').val(this.id);
            $('#subjectname').val($('#subject' + this.id).html());
        });
    });
</script>
@endsection
