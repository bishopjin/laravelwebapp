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
                        <a href="{{ route('exam.create') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Examination') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link border border-bottom-0 text-light bg-primary rounded py-3 px-5">
                            {{ __('Preview Examination') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body p-md-4 d-grid gap-3">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-md-between">
                            <div class="pb-md-0 pb-2">
                                <strong>
                                    {{ __('Examination Code: ') }}
                                    {{ $exams->exam_code }}
                                </strong>
                            </div>
                            <div>
                                <strong>
                                    {{ __('Time Limit (minutes): ') }}
                                    {{ $exams->timer }}
                                </strong>
                            </div>
                        </div>
                        <div class="card-body">
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
                            @else
                                @foreach($examQuestions as $question)
                                    <div class="fw-bold">
                                        {{ $loop->index + 1 }}. {{ $question->question }}
                                    </div>

                                    {{-- key answer --}}
                                    <form method="POST" 
                                        action="{{ route('examquestion.update', $question->id) }}" 
                                        class="pt-1 pb-3 ps-4">

                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group">
                                            <label>
                                                {{ __('Correct Answer') }}
                                            </label>
                                            <div class="d-flex flex-row gap-2">
                                                <input type="text" 
                                                    name="key_to_correct"
                                                    value="{{ $question->key_to_correct }}" 
                                                    class="form-control">

                                                <button type="submit" 
                                                    class="btn btn-outline-success border-0">
                                                    {{ __('Update') }}
                                                </button>
                                            </div>
                                        </div>  
                                    </form>
                                @endforeach
                            @endif
                        </div>
                    </div>
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
