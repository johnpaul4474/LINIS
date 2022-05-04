@extends('layouts.appHome')

@section('content')


<div class="row">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class = 'card p-3 bg-light' action = "returningProducts" method = "post">
                    @csrf
                    <fieldset>
                        <legend>Return Products <legend>
                        <div class="row">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">                      
                                        <label for="ward" class="col col-form-label text-md-end" style="font-size:medium"> 
                                            <input class="form-check-input" type="radio" name="ward_office" id="wardRadio" required >{{ __('     Ward') }}
                                        </label>
                                    </div>                    
                                    
                                
                                        <select class="form-control @error('ward') is-invalid @enderror" id="ward" name="ward" required autocomplete="ward" autofocus disabled>
                                            <option value="" selected disabled hidden> Choose Ward</option>
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                        <option value="{{$ward->id}}">
                                                {{$ward->ward_name}}
                                            </option>
                                        @endforeach
                                        </select>
                                        @error('ward')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <label for="office" class="col col-form-label text-md-end" style="font-size:medium">
                                            <input class="form-check-input" type="radio" name="ward_office" id="officeRadio" required>{{ __('     Office') }}
                                        </label>
                                    </div>                    
                                    
                                    
                                        {{-- <input id="office" type="text" class="form-control @error('office') is-invalid @enderror" name="office" value="{{ old('office') }}" required autocomplete="office" autofocus> --}}
                                        <select class="form-control @error('office') is-invalid @enderror" id="office" name="office" required autocomplete="office" autofocus disabled>
                                            <option value="" selected disabled hidden> Choose Office</option>
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                        <option value="{{$office->id}}">
                                                {{$office->office_name}}
                                            </option>
                                        @endforeach
                                        </select>
                                        @error('office')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    
                                </div>
                            </div> 
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">                      
                                    <label for="availableProducts" class="input-group-text">{{ __('Issued Products') }}</label>
                                    </div>                    
                                        <input id="availableProducts" type="number" class="form-control @error('availableProducts') is-invalid @enderror" name="availableProducts" value="{{ old('availableProducts') }}" required readonly="readonly" autocomplete="availableProducts" autofocus>
                                        <input id="availableProductsOriginal" type="number" class="form-control @error('availableProductsOriginal') is-invalid @enderror" name="availableProductsOriginal" value="" required readonly="readonly" autocomplete="availableProductsOriginal" hidden autofocus>
                                        <input id="productIds" type="text" class="form-control @error('productIds') is-invalid @enderror" name="productIds" value="" required readonly="readonly" autocomplete="productIds"  autofocus hidden>
                                        @error('availableProducts')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>   

                            <div class="w-100"></div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">                            
                                    <div class="input-group-prepend">
                                        <label for="material_used" class="input-group-text">{{ __('Material used') }}</label>
                                    </div>
                                        <select class="form-control @error('material_used') is-invalid @enderror" id="material_used" name="material_used" required readonly="readoonly" autocomplete="material_used" autofocus >
                                            <option value="" selected disabled hidden> Choose Material</option>                                                                                   
                                            {{-- @foreach($productsList as $product)     
                                                                                                    
                                                <option value="{{$product->raw_material_id}}">
                                                    {{$product->raw_material_stock_number}} : {{$product->material_used}}
                                                </option>
                                            @endforeach --}}
                                        
                                        </select>
                                        @error('material_used')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">                            
                                    <div class="input-group-prepend">
                                        <label for="finishedProduct" class="input-group-text">{{ __('Finished Products') }}</label>
                                    </div>
                                        <select class="form-control @error('finishedProduct') is-invalid @enderror" id="finishedProduct" name="finishedProduct" required autocomplete="finishedProduct" readonly="readonly" autofocus >
                                            <option value="" selected disabled hidden> Choose Product</option>                                                                                   
                                        
                                        
                                        </select>
                                        @error('finsihedProduct')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">                      
                                    <label for="quantity" class="input-group-text">{{ __('Total Quantity') }}</label>
                                    </div>                    
                                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}"  readonly="readonly" autocomplete="quantity" autofocus>
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>    
                            

                            <div class="w-100"></div>
                            <div class="col" >
                                <div class="card" >
                                    
                                    <div class="card-body">
                                        
                                        <ul class="list-group" id="listProducts" >
                                        
                                        </ul> 

                                
                                
                                    </div>    
                                
                                </div>
                            </div>
                            <div class="col" >
                                <div class="card text-center" >
                                    <div class="card-header">{{ __('RETURN ITEMS') }}</div>
                                    <div class="card-body">
                                        
                                        


                                        <button type="submit" class="btn btn-primary " >Return Items</button>  

                                    </div> 
                                      
                                </div>
                    
                        
                        </div>    
                    </fieldset>
                </form>            
            </div>
            <div class="col-md-6">
                <form class = 'card p-3 bg-light' action = "condemned" method = "post">
                    @csrf
                    <fieldset>
                        <legend>Condemned Products <legend>
                        <div class="row">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">                      
                                        <label for="wardCondemn" class="col col-form-label text-md-end" style="font-size:medium"> 
                                            <input class="form-check-input" type="radio" name="ward_officeCondemn" id="wardRadioCondemn" required >{{ __('     Ward') }}
                                        </label>
                                    </div>                    
                                    
                                
                                        <select class="form-control @error('wardCondemn') is-invalid @enderror" id="wardCondemn" name="wardCondemn" required autocomplete="wardCondemn" autofocus disabled>
                                            <option value="" selected disabled hidden> Choose Ward</option>
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                        <option value="{{$ward->id}}">
                                                {{$ward->ward_name}}
                                            </option>
                                        @endforeach
                                        </select>
                                        @error('wardCondemn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <label for="officeCondemn" class="col col-form-label text-md-end" style="font-size:medium">
                                            <input class="form-check-input" type="radio" name="ward_officeCondemn" id="officeRadioCondemn" required>{{ __('     Office') }}
                                        </label>
                                    </div>                    
                                    
                                    
                                        {{-- <input id="office" type="text" class="form-control @error('office') is-invalid @enderror" name="office" value="{{ old('office') }}" required autocomplete="office" autofocus> --}}
                                        <select class="form-control @error('officeCondemn') is-invalid @enderror" id="officeCondemn" name="officeCondemn" required autocomplete="officeCondemn" autofocus disabled>
                                            <option value="" selected disabled hidden> Choose Office</option>
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                        <option value="{{$office->id}}">
                                                {{$office->office_name}}
                                            </option>
                                        @endforeach
                                        </select>
                                        @error('officeCondemn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    
                                </div>
                            </div> 
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">                      
                                    <label for="availableProductsCondemn" class="input-group-text">{{ __('Issued Products') }}</label>
                                    </div>                    
                                        <input id="availableProductsCondemn" type="number" class="form-control @error('availableProductsCondemn') is-invalid @enderror" name="availableProductsCondemn" value="{{ old('availableProductsCondemn') }}" required readonly="readonly" autocomplete="availableProductsCondemn" autofocus>
                                        <input id="availableProductsOriginalCondemn" type="number" class="form-control @error('availableProductsOriginalCondemn') is-invalid @enderror" name="availableProductsOriginalCondemn" value="" required readonly="readonly" autocomplete="availableProductsOriginalCondemn" hidden autofocus>
                                        <input id="productIdsCondemn" type="text" class="form-control @error('productIdsCondemn') is-invalid @enderror" name="productIdsCondemn" value="" required readonly="readonly" autocomplete="productIdsCondemn"  autofocus hidden>
                                        @error('availableProductsCondemn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>   

                            <div class="w-100"></div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">                            
                                    <div class="input-group-prepend">
                                        <label for="material_usedCondemn" class="input-group-text">{{ __('Material used') }}</label>
                                    </div>
                                        <select class="form-control @error('material_usedCondemn') is-invalid @enderror" id="material_usedCondemn" name="material_usedCondemn" required readonly="readoonly" autocomplete="material_usedCondemn" autofocus >
                                            <option value="" selected disabled hidden> Choose Material</option>                                                                                   
                                            {{-- @foreach($productsList as $product)     
                                                                                                    
                                                <option value="{{$product->raw_material_id}}">
                                                    {{$product->raw_material_stock_number}} : {{$product->material_used}}
                                                </option>
                                            @endforeach --}}
                                        
                                        </select>
                                        @error('material_usedCondemn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">                            
                                    <div class="input-group-prepend">
                                        <label for="finishedProductCondemn" class="input-group-text">{{ __('Finished Products') }}</label>
                                    </div>
                                        <select class="form-control @error('finishedProductCondemn') is-invalid @enderror" id="finishedProductCondemn" name="finishedProductCondemn" required autocomplete="finishedProductCondemn" readonly="readonly" autofocus >
                                            <option value="" selected disabled hidden> Choose Product</option>                                                                                   
                                        
                                        
                                        </select>
                                        @error('finsihedProductCondemn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">                      
                                    <label for="quantityCondemn" class="input-group-text">{{ __('Total Quantity') }}</label>
                                    </div>                    
                                        <input id="quantityCondemn" type="number" class="form-control @error('quantityCondemn') is-invalid @enderror" name="quantityCondemn" value="{{ old('quantityCondemn') }}"  readonly="readonly" autocomplete="quantityCondemn" autofocus>
                                        @error('quantityCondemn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>    
                            

                            <div class="w-100"></div>
                            <div class="col" >
                                <div class="card" >
                                    
                                    <div class="card-body">
                                        
                                        <ul class="list-group" id="listProductsCondemn" >
                                        
                                        </ul> 

                                
                                
                                    </div>    
                                
                                </div>
                            </div>
                            <div class="col" >
                                <div class="card text-center" >
                                    <div class="card-header">{{ __('CONDEMN ITEMS') }}</div>
                                    <div class="card-body">
                                        
                                        


                                        <button type="submit" class="btn btn-primary " >Condemn Items</button>  

                                    </div> 
                                      
                                </div>
                    
                        
                        </div>    
                    </fieldset>
                </form>            
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
                    <div class="card-header text-white" style="background-color: #238d14;">{{ __('Issued Products') }}</div>
                    <br>
                    <table id="productsTable" class="table  table-bordered table-success" style="width:100%">
                        <thead>
                          <tr>
                            <th>id</th>
                            <th>STOCK-NUMBER</th>
                            <th>MATERIAL USED</th>    
                            <th>RAW MATERIAL <br> AVAILABLE QUANTITY</th>                                                  
                            <th>PRODUCT</th>
                            <th>PRODUCT <br> UNIT</th>
                            <th>AVAILABLE <br> QUANTITY</th>
                            <th>TOTAL <br> CONDEMNED</th> 
                            <th>ORIGINAL TOTAL <br> QUANTITY</th>                           
                            <th>UNIT <br> COST</th>
                            <th>TOTAL <br> COST</th>                           
                            <th>STOCK ROOM</th>
                            <th>STORAGE</th>
                            <th>AVAILABLE</th>
                            <th>CONDEMNED</th> 
                            <th>WARD/OFFICE</th>                
                            <th>DATE CREATED</th>                            
                            {{-- <th>DELETE</th> --}}
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($productsList as $products)                                                                
                          <tr id={{$products->id}}>
                            <td>{{$products->id}}</td>
                            <td id="{{$products->product_stock_id}}" style="background-color:#39bedf">{{$products->product_stock_id}}</td>
                            <td id="{{$products->raw_material_id}}" style="background-color:#39bedf">{{$products->material_used}}</td>
                            <td id="raw_material_quantity" style="background-color:#39bedf">{{$products->raw_material_quantity}}</td>                            
                            <td id="product_name">{{$products->product_name}}</td>
                            <td id="product_unit">{{$products->product_unit}}</td>
                            <td id="product_available_quantity">{{$products->product_available_quantity}}</td>  
                            <td id="product_condemned_quantity">{{$products->product_condemned_quantity}}</td> 
                            <td id="product_quantity">{{$products->product_quantity}}</td>                            
                            <td id="product_unit_cost">{{$products->product_unit_cost}}</td>
                            <td id="total_cost">{{$products->total_cost}}</td>
                            
                            <td id="{{$products->stock_room_id}}">{{$products->stock_room}}</td>
                            <td id="{{$products->storage_room_id}}">{{$products->storage_name}}</td>
                            @if($products->is_available == 1)
                                <td id="available" style="background-color:#00FF00">YES</td>
                            @else
                                <td id="available" style="background-color:#FF0000">NO</td>
                            @endif
                            @if($products->is_condemned == 1)
                                <td id="condemned" style="background-color:#00FF00">YES</td>
                            @else
                                <td id="condemned" style="background-color:#FF0000">NO</td>
                            @endif

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
                                <td >Not yet issued</td>  
                            @endif
                            <td id="created_date">{{$products->create_date}}</td>
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
                                <form action = "/condemned/delete" method = "post">
                                  @csrf
                                  <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$products->id}}">
                                  <input id="product_bulk_id" type="hidden" class="form-control @error('product_bulk_id') is-invalid @enderror" name="product_bulk_id" value="{{$products->product_bulk_id}}">

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
                    <div class="card-body">
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
    $("#wardRadio, #officeRadio").change(function(){
        console.log('radio ward office');
            
            $("#ward, #office").val("").attr("readonly",true);
            if($("#wardRadio").is(":checked")){
                $("#ward").removeAttr("readonly");
                $("#wardRadio").attr("required",true);
                $("#ward").attr("required",true);
                $("#ward").prop('disabled', false);
                $("#ward").focus();
                $("#office").prop('disabled', true);
            }
            else if($("#officeRadio").is(":checked")){
                $("#office").removeAttr("readonly");
                $("#officeRadio").attr("required",true);
                $("#office").attr("required",true);
                $("#office").prop('disabled', false);
                $("#office").focus();   
                $("#ward").prop('disabled', true);
            }
       
            $("#material_used").find('option').remove(); 
        });  

        

        $("#ward").change(function(){
            console.log($("#ward").val());
            $("#material_used").removeAttr("readonly");
            
            $("#material_used").find('option').remove(); 
            $("#finishedProduct").find('option').remove();     
            $("#material_used").append('<option value="" selected disabled hidden> Choose Material Used</option>'); 
            $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                if($("#ward").val() == value.issued_ward_id){
                    //console.log(value);
                    
                    $("#material_used").append('<option value="'+value.raw_material_id+'">'+value.material_used+'</option>'); 
                }    
            });

            var usedNames = {};
            $("select[name='material_used'] > option").each(function () {
                if(usedNames[this.text]) {
                    $(this).remove();
                } else {
                    usedNames[this.text] = this.value;
                }
            });


            // $("#material_used").change(function() {
            //     let id = $(this).children(":selected").val();
                
            //     $("#finishedProduct").find('option').remove();
            //     $("#finishedProduct").append('<option value="" selected disabled hidden> Choose Product</option>'); 
            //     $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
            //         if($("#ward").val() == value.issued_ward_id){
                   
            //             var optionExists = $("#finishedProduct option[value="+value.product_bulk_id+"]").length > 0;
            //                     console.log(value)
            //             if(value.raw_material_id == id){
            //                 if(optionExists == false){
            //                             $("#finishedProduct").append('<option value="'+value.product_bulk_id+'">'+value.product_name+'</option>'); 
            //                 }
            //             }
            //         }
            //        });
                        
            // }); 
        }); 

        $("#material_used").change(function(){
            let raw_material_id =  $(this).val();
            console.log(raw_material_id);
            $("#finishedProduct").removeAttr("readonly");
            $("#finishedProduct").find('option').remove();
            $("#finishedProduct").append('<option value="" selected disabled hidden> Choose Material Used</option>');
            $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                
                if(value.raw_material_id == raw_material_id){
                    //console.log(value);
                    $("#finishedProduct").append('<option value="'+value.product_bulk_id+'">'+value.product_name+'</option>'); 
                }
            });
            var usedNames = {};
            $("select[name='finishedProduct'] > option").each(function () {
                if(usedNames[this.text]) {
                    $(this).remove();
                } else {
                    usedNames[this.text] = this.value;
                }
            });
            console.log( $("#ward").val());
            $("#finishedProduct").change(function() {   
                    let bulkId = $(this).children(":selected").val();
                    console.log(bulkId);
                    var selectedProductArray = new Array();
                    $("#listProducts").find('ul').remove();
                   
                    
                    let totalQuantity = 0;
                    $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                        if(value.product_bulk_id == bulkId){
                            totalQuantity =value. product_quantity
                        }
                        if(value.product_bulk_id == bulkId && value.is_available == 0 && value.is_condemned == 0 && value.issued_ward_id == $('#ward').val()){
                            console.log(value)
                            selectedProductArray.push(value);
                    
                        }
                        
                    });
                    $('#quantity').val(totalQuantity);
                    $('#availableProductsOriginal').val(selectedProductArray.length);
                    $('#availableProducts').val(selectedProductArray.length);
                    $("#listProducts").find('li').remove();
                
                    
                        // selectedProductArray.sort(function(a, b) {
                        // var nameA = a.id.toUpperCase(); // ignore upper and lowercase
                        // var nameB = b.id.toUpperCase(); // ignore upper and lowercase
                        // if (nameA < nameB) {
                        //     return -1;
                        // }
                        // if (nameA > nameB) {
                        //     return 1;
                        // }

                        // // names must be equal
                        // return 0;
                        // });
                        console.log(selectedProductArray);
                        $.each(selectedProductArray, function(key, value) {
                            let office_ward ="";
                            if(value.office_name != null){
                                office_ward = value.office_name;
                            }else if(value.ward_name != null){
                                office_ward = value.ward_name;
                            }else{
                                office_ward = "Not yet issued";
                            }
                            $('#listProducts').append(  
                                            `<li class="list-group-item">                                
                                                    <div class="form-check">                            
                                                        <input class="form-control form-check-input" type="checkbox"  value="" id="${value.id}">
                                                        <label class="form-control form-check-label checkbox-inline" style="font-size:small" for="${value.id}">
                                                        ${value.product_stock_id} - ${value.product_name} - ${office_ward}
                                                        </label>
                                                    </div>                                    
                                            </li>`);

                        });
            
            });

        });

        
        $("#office").change(function(){
        console.log('office change');
        console.log($("#office").val());
            $("#material_used").removeAttr("readonly");
            
            $("#material_used").find('option').remove(); 
            $("#finishedProduct").find('option').remove();     
            $("#material_used").append('<option value="" selected disabled hidden> Choose Material Used</option>'); 
            $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                if($("#office").val() == value.issued_office_id){
                    //console.log(value);
                    
                    $("#material_used").append('<option value="'+value.raw_material_id+'">'+value.material_used+'</option>'); 
                }    
            });

            var usedNames = {};
            $("select[name='material_used'] > option").each(function () {
                if(usedNames[this.text]) {
                    $(this).remove();
                } else {
                    usedNames[this.text] = this.value;
                }
            });

      
        }); 

        $("#wardRadioCondemn, #officeRadioCondemn").change(function(){
        console.log('radio ward office');
            
            $("#wardCondemn, #officeCondemn").val("").attr("readonly",true);
            if($("#wardRadioCondemn").is(":checked")){
                $("#wardCondemn").removeAttr("readonly");
                $("#wardRadioCondemn").attr("required",true);
                $("#wardCondemn").attr("required",true);
                $("#wardCondemn").prop('disabled', false);
                $("#wardCondemn").focus();
                $("#officeCondemn").prop('disabled', true);
            }
            else if($("#officeRadioCondemn").is(":checked")){
                $("#officeCondemn").removeAttr("readonly");
                $("#officeRadioCondemn").attr("required",true);
                $("#officeCondemn").attr("required",true);
                $("#officeCondemn").prop('disabled', false);
                $("#officeCondemn").focus();   
                $("#wardCondemn").prop('disabled', true);
            }
       
            $("#material_usedCondemn").find('option').remove(); 
        });  

        

        $("#wardCondemn").change(function(){
            console.log($("#ward").val());
            $("#material_usedCondemn").removeAttr("readonly");
            
            $("#material_usedCondemn").find('option').remove(); 
            $("#finishedProductCondemn").find('option').remove();     
            $("#material_usedCondemn").append('<option value="" selected disabled hidden> Choose Material Used</option>'); 
            $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                if($("#wardCondemn").val() == value.issued_ward_id){
                    //console.log(value);
                    
                    $("#material_usedCondemn").append('<option value="'+value.raw_material_id+'">'+value.material_used+'</option>'); 
                }    
            });

            var usedNamesCondemn = {};
            $("select[name='material_usedCondemn'] > option").each(function () {
                if(usedNamesCondemn[this.text]) {
                    $(this).remove();
                } else {
                    usedNamesCondemn[this.text] = this.value;
                }
            });

        }); 

        $("#material_usedCondemn").change(function(){
            let raw_material_idCondemn =  $(this).val();
            console.log(raw_material_idCondemn);
            $("#finishedProductCondemn").removeAttr("readonly");
            $("#finishedProductCondemn").find('option').remove();
            $("#finishedProductCondemn").append('<option value="" selected disabled hidden> Choose Material Used</option>');
            $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                
                if(value.raw_material_id == raw_material_idCondemn){
                    console.log(value.raw_material_id , raw_material_idCondemn);
                    $("#finishedProductCondemn").append('<option value="'+value.product_bulk_id+'">'+value.product_name+'</option>'); 
                }
            });
            var usedNamesCondemn = {};
            $("select[name='finishedProductCondemn'] > option").each(function () {
                if(usedNamesCondemn[this.text]) {
                    $(this).remove();
                } else {
                    usedNamesCondemn[this.text] = this.value;
                }
            });
            console.log( $("#wardCondemn").val());
            $("#finishedProductCondemn").change(function() {   
                    let bulkIdCondemn = $(this).children(":selected").val();
                    console.log(bulkIdCondemn);
                    var selectedProductArrayCondemn = new Array();
                    $("#listProductsCondemn").find('ul').remove();
                   
                    
                    let totalQuantityCondemn = 0;
                    $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                        if(value.product_bulk_id == bulkIdCondemn){
                            totalQuantityCondemn =value. product_quantity
                        }
                        if(value.product_bulk_id == bulkIdCondemn && value.is_available == 0 && value.is_condemned == 0 && value.issued_ward_id == $('#wardCondemn').val()){
                            console.log(value)
                            selectedProductArrayCondemn.push(value);
                    
                        }
                        
                    });
                    $('#quantityCondemn').val(totalQuantityCondemn);
                    $('#availableProductsOriginalCondemn').val(selectedProductArrayCondemn.length);
                    $('#availableProductsCondemn').val(selectedProductArrayCondemn.length);
                    $("#listProductsCondemn").find('li').remove();
                
                    
                        // selectedProductArray.sort(function(a, b) {
                        // var nameA = a.id.toUpperCase(); // ignore upper and lowercase
                        // var nameB = b.id.toUpperCase(); // ignore upper and lowercase
                        // if (nameA < nameB) {
                        //     return -1;
                        // }
                        // if (nameA > nameB) {
                        //     return 1;
                        // }

                        // // names must be equal
                        // return 0;
                        // });
                        console.log(selectedProductArrayCondemn);
                        $.each(selectedProductArrayCondemn, function(key, value) {
                            let office_wardCondemn ="";
                            if(value.office_name != null){
                                office_wardCondemn = value.office_name;
                            }else if(value.ward_name != null){
                                office_wardCondemn = value.ward_name;
                            }else{
                                office_wardCondemn = "Not yet issued";
                            }
                            $('#listProductsCondemn').append(  
                                            `<li class="list-group-item">                                
                                                    <div class="form-check">                            
                                                        <input class="form-control form-check-input" type="checkbox"  value="" id="${value.id}">
                                                        <label class="form-control form-check-label checkbox-inline" style="font-size:small" for="${value.id}">
                                                        ${value.product_stock_id} - ${value.product_name} - ${office_wardCondemn}
                                                        </label>
                                                    </div>                                    
                                            </li>`);

                        });
            
            });

        });

        
        $("#officeCondemn").change(function(){
        console.log('office change');
        console.log($("#officeCondemn").val());
            $("#material_usedCondemn").removeAttr("readonly");
            
            $("#material_usedCondemn").find('option').remove(); 
            $("#finishedProductCondemn").find('option').remove();     
            $("#material_usedCondemn").append('<option value="" selected disabled hidden> Choose Material Used</option>'); 
            $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
                if($("#officeCondemn").val() == value.issued_office_id){
                    //console.log(value);
                    
                    $("#material_usedCondemn").append('<option value="'+value.raw_material_id+'">'+value.material_used+'</option>'); 
                }    
            });

            var usedNamesCondemn = {};
            $("select[name='material_usedCondemn'] > option").each(function () {
                if(usedNamesCondemn[this.text]) {
                    $(this).remove();
                } else {
                    usedNamesCondemn[this.text] = this.value;
                }
            });

      
        }); 




    $('#productsTable').DataTable({
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

//condemned

$(document).change(function () {
    let productIds =[]
    $('input:checkbox').each(function (i) {
        if($(this).prop("checked") == true){                    
            productIds.push($(this).attr('id'));
        }                
    });

    $('#productIds').val(productIds);

    let productIdsCondemn =[]
    $('#listProductsCondemn input:checkbox').each(function (i) {
        if($(this).prop("checked") == true){                    
            productIdsCondemn.push($(this).attr('id'));
        }                
    });

    $('#productIdsCondemn').val(productIdsCondemn);

    
});

     
</script>    
<style>
input[type=checkbox] , {
    transform: scale(0.5);
}
 body {
    -moz-transform: scale(0.9, 0.9); /* Moz-browsers */
    zoom: 0.9; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
} 
    
</style> 
@endpush