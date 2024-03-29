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
              <h1 class="text-center" id="processingRequest">0</h1>    
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card bg-success">
          <h5 class="card-header text-center">READY FOR PICK UP</h5>
          <div class="card-body">
              <h1 class="text-center" id="finishedRequest">0</h1>    
          </div>
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
                            <th>Create Date</th>
                            <th>Status</th>
                            <th>Processed By</th>
                            <th>Processed Date</th>
                            <th>Remarks</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($requestList as $req)                                                                
                          <tr id={{$req->id}}>
                            <td>{{$req->id}}</td>
                            <td>{{$req->product_name_request}}</td>
                            <td>{{$req->product_quantity_request}}</td>
                            <td>{{$req->name}}</td>

                            
                            @if($req->ward_id != null)
                                @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                @if($ward->id == $req->ward_id )
                                        <td>{{$ward->ward_name}}</td>
                                @endif
                                @endforeach
                            @else  
                                <td>N/A</td>  
                            @endif   

                            @if($req->office_id != null)
                              @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                  @if($office->id == $req->office_id) 
                                      <td>{{$office->office_name}}</td>
                                  @endif
                              @endforeach
                            @else  
                              <td>N/A</td>  
                            @endif                                   

                            <td>{{$req->created_at}}</td>
                            
                            
                            @if($req->status == 1)
                              <td style="background-color:#FF5252">PENDING</td>
                            @elseif($req->status == 2)
                              <td style="background-color:#2196F3;color:white">IN PROGRESS</td>                                
                            @elseif($req->status == 3)
                            <td style="background-color:#f0ad4e;color:white">READY FOR <br> PICK-UP </td> 
                            @elseif($req->status == 4)
                            <td style="background-color:#4CAF50;color:white">ISSUED </td> 
                            @elseif($req->status == 5)
                              <td>DELETED</td>
                            @endif
                            <td>{{$req->processed_by}}</td>
                            <td>{{$req->processed_at}}</td>
                            @if(Auth::user()->role_id  == 1)
                            <td>
                              <form action="/services/comments/{{$req->id}}" method="POST">
                                @csrf
                                <textarea id="remarks_{{$req->id}}" onkeyup="remarksOnKeyUp({{$req->id}})" type="text" class="form-control" name="remarks" >{{$req->comments}}</textarea>
                                <button type="submit" value="Submit" class="btn btn-primary btn-sm" >Save Remarks</button>
                              </form>
                              
                            </td>
                            @else
                            <td>{{$req->comments}}</td>
                            @endif
                            {{-- @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2) --}}
                            @if(Auth::user()->role_id  == 1)
                              @if($req->status == 1)
                                <td>
                                  <form action = "/processRequest" method = "post">
                                    @csrf
                                      <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$req->id}}">
                                      <input id="product_name_request" type="hidden" class="form-control @error('id') is-invalid @enderror" name="product_name_request" value="{{$req->product_name_request}}">
                                      <input id="product_quantity_request" type="hidden" class="form-control @error('id') is-invalid @enderror" name="product_quantity_request" value="{{$req->product_quantity_request}}">
                                      <input id="remarksSave_{{$req->id}}" type="hidden" class="form-control @error('remarksSave_{{$req->id}}_{{$req->id}}') is-invalid @enderror" name="remarksSave" value="">
                                        <button type="submit" class="editProductsButton btn btn-primary btn-sm" >PROCESS</button>
                                  </form>
                                  <form action = "/cancelRequest/{{$req->id}}" method = "post">
                                    @csrf
                                      <input id="remarksSave2_{{$req->id}}" type="hidden" class="form-control @error('remarksSave2_{{$req->id}}_{{$req->id}}') is-invalid @enderror" name="remarksSave" value="">
                                        <button type="submit" class="editProductsButton btn btn-danger btn-sm" >CANCEL</button>
                                  </form>
                                </td>
                              @elseif($req->status == 2)
                              <form action = "/pickUpProductRequest" method = "post">
                                @csrf
                                  <td>
                                  <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$req->id}}">
                                  <input id="product_name_request" type="hidden" class="form-control @error('id') is-invalid @enderror" name="product_name_request" value="{{$req->product_name_request}}">
                                  <input id="product_quantity_request" type="hidden" class="form-control @error('id') is-invalid @enderror" name="product_quantity_request" value="{{$req->product_quantity_request}}">
                                  
                                    <input id="remarksSave_{{$req->id}}" type="hidden" class="form-control @error('remarksSave_{{$req->id}}') is-invalid @enderror" name="remarksSave" value="">  
                                    <button type="submit" class="editProductsButton btn btn-info btn-sm" >READY</button>
                                  </td>
                              </form>
                              @elseif($req->status == 3)
                              <form action = "/issueProductRequest" method = "get">
                                @csrf
                                    <td>
                                  <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$req->id}}">                                      
                                  <input id="remarksSave_{{$req->id}}" type="hidden" class="form-control @error('remarksSave_{{$req->id}}') is-invalid @enderror" name="remarksSave" value=""> 
                                    <button type="submit" class="editProductsButton btn btn-warning btn-sm" >ISSUE</button>
                                  </td>
                              </form>
                              @elseif($req->status == 4)
                              <td style="background-color:#4CAF50;color:white">ISSUED </td> 
                              @elseif($req->status == 5)
                              <td>CANCELLED/DELETED </td> 
                              
                              @endif

                            @else
                              @if($req->status == 1)
                                <td>
                                  <form action = "/cancelRequest/{{$req->id}}" method = "post">
                                    @csrf
                                      <input id="remarksSave2_{{$req->id}}" type="hidden" class="form-control @error('remarksSave2_{{$req->id}}_{{$req->id}}') is-invalid @enderror" name="remarksSave" value="">
                                        <button type="submit" class="editProductsButton btn btn-danger btn-sm" >CANCEL</button>
                                  </form>
                                </td>
                              @else
                                <td></td>
                              @endif
                            @endif   
        
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

   
@endsection



@push('scripts')

<script>
$(document).ready(function () {
  
  let pendingCount = 0;
  let processingCount = 0;
  let finishedCount = 0;
 
  
  $.each({!! json_encode($requestList, JSON_HEX_TAG) !!}, function(key, value) {    
    ////////console.log(value)       
    if(value.status == 1) {
      pendingCount ++;
    }
    if(value.status == 2) {
      processingCount ++;
    }
    if(value.status == 3) {
      finishedCount ++;
    }
 });

 $('#pendingRequest').text(pendingCount);
 $('#processingRequest').text(processingCount);
 $('#finishedRequest').text(finishedCount);

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

function remarksOnKeyUp(id) {
    console.log(id);        
    $('#remarksSave_'+id).val($('#remarks_'+id).val());
    $('#remarksSave2_'+id).val($('#remarks_'+id).val());
  }
     
</script>    
<style>
    /* body {
    -moz-transform: scale(0.9, 0.9); 
    zoom: 0.9; 
    zoom: 90%; 
}    
     */
    </style> 
@endpush