@extends('layouts.appHome')

@section('content')
<div class="row">
    <div class="container d-print-none">
        <div class="row justify-content-center">        
            <div class="col-9">
                <form id="myForm" class = 'card p-3 bg-light' action = "issueProduct" method = "post">
                    <fieldset>
                    <legend>Issue Products <legend>
                    <div class="row">
                        <div class="col">
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
                        <div class="col">
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
                        <div class="col">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">                      
                                <label for="availableProducts" class="input-group-text">{{ __('Available Products') }}</label>
                                </div>                    
                                    <input id="availableProducts" type="number" class="form-control @error('availableProducts') is-invalid @enderror" name="availableProducts" value="" required readonly="readonly" autocomplete="availableProducts" autofocus>
                                    <input id="availableProductsOriginal" type="number" class="form-control @error('availableProductsOriginal') is-invalid @enderror" name="availableProductsOriginal" value="" required readonly="readonly" autocomplete="availableProductsOriginal"  autofocus>
                                    <input id="productIds" type="text" class="form-control @error('productIds') is-invalid @enderror" name="productIds" value="" required readonly="readonly" autocomplete="productIds"  autofocus hidden>
                                    @error('availableProducts')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                    
                            </div>
                        </div>
                        {{-- <div class="col">
                        <div class="input-group input-group-sm mb-3"> 
                            
                            @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)  
                                @if( Auth::user()->ward_id  == $ward->id)
                                <label>{{$ward->ward_name}}</label>
                                @endif 
                            @endforeach
    
                            @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                @if( Auth::user()->office_id  == $office->id)
                                    <label>{{$office->office_name}}</label>
                                @endif
                            @endforeach
                                        
                        </div>
                        </div> --}}
                        
                        <div class="w-100"></div>
                        <div class="col" >
                            <div class="card" >
                                <div class="card-header">{{ __('AVAILABLE ITEMS') }}</div>
                                <div class="card-body">
                                    <div id ="listProducts"></div>
                                    {{-- <ul class="list-group" >
                                       
                                      </ul> --}}
    
                               
                               
                                </div>    
                            
                            </div>
                        </div>
                        <div class="col" >
                            <div class="card" >
                                <div class="card-header">{{ __('ISSUE ITEMS') }}</div>
                                <div class="card-body">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">                      
                                        <label for="quantity" class="input-group-text">{{ __('Quantity') }}</label>
                                        </div>                    
                                            <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" autofocus>
                                            @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                    
                                    </div>
                                
                                        @csrf
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
        
                                        @if($message = Session::get('requestId'))       
                                            
                                        <input id="requestId" type="hidden" class="form-control @error('requestId') is-invalid @enderror" name="requestId" value="{{$message}}">  
                                        @endif
                                        <input id="itemsIssuedListObject" type="hidden" class="form-control @error('itemsIssuedListObject') is-invalid @enderror" name="itemsIssuedListObject" value="">  

        
        
                                    </div> 
                                    <div class="card-footer text-center">
                                        <button type="button" id="issueItems" class="btn btn-primary " disabled >Add</button>
                                        <button type="button" id="removeItemsBtn" class="btn btn-primary " >Remove</button>
                                        <button type="button" id="printItems" class="btn btn-primary " >Print</button>
                                        {{-- <button type="submit" class="btn btn-primary " >Submit</button>  --}}
                                    
                                    </div>
                                </form>       
                            </div>
                            
                        </div>
                        
                    
                    </div>
                    <br>
                       
                    </fieldset>
    
                
            </div>
            <input id="trId" type="hidden" value="">
            <input id="tdUnit" type="hidden" value="">
            <input id="tdItem" type="hidden" value="">
            <input id="tdCost" type="hidden" value="">
            <input id="tdDateIssued" type="hidden" value="{{\Carbon\Carbon::now()->format('F d,Y')}}">
            <input id="tdMaterial" type="hidden" value="">
            
        </div>    
    </div> 
</div>    
    <br>
<div class="row" id = "issuanceForm" hidden>    
    <div class="container ">
        <div class="col-md-9 mx-auto">  
        <div class="row justify-content-center">
          <div class="col-2 border border-dark border-bottom-0"><br>

            <img src="../img/bghmc.png" class="mx-auto d-block" width="120" height="120" alt="">
            <br>
          </div>
          <div class="col-10 border border-dark border-left-0 border-bottom-0">
            <div class="row">
                <div class="col-12 border border-light border-left-0 border-top-0 border-right-0" >
                    <div class="text-center"><small>Republic of the Philippines</small></div>
                    <div class="text-center"><small>Department of Health</small></div>
                    <div class="text-center text-uppercase font-weight-bold">baguio general hospital and medical
                        center</small> </div>
                    <div class="text-center"><small>Baguio City</small> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8 border border-dark border-left-0 border-bottom-0 border-top-0">                                    
                    <div class="text-center mt-3">
                        <span class="font-weight-bold">GENERAL SERVICES SECTION - LINEN ROOM</span>
                        <h5 class="font-weight-bold">INVENTORY (LINEN) CUSTODIAN SLIP</h5>
                    </div>
                </div>
                <div class="col-2 " > 
                    <div class="row border border-dark border-left-0 border-bottom-0 border-top-0">
                         Form No.:
                    </div>
                    <div class="row border border-left-0 ">
                         Rev.No:
                    </div>
                    <div class="row border border-left-0 border-bottom-0 border-top-0">
                         Effectivity Date:
                    </div>
                </div>
                <div class="col-2 "> 
                    <div class="row justify-content-center border border-dark  border-left-0 border-bottom-0 border-top-0 border-right-0">
                        HS - GSS - 008
                    </div>
                    <div class="row justify-content-center border border-dark  border-left-0 border-right-0">
                        1
                    </div>
                    <div class="row justify-content-center border border-dark  border-left-0 border-bottom-0 border-top-0 border-right-0">
                        August 16, 2019
                    </div>
                </div>

            </div>
          </div>
          
        </div>
        <div class="row justify-content-center">
            <div class="col-12 border border-dark "><br>
                
               
                <table class="table table-sm table-bordered " id="itemsTable">
                        <thead>
                            <tr class="text-center">
                                <th width='10%'>QUANTITY</th>
                                <th width='10%'>UNIT</th>
                                <th width='40%'>ITEM DESCRIPTION</th>
                                <th width='10%'>UNIT AMOUNT</th>
                                <th width='10%'>TOTAL AMOUNT</th>
                                <th width='10%'>DATE ISSUED</th>                                
                                <th width='10%'>REMARKS</th>
                            </tr>
                          </thead>
                          <tbody id="issueItemsTbody">
                            
                            
                            
                            
                            
                          </tbody>
                          <tfoot class="text-center">
                              <tr>
                               
                                    <td colspan="3" ><strong>
                                        RECEIVED BY:</strong> <br>
                                        __________________________<br>
                                        Signature Over Printed Name<br>
                                        __________________________<br>
                                        Position<br>
                                        Date:
                                    </td>
                                    
                                  <td colspan ="4" ><strong>RECEIVED FROM:</strong><br>
                                    __________________________<br>
                                    Signature Over Printed Name<br>
                                    __________________________<br>
                                    Position<br>
                                    Date:
                                  </td>
                                </div>  
                              </tr> 

                            </tfoot>
                       
                </table> 
            </div>
              
            
        </div>
    </div>
    </div>  
</div>

@endsection



@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />     
<script>

$(document).ready(function () {
    var issuedItemsList = [];
    var selectedItemCount = 0;
    var availableCount = 0;
    $("#issueItems").click(function(event) {

        event.preventDefault();

        if($('#availableProducts').val() <= 0 || $("#ward").val() == null || $("#office").val() == null){
            //console.log("disable add button");
            $(this).attr("disabled",true);
        }

        $('#issuanceForm').removeAttr("hidden",false);
        let quantity = $('#quantity').val();
        let unit = $('#tdUnit').val();
        let item = $('#tdItem').val();
        let cost = $('#tdCost').val();
        let issuedDate = $('#tdDateIssued').val();
        let trId = $('#trId').val();
        let totalCost = quantity*cost;
        let productIds = $('#productIds').val();

       
        issuedItemsList.push({               
               availableProducts : $('#availableProducts').val(),              
               finishedProduct : $('#trId').val(),                
               availableProductsOriginal : $('#availableProductsOriginal').val(),
               productIds : $('#productIds').val(),
               quantity : $('#quantity').val(),
               ward : $("#ward").val(),
               office : $("#office").val(),
               });
        
        //console.log(issuedItemsList);
        $('#itemsIssuedListObject').val(JSON.stringify(issuedItemsList));
        productIdsArray = $('#productIds').val().split(',');
        //console.log(productIdsArray);
        // $("#listProducts").find('[data-id="639"]').remove();
        productIdsArray.forEach(removeItems);      

                $("#issueItemsTbody").append(
                    `<tr class="text-center" id =${productIds}>
                        <td width="10%">${quantity}</td>
                        <td width="10%" id="unit">${unit}</td>
                        <td width="40%">${item}</td>
                        <td width="10%">${cost}</td>
                        <td width="10%">${totalCost}</td>
                        <td width="10%">${issuedDate}</td>
                        <td width="10%"></td>
                    </tr> `   
                ); 
                
                $.ajax({
                    headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                        },
                    url:"/issueProduct",
                    type:"POST",
                    data:{
                        availableProducts : $('#availableProducts').val(),              
                        finishedProduct : $('#trId').val(),                
                        availableProductsOriginal : $('#availableProductsOriginal').val(),
                        productIds : $('#productIds').val(),
                        quantity : $('#quantity').val(),
                        ward : $("#ward").val(),
                        office : $("#office").val(),
                        },
                    success:function(response){
                        $('#quantity').val(0);
                        selectedItemCount = 0;
                        $("#wardRadio, #officeRadio").prop('checked', false);
                        //console.log('radio ward office reset');
                            
                        $("#ward, #office").val("").attr("readonly",true);
                             
                            toastr.success("Items issued successfully!", 'Success');                 
                        
                    
                    },
                    error: function(error) {
                    //console.log(error);
                    }
                });    
             

    });

    function removeItems(item, index) {
        $("#listProducts").find(`[data-id="${item}"]`).remove()
    }

    // $(function() {
    //   $('#itemsTable').on('click', 'tbody tr', function(event) {
    //     $(this).addClass('highlight').siblings().removeClass('highlight');
    //   });

    //   $('#removeItems').click(function(e) {
    //     var rows = getHighlightRow();
    //     if (rows != undefined) {
    //       rows.remove();
    //     }
    //   });

    //   var getHighlightRow = function() {
    //     return $('table > tbody > tr.highlight');
    //   }

    // });

    $(function() {
      $('#itemsTable').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
        //console.log($(this));
      });
      
      $('#removeItemsBtn').click(function(e) {
        var rows = getHighlightRow();
        if (rows != undefined) {
          rows.remove();
          //console.log(rows.attr('id'));
          let requestId = $('#requestId').val()
          //console.log(requestId);
          bulkId = $('#trId').val();
          availableQuantityOld = parseInt($('#availableProducts').val());     
          $.ajax({
                    headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                        },
                    url:"/retrieveItemsList",
                    type:"GET",
                    data:{                        
                        productIds : rows.attr('id'),  
                        bulkId : bulkId                      
                        },
                    success:function(response){
                        console.log(response);  
                        
                        // $.each(response, function(key, value) {
                                                               
                        //         $('#listProducts').prepend(  
                        //                         `<li class="list-group-item" data-id="${value.id}">
                        //                         <div class="form-check">                            
                        //                             <input class="form-control form-check-input" type="checkbox"  value="" id="${value.id}">
                        //                             <label class="form-control form-check-label checkbox-inline" style="font-size:small; background-color:#FF5252;" for="${value.id}">
                        //                             ${value.product_stock_id} - ${value.product_name}
                        //                             </label>
                        //                         </div>
                                                
                        //                         </li>`);
                                            
                        //     });     
                        // $('#availableProducts').val(availableQuantityOld + response.length ); 
                        // $('#availableProductsOriginal').val(availableQuantityOld + response.length );   
                        
                        // //console.log($('#availableProducts').val())        +
                        //console.log("-----------", + availableCount, $('#finishedProduct').children(":selected").val());
                            let bulkId = $(finishedProduct).children(":selected").val();
                            var selectedProductArray = new Array();
                            $("#listProducts").find('div').remove();
                            
                            //console.log(bulkId);
                            $.each(response, function(key, value) {
                                if(value.product_bulk_id == bulkId && value.is_available == 1){
                                    selectedProductArray.push(value);
                            
                                }
                            
                            });
                            console.log(selectedProductArray);
                            $('#availableProductsOriginal').val(selectedProductArray.length);
                            $('#availableProducts').val(selectedProductArray.length);
                            availableCount = selectedProductArray.length;
                            $("#listProducts").find('li').remove();
                        
                                $.each(selectedProductArray, function(key, value) {
                                    // while(selectedProductArray.length) {
                                    //     //console.log(selectedProductArray.splice(0,10));
                                    // }  
                                    //console.log(value); 
                                    $('#tdUnit').val(value.product_unit);
                                    $('#tdItem').val(value.product_name);
                                    $('#tdCost').val(value.product_unit_cost);
                                    $('#trId').val(value.product_bulk_id);
                                    $('#listProducts').append(  
                                                    `<li class="list-group-item" data-id="${value.id}">
                                                    <div class="form-check">                            
                                                        <input class="form-control form-check-input" type="checkbox"  value="" id="${value.id}">
                                                        <label class="form-control form-check-label checkbox-inline" style="font-size:small" for="${value.id}">
                                                        ${value.product_stock_id} - ${value.product_name}
                                                        </label>
                                                    </div>
                                                    
                                                    </li>`);
                                                
                                });
                    },
                    error: function(error) {
                        //console.log(error);
                    }
                }); 
        }
      });


      var getHighlightRow = function() {
        return $('table > tbody > tr.highlight');
      }

    }); 

    $("#printItems").click(function() {
        window.print();
        window.onafterprint = function(){
        //console.log("Printing completed...");
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

$("#material_used").change(function() {
    
        let id = $(this).children(":selected").val();
        $('#tdMaterial').val(id);
        
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
    
    let bulkId = $(finishedProduct).children(":selected").val();
    var selectedProductArray = new Array();
    $("#listProducts").find('div').remove();
    
    //console.log(bulkId);
    $.each({!! json_encode($productsList, JSON_HEX_TAG) !!}, function(key, value) {
        if(value.product_bulk_id == bulkId && value.is_available == 1){
            selectedProductArray.push(value);
    
        }
    
    });
    //console.log(selectedProductArray);
    $('#availableProductsOriginal').val(selectedProductArray.length);
    $('#availableProducts').val(selectedProductArray.length);
    availableCount = selectedProductArray.length;
    $("#listProducts").find('li').remove();
   
        $.each(selectedProductArray, function(key, value) {
            // while(selectedProductArray.length) {
            //     //console.log(selectedProductArray.splice(0,10));
            // }  
            //console.log(value); 
            $('#tdUnit').val(value.product_unit);
            $('#tdItem').val(value.product_name);
            $('#tdCost').val(value.product_unit_cost);
            $('#trId').val(value.product_bulk_id);
            $('#listProducts').append(  
                            `<li class="list-group-item" data-id="${value.id}">
                            <div class="form-check">                            
                                <input class="form-control form-check-input" type="checkbox"  value="" id="${value.id}">
                                <label class="form-control form-check-label checkbox-inline" style="font-size:small" for="${value.id}">
                                ${value.product_stock_id} - ${value.product_name}
                                </label>
                            </div>
                            
                            </li>`);
                        
        });

    

    availableCount = selectedProductArray.length;
    //console.log("*********" + availableCount);

       
    
    });
    
    $("#wardRadio, #officeRadio").change(function(){
        //console.log('radio ward office');
            
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

            $("#issueItems").removeAttr('disabled',false);
        });   

    $("#quantity").change(function(i){
        $( '#listProducts input[type="checkbox"]' ).prop( "checked", false );
        oldValueProducts = $('#availableProductsOriginal').val();

        $('input:checkbox').each(function (i) {
            var current = $(this);
                current.prop("checked",true);
              
            return i<$("#quantity").val()-1;
        });

        $('#availableProducts').val(oldValueProducts-$(this).val())
        //console.log("availableProducts: " ,$(this).val());
    });
    $('#productsTable').DataTable(
        {
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
       }         
      ); 
       
      $('.printMe').click(function () {
                window.print();
                // pop_searchPatient();
            });


          
   $('#listProducts').on('click' ,'.form-check-input',function(){
       
       
           if($(this).prop("checked") == true){
               //console.log("Checkbox is checked.",$(this).attr('id'));
               availableCount --;
               selectedItemCount ++;
               
           }
           else if($(this).prop("checked") == false){
               //console.log("Checkbox is unchecked.",$(this).attr('id'));
               availableCount ++;
               selectedItemCount --;
              
           }
          
           $('#quantity').val(selectedItemCount);
           $('#availableProducts').val(availableCount);
           $('#availableProductsOriginal').val(availableCount);
          
       });      
  
    
})

$(document).change(function () {
    let productIds =[]
    $('input:checkbox').each(function (i) {
        if($(this).prop("checked") == true){                    
            productIds.push($(this).attr('id'));
        }                
    });

    $('#productIds').val(productIds);

    
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

@media print {
             
   
    @page {
                size: landscape !important;
                margin-left: 0.25in;
                margin-right: 0.5in;
                margin-top: 0;
                margin-bottom: 0;
               
            }

            table, th, td {
                        border: 1px solid black !important;
                        }
       
     
    }
        
        body {
            background-color: #fff;
            /* color: #636b6f; */
            font-family: 'Roboto', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .border {
            border: 1px solid black !important;
        }

        .border-right-0 {
            border-right: none !important;
        }

        .border-top-0 {
            border-top: none !important;
        }

        .border-left-0 {
            border-left: none !important;
        }

        .border-bottom-0 {
            border-bottom: none !important;
        }
        table, th, td {
            border: 1px solid black !important;
            }

            td,
th {
  border: 1px solid #999;
  padding: 1.5rem;
}

.row tbody tr.highlight td {
  background-color: #ccc;
}



.button:hover {
  border-top-color: #28597a;
  background: #28597a;
  color: #ccc;
}

.button:active {
  border-top-color: #1b435e;
  background: #1b435e;
} 

     
</style> 
@endpush