@extends('layouts.appHome')

@section('content')
<div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card bg-danger">
            <h5 class="card-header text-center">PENDING</h5>
            <div class="card-body">              
              <h1 class="text-center" id = "pendingRequest">0</h1>    
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card bg-primary">
            <h5 class="card-header text-center">PROCESSING</h5>
            <div class="card-body">
                <h1 class="text-center">0</h1>    
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card bg-success">
            <h5 class="card-header text-center">FINISHED</h5>
            <div class="card-body">
                <h1 class="text-center">0</h1>    
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="row">    
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #00AA9E;">{{ __('Linen Products') }}</div>
                        <br>
                        <table id="productsRequest" class="table  table-bordered table-success" style="width:100%">
                            <thead>
                              <tr>
                                <th>id</th>
                                <th>Product name</th>
                                <th>Quantity</th>
                                <th>Requested By</th>
                                <th>Ward</th>
                                <th>Office</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($newRequest as $newReq)                                                                
                              <tr id={{$newReq->id}}>
                                <td>{{$newReq->id}}</td>
                                <td>{{$newReq->product_name_request}}</td>
                                <td>{{$newReq->product_quantity_request}}</td>
                                <td>{{$newReq->name}}</td>

                                
                                @if($newReq->ward_id != null)
                                    @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                    @if($ward->id == $newReq->ward_id )
                                            <td>{{$ward->ward_name}}</td>
                                    @endif
                                    @endforeach
                                @else  
                                    <td>N/A</td>  
                                @endif   

                                @if($newReq->office_id != null)
                                  @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                      @if($office->id == $newReq->office_id) 
                                          <td>{{$office->office_name}}</td>
                                      @endif
                                  @endforeach
                                @else  
                                  <td>N/A</td>  
                                @endif                                   

                                <td>{{$newReq->created_at}}</td>
                               

                                @if($newReq->status == 1)
                                 <td style="background-color:#FF0000">PENDING</td>
                                @elseif($newReq->status == 2)
                                 <td>IN_PROGRESS</td>                                
                                @elseif($newReq->status == 3)
                                 <td>FINISHED</td>
                                @elseif($newReq->status == 4)
                                  <td>REOPENED REQUEST</td>
                                @elseif($newReq->status == 5)
                                  <td>DELETED</td>
                                @endif
                                <td><button type="submit" class="editProductsButton btn btn-primary btn-sm" >PROCESS</button></td>
                                
           
                              </tr>
      
                              @endforeach
                              
                            </tbody>  
                        </table>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>              
    </div>
</div>    
      


 
</div>

   
@endsection



@push('scripts')

<script>
$(document).ready(function () {
  let pendingCount = {!!$newRequest!!};
  $('#pendingRequest').text(pendingCount.length);

  
  $('#productsRequest').DataTable({
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