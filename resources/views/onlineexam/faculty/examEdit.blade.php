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
                            {{ __('Edit Exam Detail') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body p-md-4 d-grid gap-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>
                                {{ __('Examination Code: ') }}
                                {{ $exams->exam_code }}
                            </strong>
                        </div>

                        <div class="card-body">
                            <div class="row justify-content-center py-2">
                                <div class="col-md-6">
                                    <form 
                                        method="POST"
                                        action="{{ route('exam.update', $exams->id) }}" 
                                    >

                                    @csrf
                                    @method('PUT')
                                    
                                       <div class="form-group pb-3">
                                            <label>
                                                {{ __('Change examination subject') }}
                                            </label>
                                            <select name="online_subject_id" class="form-select">
                                                @forelse($subjectList as $subject)
                                                    <option 
                                                        value="{{ $subject->id }}"
                                                        @if($subject->id === $exams->online_subject_id) selected @endif 
                                                    >
                                                        {{ $subject->subject }}
                                                    </option>
                                                @empty
                                                    <option></option>
                                                @endforelse
                                            </select>
                                       </div>
                                       <div class="form-group pb-3">
                                           <label>
                                               {{ __('Change exam time limit') }}
                                           </label>
                                           <input type="number" name="timer" class="form-control" value="{{ $exams->timer }}">
                                       </div>
                                       <div class="form-group">
                                           <input type="submit" name="Save" class="btn btn-outline-primary border-0">
                                       </div>
                                    </form> 
                                </div>
                            </div>
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
