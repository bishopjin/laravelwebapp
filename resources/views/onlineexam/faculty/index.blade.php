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
                        <a href="{{ route('online.subject.show') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Subject') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('online.exam.show') }}" class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body p-md-4">

                    <div class="card border-warning mb-3">
                        <div class="card-header border-bottom border-warning">{{ __('Student List') }}</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Student Name') }}</th>
                                            <th>{{ __('Gender') }}</th>
                                            <th>{{ __('Course') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($student_list)
                                            @php  
                                                $current_id = 0; $course = null; $gender = null;
                                            @endphp

                                            @foreach($student_list as $student)
                                                @if(!$course && !$gender)
                                                    @php
                                                        foreach($studentProfile as $profile) {
                                                            $course = $profile->onlinecourse->course;
                                                            $gender = $profile->gender->gender;
                                                            break;
                                                        }
                                                    @endphp
                                                @endif

                                                @if($current_id === 0 OR $current_id !== $student->user_id)
                                                    @php
                                                        $current_id = $student->user_id;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('online.faculty.show.student.score', $student->user_id) }}" class="text-decoration-none fw-bold">
                                                                {{ $student->userprofile->lastname }}, &nbsp;
                                                                {{ $student->userprofile->firstname }} {{ $student->userprofile->middlename }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $gender }}</td>
                                                        <td>{{ $course }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    @isset($student_list)
                                        {{ $student_list->links() }}
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-warning">
                        <div class="card-header border-bottom border-warning">{{ __('Examination List') }}</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Examination Code') }}</th>
                                            <th>{{ __('Subject') }}</th>
                                            <th>{{ __('Timer(in minutes)') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($exam_list)
                                            @foreach($exam_list as $exam)
                                                <tr>
                                                    <td>{{ $exam->exam_code }}</td>
                                                    <td class="text-center">{{ $exam->subject }}</td>
                                                    <td class="text-center">{{ $exam->timer }}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    @isset($exam_list)
                                        {{ $exam_list->links() }}
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <x-footer></x-footer>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
