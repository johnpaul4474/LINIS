@extends('layouts.appHome')

@section('content')
<div class="row">    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #00AA9E;">{{ __('Linen Users') }}</div>
                    <div class="card-body">
                        <table id="usersListTable" class="table  table-bordered table-success" style="width:100%">
                            <thead>
                                    <th>id</th>
                                    <th>Employee Name</th>
                                    <th>Ward</th>
                                    <th>Office</th>
                                    <th>Role</th>
                                    <th>Assign</th>
                                    
                            </thead> 
                            <tbody>
                                @foreach ($usersList as $user)
                                <tr>
                                    <td>{{$user->id}} </td>
                                    <td>{{$user->name}} </td> 
                                    @if($user->ward_id != null)
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                        @if($ward->id == $user->ward_id )
                                                <td>{{$ward->ward_name}}</td>
                                        @endif
                                        @endforeach
                                    @else  
                                        <td>N/A</td>  
                                    @endif  


                                    @if($user->office_id != null)
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                            @if( $user->office_id  == $office->id)
                                                <td>{{$office->office_name}}</td>                                                   
                                            @endif
                                        @endforeach
                                    @else
                                        <td>N/A</td>  
                                    @endif
                                    
                                    @if($user->role_id == 1)
                                        <td>Admin</td>
                                    @else
                                        <td>User</td>
                                    @endif
                                    <td>                                          
                                        <form action = "/roleManagement/assignAdmin" method = "post">
                                            @csrf
                                            <input id="userId" type="hidden" class="form-control " name="userId" value="{{$user->id}}" >  
                                        <button type="submit" class="editProductsButton btn btn-primary btn-sm"  >
                                            <i class='fa fa-user'></i>
                                        </button>
                                        </form>
                                    </td>
                                </tr>   
                                @endforeach
                            </tbody>       
                    </table>  
                    </div>    
                </div>         
            </div>
        </div>    
      </div> 
    </div>
</div>   
@endSection
@push('scripts')

<script>
$(document).ready(function () {


  $('#usersListTable').DataTable({
            "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
            "search": true,     
            "ordering": false,
            //  "order": [[ 1, "desc" ]],
            "paging": true,
            "pageLength": 5,
            "columnDefs": [
                            {
                                "targets": [ 0 ],
                                "visible": false,
                                "searchable": false,
                                
                            },          
                        ],
            "scrollY":        "300px",
            "scrollX":        true,
            "scrollCollapse": true,
            "fixedColumns":   {
                left:0,
                right: 2
            }    
    }); 



})
     
</script>    
<style>
    body {
    -moz-transform: scale(0.9, 0.9); /* Moz-browsers */
    zoom: 0.9; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
}    
    
    </style> 
@endpush
