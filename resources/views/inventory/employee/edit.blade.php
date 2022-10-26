@extends('inventory.layouts.app')

@section('inventorycontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">

            @php
                $newTableData = [];

                if(isset($userDetails)) {
                    foreach($userDetails as $user) {
                        $newRow = array(
                            'id' => $user->id,
                            'name' => $user->full_name,
                            'accesType' => 'For standalone system only',
                            'changeAccess' => 'For standalone system only',
                            'changeStatus' => $user->trashed()
                        );
                    
                        array_push($newTableData, $newRow);
                    }
                }
            @endphp

            <x-datatable 
                :data="$userDetails" 
                :newTableData="$newTableData"
                title="Edit Users" 
                :header="['User ID', 'Users', 'Access Type', 'Change Access Type']" 
                :tData="['id', 'name', 'accesType', 'changeAccess']"
                :hasDeleteButton="true"
                deleteLink="employee.destroy"
            ></x-datatable>
            
        </div>
    </div>
    <x-footer/>
</div>
@endsection