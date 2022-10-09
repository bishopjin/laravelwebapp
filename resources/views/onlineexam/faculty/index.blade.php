 @extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" 
                style="margin-bottom : -15px;">
                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link border border-bottom-0 rounded py-3 bg-primary text-light px-5">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subjectexam.index') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Subject') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('exam.index') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body p-md-4">

                    <div class="card border-warning mb-3">
                        <div class="card-header border-bottom border-warning">
                            {{ __('Student List') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                {{ __('Student Name') }}
                                            </th>
                                            <th>
                                                {{ __('Course') }}
                                            </th>
                                            <th>
                                                {{ __('Gender') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($studentList as $student)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('facultyexam.show', $student->user_id) }}" 
                                                        class="text-decoration-none fw-bold">
                                                        {{ $student->student->full_name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $student->student->onlinecourse->course }}
                                                </td>
                                                <td>
                                                    {{ $student->student->gender->gender }}
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
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
                        <div class="card-header border-bottom border-warning">
                            {{ __('Examination List') }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                {{ __('Examination Code') }}
                                            </th>
                                            <th>
                                                {{ __('Subject') }}
                                            </th>
                                            <th>
                                                {{ __('Timer(in minutes)') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($examList as $exam)
                                            <tr>
                                                <td>
                                                    {{ $exam->exam_code }}
                                                </td>
                                                <td>
                                                    {{ $exam->onlinesubject->subject }}
                                                </td>
                                                <td>
                                                    {{ $exam->timer }}
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    @isset($examList)
                                        {{ $examList->links() }}
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
@endsection
