@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder d-flex flex-row justify-content-between align-items-center">
                    <span>{{ __('Employee Log') }}</span>
                    <span>
                        <a href="{{ route('inventory.employee.edit') }}" class="btn btn-outline-success px-3 fw-bolder">{{ __('Edit User') }}</a>
                    </span>
                </div>

                <div class="card-body table-responsive">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>UID</th>
                                <th>Employee Name</th>
                                <th>Time In</th>
                                <th>Login Date</th>
                                <th>Time Out</th>
                                <th>Logout Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee_log as $item)
                                @php
                                    $date_in = explode(' ', $item->time_in);

                                    if (is_null($item->time_out)) { $date_out = [null, null]; }
                                    else { $date_out = explode(' ', $item->time_out); }
                                @endphp
                                <tr>
                                    <td class="fw-bolder">{{ $item->user_id }}</td>
                                    <td>{{ $item->lastname }}, {{ ($item->middlename) }} {{ ($item->firstname) }}</td>
                                    <td>{{ $date_in[1] }}</td>
                                    <td>{{ $date_in[0] }}</td>
                                    <td>{{ $date_out[1] }}</td>
                                    <td>{{ $date_out[0] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#datatable').DataTable();
    });
</script>
@endsection