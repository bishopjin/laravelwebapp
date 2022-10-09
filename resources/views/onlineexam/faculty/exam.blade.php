@extends('onlineexam.layouts.app')

@section('onlinecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="navbar d-none d-md-block" 
                style="margin-bottom : -15px;">

                <ul class="navbar-nav d-flex flex-row gap-1 border-0">
                    <li class="nav-item">
                        <a href="{{ route('facultyexam.index') }}" 
                            class="nav-link border border-bottom-0 rounded py-3 text-light px-5">
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
                        <a href="#" 
                            class="nav-link border border-bottom-0 text-light bg-primary rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            {{-- Generate form --}}
                            <div id="examSettings">
                                <div class="card border border-warning">
                                    <div class="card-header border-bottom border-warning">
                                        {{ __('Create Examination Form') }}
                                    </div>
                                    <div class="card-body m-md-2">
                                        <p class="small fw-bold">
                                            <span>
                                                {{ __('Instruction:') }}
                                            </span>
                                            <br>
                                            {{ __('Provide the needed information, all field are required.') }}
                                            <br>
                                            {{ __('Number of Question - examination total number of question') }}
                                            <br>
                                            {{ __('Number of selection per question - the choices for each question.') }}
                                        </p>
                                        <hr>
                                        <div class="form-group d-grid gap-2 pb-3">
                                            <label>
                                                {{ __('Number of Question') }}
                                            </label>
                                            <input type="number" 
                                                id="numberofquestion" 
                                                class="form-control">    
                                            <span id="nqwarning" 
                                                class="text-danger small fw-bold">
                                            </span>
                                        </div>
                                        <div class="form-group d-grid gap-2">
                                            <label>
                                                {{ __('Number of selection per question') }}
                                            </label>
                                            <input type="number" 
                                                id="numberofselection" 
                                                class="form-control">
                                            <span id="nswarning" 
                                                class="text-danger small fw-bold">
                                            </span>
                                        </div>
                                        <div class="form-group pt-3 d-flex justify-content-end">
                                            <button type="button" 
                                                class="btn btn-outline-primary" 
                                                id="createFormBtn">
                                                {{ __('Create') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Generated form --}}
                            <div id="examGeneratedForm">
                                <div class="card border-warning">
                                    <div class="card-header border-bottom border-warning">
                                        {{ __('New Examination') }}
                                    </div>
                                    <div class="card-body">
                                        <p class="small fw-bold">
                                            <span class="fs-5">
                                                {{ __('Instruction:') }}
                                            </span>
                                            <br/>
                                            {{ __('Select a subject to generate examination code then provide all the needed information. All field are required.') }}
                                            <br/><br>
                                            {{ __('Examination Code - Access code for the student to take the exam.') }}
                                            <br>
                                            {{ __('Exam Question - Question that are need to answer by the student.') }} 
                                            <br/>
                                            {{ __('Correct answer - Correct answer for the question of the same number.') }} 
                                            <br/>
                                            {{ __('Selection - Choices for the question above it.') }}
                                        </p>
                                        <hr>
                                        <form method="POST" 
                                            action="{{ route('exam.store') }}">

                                            @csrf
                                            <div class="form-group pb-4">
                                                <div class="row">
                                                    <div class="col-md-8 d-grid gap-2">
                                                        <label>
                                                            {{ __('Subjects') }}
                                                        </label>
                                                        <select class="form-select" 
                                                            name="online_subject_id" 
                                                            id="subjectSel">

                                                            @forelse($subjects as $subject)
                                                                <option value="{{ $subject->id }}">
                                                                    {{ $subject->subject }}
                                                                </option>
                                                            @empty
                                                                <option></option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 d-grid gap-2">
                                                        <label>
                                                            {{ __('Timer(in minutes)') }}
                                                        </label>
                                                        <input type="number" 
                                                            name="timer" 
                                                            class="form-control" 
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="questionContainer"></div> 
                                            <div class="form-group pt-3 d-flex justify-content-between">
                                                <button type="button" 
                                                    class="btn btn-outline-success px-5" 
                                                    id="resetFormBtn">
                                                    {{ __('Reset') }}
                                                </button>

                                                <input type="submit" 
                                                    value="Save" 
                                                    class="btn btn-outline-primary px-5">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="card border-warning">
                                <div class="card-header d-flex justify-content-between border-bottom border-warning">
                                    <span>
                                        {{ __('Exam Preview') }}
                                    </span>
                                    <span>
                                        @if(\Session::has('exam_status'))
                                            {{ session('exam_status') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="card-body">
                                    <form method="GET" 
                                        id="examCodeForm">
                                        <div class="form-group">
                                            <label for="exam_code">
                                                {{ __('Examination Code') }}
                                            </label>
                                            <div class="d-flex flex-column flex-md-row">
                                                <input type="text" 
                                                    name="exam_code" 
                                                    id="exam_code" 
                                                    class="form-control me-2" 
                                                    value="@isset($examCode) {{ $examCode }} @endisset">

                                                <input type="button" 
                                                    value="View" 
                                                    class="btn btn-outline-success px-md-4 d-none" 
                                                    id="submitBtn">
                                            </div>
                                        </div>
                                    </form>

                                    @isset($examQuestions)
                                        <div class="fw-bold pt-2">
                                            {{ __('Note:') }}
                                        </div>
                                        <p class="small fw-bold">
                                            {{ __('To change the correct answer, change the value of the correct answer field below each question and click update.') }}
                                            <br>
                                            {{ __('"Correct Answer" must be the same as any of the selection, it is case sensitive for letter.') }}
                                        </p>
                                    @endisset
                                    <hr>
                                    @if(!isset($examQuestions))
                                        <div class="text-center fw-bold">
                                            {{ __('Invalid Examination Code') }}
                                        </div>
                                    @endif

                                    @isset($exams)
                                        @isset($examQuestions)
                                            @php 
                                                $qNum = 0; 
                                            @endphp

                                            @foreach($examQuestions as $question)
                                                @php 
                                                    $qNum++; 
                                                    $selNum = 0;
                                                    $newAnswerId = 'answer_'.$question->id;
                                                @endphp

                                                <div class="fw-bold">
                                                    {{ $qNum }}. {{ $question->question }}
                                                </div>

                                                {{-- key answer --}}
                                                <form class="pt-1 pb-3 ps-4">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>
                                                            {{ __('Correct Answer') }}
                                                        </label>
                                                        <div class="d-flex flex-row gap-2">
                                                            <input type="text" 
                                                                value="{{ $question->key_to_correct }}" 
                                                                class="form-control corAns" 
                                                                id="{{ $newAnswerId }}" 
                                                                required>

                                                            <button type="button" 
                                                                class="btn btn-outline-success updateAnswer" 
                                                                id="{{ $question->id }}">
                                                                {{ __('Update') }}
                                                            </button>
                                                        </div>
                                                    </div>  
                                                </form>
                                            @endforeach
                                        @endisset
                                    @endisset
                                </div>
                                <div class="card-footer border-top border-warning">
                                    {{ __('End of Examination Form') }}
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

<div class="modal pt-5">
    <div class="modal-dialog">
        <div class="modal-dialog-centered">
            <div class="modal-content border border-warning">
                <div class="modal-header border-bottom border-warning p-2">
                    <span class="text-success fw-bold fs-5">
                        {{ __('Success') }}
                    </span>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center py-2 fs-4 fw-bold">
                        {{ __('Update successfully') }}
                    </div>
                </div>
                <div class="modal-footer border-top border-warning d-flex justify-content-center py-2">
                    <button type="button" 
                        id="closeDialog" 
                        class="btn btn-outline-success px-4">
                        {{ __('Ok') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var examGeneratedForm = $('#examGeneratedForm'),
            examSettings = $('#examSettings'),
            numberofquestion = $('#numberofquestion'),
            numberofselection = $('#numberofselection'),
            createFormBtn = $('#createFormBtn'),
            resetFormBtn = $('#resetFormBtn'),
            questionContainer = $('#questionContainer'),
            nqwarning = $('#nqwarning'),
            nswarning = $('#nswarning'),
            submitBtn = $('#submitBtn'),
            examcode = $('#exam_code');

        $(examGeneratedForm).hide();

        $(resetFormBtn).on('click', function(){
            $(questionContainer).empty();
            $(examGeneratedForm).hide();
            $(examSettings).show();
        });

        $(exam_code).on('keyup', function () {
             $(this).val() != '' ? $(submitBtn).removeClass('d-none').show() : $(submitBtn).hide();
        });

        $(submitBtn).on('click', function() {
            $('#examCodeForm').attr('action', '/online-exam/exam/' + $(examcode).val()).submit();
        });

        $(createFormBtn).on('click', function(){
            let formValid = true;
            $(nswarning).html('');
            $(nqwarning).html('');

            if (!$(numberofquestion).val() || $(numberofquestion).val() < 1) {
                $(nqwarning).html('Invalid number of question.');
                formValid = false;
            }
            if (!$(numberofselection).val() || $(numberofselection).val() < 1) {
                $(nswarning).html('Invalid number of selection.');
                formValid = false;
            }

            if (formValid) {
                $(examGeneratedForm).show();
                $(examSettings).hide();

                for (var i = 0; i < parseInt($(numberofquestion).val()); i++) {
                    $(questionContainer).append(`<div class="form-group d-grid gap-2">
                                                    <label>
                                                        Exam Question ${i + 1}
                                                    </label>
                                                    <input type="text" 
                                                        name="question[]" 
                                                        class="form-control" 
                                                        required/>
                                                    <label>
                                                        Correct answer for question ${i + 1}
                                                    </label>
                                                    <input type="text" 
                                                        name="answer[]" 
                                                        class="form-control" 
                                                        required/>
                                                    <div class="form-group ps-3" 
                                                        id="selectionContainer_${i}">
                                                    </div>  
                                                </div>
                                                <hr class="bg-dark"/>`);

                    for (var j = 0; j < parseInt($(numberofselection).val()); j++) {
                        $('#selectionContainer_' + i).append(`<label>
                                Selection ${j + 1} for question ${i + 1}
                            </label>
                            <input type="text" 
                                name="selection[${i}][${j}]" 
                                class="form-control" 
                                required/>`);
                    }
                }
            }
        });

        $('.corAns').on('keyup', function () {
            $(this).removeClass('is-invalid');
        });

        $('#closeDialog').on('click', function () {
            $('.modal').hide();
        });

        $('.updateAnswer').on('click', function () {
            var eleId = this.id;
            var ans = $('#answer_' + eleId);

            if (!$(ans).val()) { 
                $(ans).addClass('is-invalid').focus();
            }
            else {
                $.ajax({
                    url: '/online-exam/exam/' + eleId,
                    type: 'POST',
                    data: {
                        key_to_correct: $(ans).val(), 
                        _token: '{{ csrf_token() }}', 
                        _method: 'PATCH'
                    },
                    dataType: 'json',
                    Accept: 'application/json',
                    success: function(result, status, xhr){
                        $('.modal').show();
                        $(ans).val(result);
                    },
                    error: function(xhr, status, error) {
                        alert(error)
                    }
                });
            }
        });
    });
</script>
@endsection
