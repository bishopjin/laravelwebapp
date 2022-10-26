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
                        <a href="{{ route('courseexam.index') }}" 
                            class="nav-link border border-bottom-0 text-light rounded py-3 px-5">
                            {{ __('Course') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card border-top-0">
                <div class="card-header border border-primary bg-primary py-4"></div>
                <div class="card-body d-grid gap-3">
                    @php
                        $newTableData = [];

                        if(isset($users)) {
                            foreach($users as $user) {
                                $newRow = array(
                                    'id' => $user->id,
                                    'name' => $user->full_name,
                                    'gender' => $user->gender->gender,
                                    'course' => $user->onlinecourse->course,
                                    'userType' => 'For standalone system only',
                                    'changeStatus' => $user->trashed()
                                );
                            
                                array_push($newTableData, $newRow);
                            }
                        }
                    @endphp

                    <x-datatable 
                        :data="$users" 
                        :newTableData="$newTableData"
                        title="User List" 
                        :header="['Name', 'Gender', 'Course', 'User Type']" 
                        :tData="['name', 'gender', 'course', 'userType']"
                        :hasDeleteButton="true"
                        deleteLink="adminexam.destroy"
                    ></x-datatable>

                    @php
                        $newTableData2 = [];

                        if(isset($subjects)) {
                            foreach($subjects as $subject) {
                                $newRow2 = array(
                                    'id' => $subject->id,
                                    'subject' => $subject->subject,
                                    'createdby' => $subject->user->full_name
                                );
                            
                                array_push($newTableData2, $newRow2);
                            }
                        }
                    @endphp

                    <x-datatable 
                        :data="$subjects" 
                        :newTableData="$newTableData2"
                        title="Subject List" 
                        :header="['Subject', 'Created By']" 
                        :tData="['subject', 'createdby']"
                        :hasEditButton="true"
                        editLink="adminexam.edit"
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
