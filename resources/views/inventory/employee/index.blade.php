@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder d-flex flex-row justify-content-between align-items-center">
                    <span>
                        {{ __('Employee Log') }}
                    </span>
                    <span>
                        <a href="{{ route('employee.index') }}" 
                            class="btn btn-outline-success px-3 fw-bolder">
                            {{ __('Edit User') }}
                        </a>
                    </span>
                </div>

                <div class="card-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    {{ __('UID') }}
                                </th>
                                <th>
                                    {{ __('Employee Name') }}
                                </th>
                                <th>
                                    {{ __('Time In') }}
                                </th>
                                <th>
                                    {{ __('Login Date') }}
                                </th>
                                <th>
                                    {{ __('Time Out') }}
                                </th>
                                <th>
                                    {{ __('Logout Date') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employeeLog as $item)
                                @php
                                    $date_in = explode(' ', $item->time_in);

                                    if (is_null($item->time_out)) { $date_out = [null, null]; }
                                    else { $date_out = explode(' ', $item->time_out); }
                                @endphp
                                <tr>
                                    <td class="fw-bolder">
                                        {{ $item->user_id }}
                                    </td>
                                    <td>
                                        {{ $item->user->full_name }}
                                    </td>
                                    <td>
                                        {{ $date_in[1] }}
                                    </td>
                                    <td>
                                        {{ $date_in[0] }}
                                    </td>
                                    <td>
                                        {{ $date_out[1] }}
                                    </td>
                                    <td>
                                        {{ $date_out[0] }}
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    @isset($employeeLog)
                        <div class="d-flex justify-content-end">
                            {{ $employeeLog->links() }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection