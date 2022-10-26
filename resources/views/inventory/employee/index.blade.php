@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <a href="{{ route('employee.index') }}" 
                class="btn btn-outline-success px-3 fw-bolder border-0 mb-2">
                {{ __('Edit User') }}
            </a>

            @php
                $newTableData = [];

                if(isset($employeeLog)) {
                    foreach($employeeLog as $item) {
                        $date_in = explode(' ', $item->time_in);
                        $date_out = explode(' ', $item->time_out); 

                        $newRow = array(
                            'id' => $item->user_id,
                            'name' => $item->user->full_name,
                            'timein' => $date_in[1] ?? '',
                            'datein' => $date_in[0] ?? '',
                            'timeout' => $date_out[1] ?? '',
                            'dateout' => $date_out[0] ?? ''
                        );
                    
                        array_push($newTableData, $newRow);
                    }
                }
            @endphp

            <x-datatable 
                :data="$employeeLog" 
                :newTableData="$newTableData"
                title="Employee Logs" 
                :header="['UID', 'Employee Name', 'Time In', 'Login Date', 'Time Out', 'Logout Date']" 
                :tData="['id', 'name', 'timein', 'datein', 'timeout', 'dateout']">
            </x-datatable>
            
        </div>
    </div>
    <x-footer/>
</div>
@endsection