@extends('layouts.appHome')

@section('content')
<div class="container">
  <div class="row">        
    <div class="col">
        <form class = 'card p-3 bg-light' action = "/newRequest" method = "post">
            @csrf
            <fieldset>
            <legend>REQUEST PRODUCT FOR
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
              <legend>
                 
                    <div class="row">
                        <div class="col-8">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">                      
                                <label for="product_name" class="input-group-text">{{ __('Product Name') }}</label>
                                </div>                    
                                <input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ old('product_name') }}" required autocomplete="product_name"  autofocus>
                                @error('product_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                            </div>
                        </div>
                        <div class="col-4">
                        <div class="input-group input-group-sm mb-3"> 
                            <div class="input-group-prepend">                      
                                <label for="product_quantity" class="input-group-text">{{ __('Product Quantity') }}</label>
                                </div>                    
                                <input id="product_quantity" type="number" class="form-control @error('product_quantity') is-invalid @enderror" name="product_quantity" value="{{ old('product_quantity') }}" required autocomplete="product_quantity"  autofocus>
                                @error('product_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror          
                            
                            
                                        
                        </div>
                    </div>
                        
                        <div class="w-100"></div>
                    </div>
                    
              

                        <button type="submit" class="btn btn-primary">Create Request</button>
               
            </fieldset>

        </form>
    </div>
</div>    
</div>    


   
@endsection



@push('scripts')

<script>
$(document).ready(function () {


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