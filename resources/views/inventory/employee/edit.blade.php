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
                            @isset($user_details)
                                @foreach($user_details as $user)
                                    @php
                                        $active = false;
                                        $notactive = false;
                                        if ($user->trashed())
                                        {   
                                            $btn_label = 'Enable';
                                            $notactive = true;
                                        }
                                        else 
                                        {
                                            $btn_label = 'Disable';
                                            $active = true;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <!-- standalone system -->
                                        {{-- <td class="text-center">{{ $user->user_type }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('inventory.employee.edit.access', $user->id) }} " class="btn btn-outline-primary">Edit Access Level</a>
                                        </td> --}}
                                        <!-- End -->
                                        <!-- consolidated system  -->
                                        <td class="text-center text-danger">{{ __('For standalone system only') }}</td>
                                        <td class="text-center text-danger">{{ __('For standalone system only') }}</td>
                                        <!-- End -->
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('inventory.employee.destroy') }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <input type="submit" value="{{ $btn_label }}"
                                                    @class(['btn', 'btn-outline-danger' => $active, 
                                                    'btn-outline-success' => $notactive])>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $user_details->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
</div>
@endsection