@extends('layouts.appHome')

@section('content')
<div class="row">    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #00AA9E;">{{ __('Wards & Offices') }}</div>
                    <div class="card-body">
                        <table id="wardofficeTable" class="table  table-bordered table-success" style="width:100%">
                            <thead>
                                    <th>id</th>
                                    <th>Ward/Office Name</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                    
                            </thead> 
                            <tbody>
                                @foreach ($wards as $ward)
                                <tr>
                                    <td>{{$ward->id}} </td>
                                    <td>{{$ward->ward_name}} </td> 
                                    <td>Ward</td>
                                    <td>                                          
                                        <form action = "/departments/ward/{{$ward->id}}" method = "GET"> 
                                            <button type="submit" class="btn btn-primary btn-sm"  >
                                                View Issued Products
                                            </button>
                                        </form>
                                    </td>
                                </tr>   
                                @endforeach

                                @foreach ($offices as $office)
                                <tr>
                                    <td>{{$office->id}} </td>
                                    <td>{{$office->office_name}} </td> 
                                    <td>Office</td>
                                    <td>                                          
                                        <form action = "/departments/office/{{$office->id}}" method = "GET">
                                            <button type="submit" class="btn btn-primary btn-sm"  >
                                                View Issued Products
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


  $('#wardofficeTable').DataTable({
            "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
            "search": true,     
            // "ordering": false,
            "order": [[ 1, "asc" ]],
            "paging": true,
            "pageLength": 10,
            "columnDefs": [
                            {
                                "targets": [ 0 ],
                                "visible": false,
                                "searchable": false,
                                
                            },          
                        ],
            "scrollY":        "500px",
            "scrollX":        true,
            "scrollCollapse": true,
            "fixedColumns":   {
                left:0,
                right: 2
            }    
    }); 



})
     
</script>
@endpush
