@extends('layouts.appHome')

@section('content')
<div class= "container">
<div class="card d-print-none" >
    <div class="card-header">
      GENERATE INVENTORY REPORT FOR 
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
    </div>
    <div class="card-body">
        <form action = "/generateInventoryReport" method = "post">
            @csrf
            <h5 class="card-title">Select Date</h5>
            <div class="row">
                <div class="col-3">
                    <div class="input-group input-group-sm mb-3">                            
                        <div class="input-group-prepend">
                            <label for="start_date" class="input-group-text">{{ __('Start Date') }}</label>
                        </div>
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required autocomplete="start_date" autofocus>

                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                    </div>
                </div> 
                <div class="col-3">
                    <div class="input-group input-group-sm mb-3">                            
                        <div class="input-group-prepend">
                            <label for="end_date" class="input-group-text">{{ __('End Date') }}</label>
                        </div>
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date" autofocus>

                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                    </div>
                </div>
                @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2)
                <div class="col-3">
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
                <div class="col-3">
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
                @else
                @if(Auth::user()->office_id != null)
                        @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                            @if($office->id == Auth::user()->office_id) 
                            
                                
                                <div class="col-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">                      
                                            <label for="office" class="input-group-text">{{ __('Office:') }}</label>
                                            </div>                    
                                            <input id="office" type="text" class="form-control @error('office') is-invalid @enderror" name="office" value="{{$office->office_name}}" required autocomplete="office"  autofocus disabled>
                                            @error('office')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                    
                                        </div>
                                    </div>  
                            @endif
                        @endforeach
                    @elseif(Auth::user()->ward_id != null)
                        @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                        @if($ward->id ==  Auth::user()->ward_id )
                                
                                <div class="col-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">                      
                                        <label for="ward" class="input-group-text">{{ __('Ward:') }}</label>
                                        </div>                    
                                        <input id="ward" type="text" class="form-control @error('ward') is-invalid @enderror" name="ward" value="{{$ward->ward_name}}" required autocomplete="ward"  autofocus disabled>
                                        @error('ward')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                    </div>
                                    </div>
                        @endif
                        @endforeach
                    
                    @endif
                
                
                @endif      
            
                <div class="card-footer text-muted">
                    <button class=" btn btn-primary mt-2 mb-2 d-print-none" type="submit">Generate Report</button>
                    <button class="printMe btn btn-primary mt-2 mb-2 d-print-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                        </svg>
                        Print</button>
                </div>
            </div>
        </form>    
       
    </div>
    
</div>
<br>
<div class="row">

                
    <div class="container ">
        <div class="row justify-content-center">
          <div class="col-2 border border-dark border-bottom-0"><br>

            <img src="../img/bghmc.png" class="mx-auto d-block" width="120" height="120" alt="">
            <br>
          </div>
          <div class="col-9 border border-dark border-left-0 border-bottom-0">
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
                        <span class="font-weight-bold">LINEN ROOM UNIT</span>
                        <h5 class="font-weight-bold">INVENTORY OF LINENS</h5>
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
                        HS - GSS - 009
                    </div>
                    <div class="row justify-content-center border border-dark  border-left-0 border-right-0">
                        2
                    </div>
                    <div class="row justify-content-center border border-dark  border-left-0 border-bottom-0 border-top-0 border-right-0">
                        August 16, 2021
                    </div>
                </div>

            </div>
          </div>
          
        </div>
        <div class="row justify-content-center">
            <div class="col-11 border border-dark "><br>
               

                <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                              <th  colspan="4"><small><b>UNIT/WARD: </b><u>test</u></small></th>
                              <th  colspan="3"><small><b>DATE: </b></small></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td " rowspan="2"  style="vertical-align : middle;text-align:center;"  width='40%'>DESCRIPTION</td>
                              <td  colspan="6" style="vertical-align : middle;text-align:center;">QUANTITY</td>
                            </tr>
                            <tr>
                                <td width='10%'>Beg. Bal</td>
                                <td width='10%'>Issue</td>
                                <td width='10%'>Total</td>
                                <td width='10%'>Cond/Ret</td>
                                <td width='10%'>Ending Balance</td>
                                <td width='10%'>Losses</td>
                            </tr>
                            @foreach($linenInventory as $linen) 
                            <tr> 
                                <td width='40%'>{{$linen->product_name}}</td>
                                <td width='10%'>to-do</td>
                                <td width='10%'>{{$linen->products_issued_quantity}}</td>
                                <td width='10%'>{{$linen->product_quantity}}</td>                                
                                <td width='10%'>{{$linen->product_condemned_quantity}}</td>
                                <td width='10%'>to-do</td>
                                <td width='10%'>to-do</td>
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
@endsection



@push('scripts')

<script>
$(document).ready(function () {    
    $(function () {
            $('.printMe').click(function () {
                window.print();
                // pop_searchPatient();
            });


        });

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


        });   

})     
</script>    
<style>
            @media print {
            @page {
                size: portrait !important;
                margin-left: 0.5in;
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
    body {
    -moz-transform: scale(0.9, 0.9); /* Moz-browsers */
    zoom: 0.9; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
}    
    
</style> 
@endpush