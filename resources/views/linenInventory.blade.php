@extends('layouts.appHome')

@section('content')



<div class="row">
   
	<div class="col-2">
       
		<div class="card text-center">
            
			<h5 class="card-header ">
                {{-- @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2) --}}
                @if(Auth::user()->role_id  == 1)
                AVAILABLE PRODUCTS FOR 
                @else                
                ISSUED PRODUCTS FOR
                @endif
                    @if(Auth::user()->office_id != null)
                          @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                              @if($office->id == Auth::user()->office_id) 
                                  {{$office->office_name}}
                              @endif
                           @endforeach
                      @elseif(Auth::user()->ward_id != null)
                          @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                          @if($ward->id ==  Auth::user()->ward_id )
                                  {{$ward->ward_name}}
                          @endif
                          @endforeach
                      
                    @endif
      
			</h5>
			<div class="card-body">
				<h3 class="card-title">{{$productCount}}</h3>
        {{-- @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2)
        
				
				<a href="products" class="btn btn-primary">Add Products</a>
        @endif
        
				
				<button type="button" class="btn btn-primary" id="productsButton">View Products</button> --}}
			
			</div>
         
		</div>
        
        <br>
                <div class="card text-center">
                    <h5 class="card-header">Number of Request</h5>
                    <div class="card-body">
                        <h3 class="card-title" id ="pendingRequestCount"></h3>
                        <a href="services" class="btn btn-primary">Request Status</a>
                    </div>
                </div>
            {{-- @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2) --}}
            @if(Auth::user()->role_id  == 1)
                
                <br>
                    <div class="card text-center">
                        <h5 class="card-header">AVAILABLE RAW MATERIALS</h5>
                        <div class="card-body">
                            <h3 class="card-title">{{$materialCount}}</h3>
                            <a href="material" class="btn btn-primary">Add Materials</a>
                            <button type="button" class="btn btn-primary" id="viewMaterialsButton">View Materials</button>
                        </div>
                    </div>
            @endif
	
	</div>
	<div class="col-10">
		<div class="card">
            
			<div class="card-header text-white" style="background-color: #00AA9E;" >
                    @if(Auth::user()->office_id != null)
                                    @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                        @if($office->id == Auth::user()->office_id) 
                                            {{$office->office_name}}
                                        @endif
                                    @endforeach
                                @elseif(Auth::user()->office_id != null)
                                    @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                    @if($ward->id ==  Auth::user()->ward_id )
                                            {{$ward->ward_name}}
                                    @endif
                                    @endforeach
                                
                                @endif
                    PRODUCTS
      
				
				
			</div>
			<br>
			<div class="card-body">
                    {{-- @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2) --}}
                    @if(Auth::user()->role_id  == 1)
					<div class="row">
                        
						<div class="col-2">
                            <div class="input-group input-group-sm mb-2">                            
                                <div class="input-group-prepend">
                                    <label for="material_used" class="input-group-text">{{ __('Material used') }}</label>
                                </div>
                                    <select class="form-control @error('material_used') is-invalid @enderror" id="material_used" name="material_used" required autocomplete="material_used" autofocus >
                                        <option value="" selected disabled hidden> Choose Material</option>                                                                                   
                                        @foreach($productsList as $product)     
                                                                                                
                                            <option value="{{$product->raw_material_id}}">
                                                {{$product->raw_material_stock_number}} : {{$product->material_used}}
                                            </option>
                                        @endforeach
                                    
                                    </select>
                                    @error('material_used')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror      
                                    <input id ="materialUsedId" type="hidden">             
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group input-group-sm mb-2">                            
                                <div class="input-group-prepend">
                                    <label for="finishedProduct" class="input-group-text">{{ __('Finished Products') }}</label>
                                </div>
                                    <select class="form-control @error('finishedProduct') is-invalid @enderror" id="finishedProduct" name="finishedProduct" required autocomplete="finishedProduct" autofocus >
                                        <option value="" selected disabled hidden> Choose Product</option>                                                                                   
                                    
                                    
                                    </select>
                                    @error('finsihedProduct')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input id ="finishedProductId" type="hidden">                    
                            </div>
                        </div>

                    
						<div class="col-2">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<label for="productsTotalQuantity" class="input-group-text">{{ __('Products Total Quantity') }}</label>
								</div>
								<input id="productsTotalQuantity" type="number" class="form-control @error('productsTotalQuantity') is-invalid @enderror" name="productsTotalQuantity" value="{{ old('productsTotalQuantity') }}" required readonly="readonly" autocomplete="productsTotalQuantity" autofocus>
                 
                                    @error('productsTotalQuantity')
                                        
                                                        
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                    @enderror                    
            
								
							</div>
						</div>
						<div class="col-2">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<label for="productsAvailable" class="input-group-text">{{ __('Products Available') }}</label>
								</div>
									<input id="productsAvailable" type="number" class="form-control @error('productsAvailable') is-invalid @enderror" name="productsAvailable" value="{{ old('productsAvailable') }}" required readonly="readonly" autocomplete="productsAvailable" autofocus>
                 
                                    @error('productsAvailable')
                                        
                                                            
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                    @enderror                    
            
									
							</div>
                        </div>
                        <div class="col-2">
							<div class="input-group input-group-sm mb-2">
								<div class="input-group-prepend">
									<label for="productsLosses" class="input-group-text">{{ __('Products Losses') }}</label>
								</div>
									<input id="productsLosses" type="number" class="form-control @error('productsLosses') is-invalid @enderror" name="productsLosses" value="{{ old('productsLosses') }}" required readonly="readonly" autocomplete="productsLosses" autofocus>
                 
                                    @error('productsLosses')
                                        
                                                            
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                    @enderror                    
            
									
							</div>
                        </div>
						<div class="col-2">
							<div class="input-group input-group-sm mb-2">
							    <div class="input-group-prepend">
									<label for="productsCondemned" class="input-group-text">{{ __('Products Condemned') }}</label>
								</div>
									<input id="productsCondemned" type="number" class="form-control @error('productsCondemned') is-invalid @enderror" name="productsCondemned" value="{{ old('productsCondemned') }}" required readonly="readonly" autocomplete="productsCondemned" autofocus>
                 
                                    @error('productsCondemned')
                                        
                                                                
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                    @enderror                    
            
										
										</div>
								</div>
							</div>
						</div>
                        
					</div>	
                    @endif   
                    <div class="row" id="productsTableDiv">
                        <table id="productsTable" class="table  table-bordered table-success" style="width:100%">
                            <thead>
                                <tr>
                                <th>id</th>              
                                <th>PRODUCT</th>
                                <th>PRODUCT <br> UNIT</th>
                                <th>QUANTITY</th>
                                <th>WARD/OFFICE</th>     
                                <th>DATE CREATED</th>  
                                <th>DATE ISSUED</th>
                                @if(Auth::user()->role_id  == 1)
                                <th>DATE RETURNED</th>
                                <th>DATE CONDEMNED</th>
                                <th>DATE LOSSED</th> 
                                @endif
                                
                                </tr>
                            </thead>
                            <tbody id="productsTbody">
                                @foreach($productsList as $products)                                                                
                                <tr id={{$products->product_bulk_id}}>
                                <td>{{$products->product_bulk_id}}</td>
                                    
                                <td id="product_name">{{$products->product_name}}</td>
                                <td id="product_unit">{{$products->product_unit}}</td>
                                
                                
                                
                                <td id="issued_quantity">{{$products->products_issued_quantity}}</td>  
                                @if($products->product_condemned_quantity > 0)
                                    <td style="background-color:#ff0000">CONDEMNED</td>
                                @elseif($products->product_returned_quantity > 0 && $products->product_available_quantity > 0)
                                    <td style="background-color:#00FF00">RE-ISSUE</td>
                                @elseif($products->product_losses_quantity > 0)
                                    <td style="background-color:#FF0000">LOSSED</td>        
                                @else
                                    @if($products->issued_office_id != null)
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                            @if($office->id == $products->issued_office_id) 
                                                <td>{{$office->office_name}}</td>
                                            @endif
                                        @endforeach
                                    @elseif($products->issued_ward_id != null)
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                        @if($ward->id == $products->issued_ward_id )
                                                <td>{{$ward->ward_name}}</td>
                                        @endif
                                        @endforeach
                                    @else  
                                        <td style="background-color:#00FF00">NOT YET ISSUED</td>  
                                    @endif 
                                @endif                   
                                
                                <td id="created_date">{{$products->create_date}}</td>
                                <td id="issued_date">{{$products->issued_date}}</td>
                                @if(Auth::user()->role_id  == 1)
                                <td id="returned_date">{{$products->returned_date}}</td>
                                <td id="condemned_date">{{$products->condemned_date}}</td>
                                <td id="condemned_date">{{$products->lossed_date}}</td> 
                                @endif
                                </tr>

                                @endforeach
                                
                            </tbody>  
                        </table> 
                
                    </div>        
                        
                          
            </div>
		</div>
	</div>
</div>


@endsection



@push('scripts')


					
		<script>  
$(document).ready(function () {
    //   $('#rawMaterialTable').DataTable(
    //     {
    //     "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
    //     "search": true,     
    //     "ordering": true,
    //     // "order": [[ 0, "desc" ]],
    //     "paging": true,
    //     "pageLength": 5
    //    } 
        
    //   );

      $('#productsTable').DataTable(
        {
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        "search": true,     
        "ordering": true,
        //  "order": [[ 1, "desc" ]],
        "paging": true,
        "pageLength": 25,
        "columnDefs": [
                {
                "targets": [ 0 ],
                "visible": false,
                "searchable": true
                }
           
                ]

      
       }         
      ); 
      



      var usedNames = {};
      $("select[name='material_used'] > option").each(function () {
          if(usedNames[this.text]) {
              $(this).remove();
          } else {
              usedNames[this.text] = this.value;
          }
      });


$("#material_used").change(function() {
    
        let id = $(this).children(":selected").val();
        $('#materialUsedId').val(id);
        $("#finishedProduct").find('option').remove();
        $("#finishedProduct").append('<option value="" selected disabled hidden> Choose Product</option>'); 
        $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
            var optionExists = $("#finishedProduct option[value="+value.product_bulk_id+"]").length > 0;
                    
                  if(value.raw_material_id == id){
                   
                      if(optionExists == false){
                              $("#finishedProduct").append('<option value="'+value.product_bulk_id+'">'+value.product_name+'</option>'); 
                      }
                  }
                });
    
     
                
    });

    $("#finishedProduct").change(function() {   
    let bulkId = $(this).children(":selected").val();
    $('#finishedProductId').val(bulkId);
    

    $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
        if(value.product_bulk_id == bulkId ){
            console.log(value);
          $('#productsTotalQuantity').val(value.product_quantity);
          $('#productsAvailable').val(value.product_available_quantity);
          $('#productsCondemned').val(value.product_condemned_quantity);
          $('#productsLosses').val(value.product_losses_quantity);
    
        }
      });  
      console.log(bulkId);    
    var table = $('#productsTable').DataTable();

     table.search(bulkId ).draw();

    });

    // $("#btn-retrieve").click(function (e) {
        

    //     console.log($('#materialUsedId').val());
    //     console.log($('#finishedProductId').val());
    //     // $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) { 
            
    //     //     if(value.raw_material_id == $('#materialUsedId').val() &&  value.product_bulk_id == $('#finishedProductId').val()){
    //     //         console.log(value);
                                                                              
              

                                    
    //     //     }
    //     // });

    // });

    let pendingCount = 0
    $.each({!! json_encode($requestList, JSON_HEX_TAG) !!}, function(key, value) {    
    console.log(value)       
    if(value.status != 4){
      pendingCount ++;
    }
   
 });
    $('#pendingRequestCount').text(pendingCount);
  
});



</script>
<style>
    body {
    -moz-transform: scale(0.9, 0.9); /* Moz-browsers */
    zoom: 0.9; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
}  
tr.group,
tr.group:hover {
    background-color: #ddd !important;
}  
.dataTables_filter {
display: none;
}
</style> 
@endpush