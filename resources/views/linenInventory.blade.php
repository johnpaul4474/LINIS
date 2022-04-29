@extends('layouts.appHome')

@section('content')



<div class="row">
	<div class="col">
		<div class="card text-center">
			<h5 class="card-header ">AVAILABLE PRODUCTS FOR 
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
				<h3 class="card-title">0</h3>
				<a href="#" class="btn btn-primary">Request Status</a>
			</div>
		</div>
    @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2)
    
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
	<div class="col-9">
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
      
				
				<button type="button" class="btn btn-danger" id="productsButtonClose" style="float: right">&times;</button>
			</div>
			<br>
				<div class="card-body">
					<div class="row">
						<div class="col-3">
              <div class="input-group input-group-sm mb-3">                            
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
              </div>
          </div>
          <div class="col-3">
              <div class="input-group input-group-sm mb-3">                            
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
								<div class="input-group input-group-sm mb-3">
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
									<div class="input-group input-group-sm mb-3">
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
            <div class="w-100"></div> 
            <table id="productsTable" class="table  table-bordered table-success" style="width:100%">
              <thead>
                <tr>
                  <th>id</th>
                                               
                  <th>PRODUCT</th>
                  <th>PRODUCT <br> UNIT</th>

                  
                  <th>ISSUED QUANTITY</th>
                  <th>WARD/OFFICE</th>                           
                  <th>UNIT <br> COST</th>
                  <th>TOTAL <br> COST</th>
                  {{-- <th>PRODUCT STOCK <br>NUMBER(s)</th>  --}}
                
                  {{-- <th>AVAILABLE</th>
                  <th>CONDEMNED</th>                  --}}
                 
                  <th>DATE ISSUED</th>
                  
                  {{-- <th>EDIT</th> --}}
                  {{-- <th>DELETE</th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach($productsList as $products)                                                                
                <tr id={{$products->product_bulk_id}}>
                  <td>{{$products->products_ids}}</td>
                      
                  <td id="product_name">{{$products->product_name}}</td>
                  <td id="product_unit">{{$products->product_unit}}</td>
                 
                 
                  
                  <td id="issued_quantity">{{$products->products_issued_quantity}}</td>      
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
                    <td>NOT YET ISSUED</td>  
                @endif                    
                  <td id="product_unit_cost">{{$products->product_unit_cost}}</td>
                  <td id="total_cost">{{$products->total_cost}}</td>
                  {{-- <td id="{{$products->product_stock_ids}}">{{$products->product_stock_ids}}</td> --}}
                 
                  {{-- @if($products->is_available == 1)
                      <td id="available">YES</td>
                  @else
                      <td id="available">NO</td>
                  @endif
                  @if($products->is_condemned == 1)
                      <td id="condemned">YES</td>
                  @else
                      <td id="condemned">NO</td>
                  @endif --}}
                  
                  <td id="created_date">{{$products->issued_date}}</td>
                  
                  {{-- <td>                                          
                    
                    <button type="submit" class="editProductsButton btn btn-primary btn-sm"  >
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            width="20px" height="20px" viewBox="0 0 494.936 494.936" style="enable-background:new 0 0 494.936 494.936;"
                            xml:space="preserve">
                        <g>
                            <g>
                                <path d="M389.844,182.85c-6.743,0-12.21,5.467-12.21,12.21v222.968c0,23.562-19.174,42.735-42.736,42.735H67.157
                                    c-23.562,0-42.736-19.174-42.736-42.735V150.285c0-23.562,19.174-42.735,42.736-42.735h267.741c6.743,0,12.21-5.467,12.21-12.21
                                    s-5.467-12.21-12.21-12.21H67.157C30.126,83.13,0,113.255,0,150.285v267.743c0,37.029,30.126,67.155,67.157,67.155h267.741
                                    c37.03,0,67.156-30.126,67.156-67.155V195.061C402.054,188.318,396.587,182.85,389.844,182.85z"/>
                                <path d="M483.876,20.791c-14.72-14.72-38.669-14.714-53.377,0L221.352,229.944c-0.28,0.28-3.434,3.559-4.251,5.396l-28.963,65.069
                                    c-2.057,4.619-1.056,10.027,2.521,13.6c2.337,2.336,5.461,3.576,8.639,3.576c1.675,0,3.362-0.346,4.96-1.057l65.07-28.963
                                    c1.83-0.815,5.114-3.97,5.396-4.25L483.876,74.169c7.131-7.131,11.06-16.61,11.06-26.692
                                    C494.936,37.396,491.007,27.915,483.876,20.791z M466.61,56.897L257.457,266.05c-0.035,0.036-0.055,0.078-0.089,0.107
                                    l-33.989,15.131L238.51,247.3c0.03-0.036,0.071-0.055,0.107-0.09L447.765,38.058c5.038-5.039,13.819-5.033,18.846,0.005
                                    c2.518,2.51,3.905,5.855,3.905,9.414C470.516,51.036,469.127,54.38,466.61,56.897z"/>
                            </g>
                        </g>
                        </svg>
                    </button>
                    </a>
                  </td> --}}
                  {{-- <td>
                      <form action = "/products/delete" method = "post">
                        @csrf
                        <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$products->products_ids}}">

                        <button class="btn btn-danger btn-sm" type="submit">  
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" 
                            width="20px" height="20px" viewBox="0 0 494.936 494.936" style="enable-background:new 0 0 494.936 494.936;"
                            xml:space="preserve">
                        <g>
                            <path d="M324.285,215.015V128h20V38h-98.384V0H132.669v38H34.285v90h20v305h161.523c23.578,24.635,56.766,40,93.477,40
                                c71.368,0,129.43-58.062,129.43-129.43C438.715,277.276,388.612,222.474,324.285,215.015z M294.285,215.015
                                c-18.052,2.093-34.982,7.911-50,16.669V128h50V215.015z M162.669,30h53.232v8h-53.232V30z M64.285,68h250v30h-250V68z M84.285,128
                                h50v275h-50V128z M164.285,403V128h50v127.768c-21.356,23.089-34.429,53.946-34.429,87.802c0,21.411,5.231,41.622,14.475,59.43
                                H164.285z M309.285,443c-54.826,0-99.429-44.604-99.429-99.43s44.604-99.429,99.429-99.429s99.43,44.604,99.43,99.429
                                S364.111,443,309.285,443z"/>
                            <polygon points="342.248,289.395 309.285,322.358 276.323,289.395 255.11,310.608 288.073,343.571 255.11,376.533 276.323,397.746 
                                309.285,364.783 342.248,397.746 363.461,376.533 330.498,343.571 363.461,310.608 	"/>
                        </g>

                        </svg> </button>                                   
                        <span class="glyphicon glyphicon-remove-circle"></span>  
                        </button>
                    </form>
                
                </td> --}}
                </tr>

                @endforeach
                
              </tbody>  
          </table> 
					</div>
				</div>
			</div>
		</div>


@endsection



@push('scripts')


					
		<script>  
$(document).ready(function () {
      $('#rawMaterialTable').DataTable(
        {
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        "search": true,     
        "ordering": true,
        // "order": [[ 0, "desc" ]],
        "paging": true,
        "pageLength": 5
       } 
        
      );

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
                "searchable": false
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
    console.log(bulkId);

    $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
        if(value.product_bulk_id == bulkId ){
          $('#productsTotalQuantity').val(value.product_quantity);
          $('#productsAvailable').val(value.product_available_quantity);
          $('#productsCondemned').val(value.product_condemned_quantity);
    
        }
      });  
    });

  
});
</script>
		<style>
 body {
    -moz-transform: scale(0.9, 0.9); /* Moz-browsers */
    zoom: 0.9; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
}
</style> 
@endpush