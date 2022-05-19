@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header fw-bolder d-flex flex-row justify-content-between align-items-center">
                    <span>{{ __('Edit Users') }}</span>
                </div>

                <div class="card-body table-responsive">
                    <table class="table" id="datatable">
                        <thead>
                            <tr class="small">
                                <th class="text-center">User ID</th>
                                <th class="text-center">Users</th>
                                <th class="text-center">Access Type</th>
                                <th class="text-center">Change Access Type</th>
                                <th class="text-center">Change Account Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_details as $user)
                                @if(auth()->user()->id != $user->user_id)
                                    @php
                                        $active = false;
                                        $notactive = false;
                                        if ($user->isactive)
                                        {   
                                            $btn_label = 'Disable';
                                            $active = true;
                                        }
                                        else 
                                        {
                                            $btn_label = 'Enable';
                                            $notactive = true;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $user->user_id }}</td>
                                        <td class="text-center">{{ $user->lastname }}, {{ $user->firstname }} {{ $user->middlename }}</td>
                                        <!-- <td class="text-center">{{ $user->user_type }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('inventory.employee.edit.access', $user->user_id) }} " class="btn btn-outline-primary">Edit Access Level</a>
                                        </td> -->
                                        <!-- cosolitaed system  -->
                                        <td class="text-center text-danger">{{ __('For standalone system only') }}</td>
                                        <td class="text-center text-danger">{{ __('Not standalone system only') }}</td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('inventory.employee.delete') }}">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                                                <input type="hidden" name="status" value="{{ $user->isactive }}">
                                                <input type="submit" value="{{ $btn_label }}"
                                                    @class(['btn', 'btn-outline-danger' => $active, 
                                                    'btn-outline-success' => $notactive])>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
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