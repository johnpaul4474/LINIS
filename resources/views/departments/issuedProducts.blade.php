@extends('layouts.appHome')

@section('content')
<div class="row">    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #00AA9E;">{{$name}} {{$type}}</div>
                    <div class="card-body">
                        <table id="wardofficeTable" class="table  table-bordered table-success" style="width:100%">
                            <thead>
                                    <th>Product Stock ID</th>
                                    <th>Product Name</th>
                                    <th>Unit Cost</th>
                                    <th>Status</th>
                                    
                            </thead> 
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{$product->product_stock_id}} </td>
                                    <td>{{$product->product_name}} </td>
                                    <td>{{$product->product_unit_cost}} </td>
                                    <td>{{$product->status}} </td>
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
