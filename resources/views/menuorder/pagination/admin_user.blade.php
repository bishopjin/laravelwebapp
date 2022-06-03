<div class="border rounded p-3 w-100">
    <div class="d-flex justify-content-start">
        <span class="fw-bold">{{ __('User List') }}</span>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>{{ __('Firstname') }}</th>
                <th>{{ __('Middlename') }}</th>
                <th>{{ __('Lastname') }}</th>
                <th>{{ __('Gender') }}</th>
                <th>{{ __('Status') }}</th>
            </thead>  
            <tbody>
                @isset($users)
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->firstname }}</td>
                            <td>{{ $user->middlename }}</td>
                            <td>{{ $user->lastname }}</td>
                            <td>{{ $user->gender->gender }}</td>
                            <td>{{ $user->isactive == 1 ? 'Active' : 'Inactive' }}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            @isset($users)
                {{ $users->links() }}  
            @endisset
        </div>
    </div>
</div>