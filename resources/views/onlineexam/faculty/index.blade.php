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
                        <a href="{{ route('exam.create') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body p-md-4 d-grid gap-3">
                    @php
                        $newTableData = [];

                        if(isset($studentList)) {
                            foreach($studentList as $student) {
                                $newRow = array(
                                    'id' => $student->user_id,
                                    'name' => $student->student->full_name,
                                    'gender' => $student->student->gender->gender,
                                    'course' => $student->student->onlinecourse->course
                                );
                            
                                array_push($newTableData, $newRow);
                            }
                        }
                    @endphp

                    <x-datatable 
                        :data="$studentList" 
                        :newTableData="$newTableData"
                        title="Student List" 
                        :header="['Student Name', 'Course', 'Gender']" 
                        :tData="['name', 'course', 'gender']"
                        :hasViewButton="true"
                        viewLink="facultyexam.show"
                    ></x-datatable>

                    @php
                        $newTableData2 = [];

                        if(isset($examList)) {
                            foreach($examList as $exam) {
                                $newRow2 = array(
                                    'id' => $exam->id,
                                    'examcode' => $exam->exam_code,
                                    'subject' => $exam->onlinesubject->subject,
                                    'timer' => $exam->timer
                                );
                            
                                array_push($newTableData2, $newRow2);
                            }
                        }
                    @endphp

                    <x-datatable 
                        :data="$examList" 
                        :newTableData="$newTableData2"
                        title="Examination List" 
                        :header="['Examination Code', 'Subject', 'Timer(in minutes)']" 
                        :tData="['examcode', 'subject', 'timer']"
                        :hasViewButton="true"
                        viewLink="exam.show"
                        :hasEditButton="true"
                        editLink="exam.edit"
                    ></x-datatable>

                </div>
                <div class="card-footer bg-primary">
                    <div class="container">
                        <x-footerexam color="text-light"></x-footerexam>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
