@extends('layouts.appHome')

@section('content')
<div class= "container">
<div class="card d-print-none" >
    <div class="card-header">
      GENERATE INVENTORY REPORT
    </div>
    <div class="card-body">
        <form action = "/generateInventoryReport" method = "post">
            @csrf
            <div class="row">
                {{-- @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2) --}}
                @if(Auth::user()->role_id  == 1)
                <div class="col-4">
                    <div class="input-group input-group-sm mb-3">                            
                        <div class="input-group-prepend">
                            <label for="month" class="input-group-text">Month</label>
                        </div>
                            <input id="month" type="month" class="form-control @error('month') is-invalid @enderror" name="month" value="{{ old('month') }}" required autocomplete="month">

                            @error('month')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                    </div>
                </div> 

                <div class="col-4">
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
                <div class="col-4">
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
                    <div class="col-4">
                        <div class="input-group input-group-sm mb-3">                            
                            <div class="input-group-prepend">
                                <label for="month" class="input-group-text">Month</label>
                            </div>
                                <input readonly id="month" type="month" class="form-control @error('month') is-invalid @enderror" name="month" value="{{ old('month') }}" required autocomplete="month">

                                @error('month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                        </div>
                    </div> 
                    
                    @if(Auth::user()->office_id != null)
                        @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                            @if($office->id == Auth::user()->office_id) 
                            
                                
                                <div class="col-6">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">                      
                                            <label for="office" class="input-group-text">{{ __('Office:') }}</label>
                                            </div>                    
                                            <input id="office" type="hidden" class="form-control @error('office') is-invalid @enderror" name="office" value="{{$office->id}}" required autocomplete="office"  autofocus readonly="readonly">
                                            <input id="officeName" type="text" class="form-control @error('officeName') is-invalid @enderror" name="officeName" value="{{$office->office_name}}" required autocomplete="officeName"  autofocus readonly="readonly">
                                           
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
                                        <input id="ward" type="hidden" class="form-control @error('ward') is-invalid @enderror" name="ward" value="{{$ward->id}}" required autocomplete="ward"  autofocus readonly="readonly">
                                        <input id="wardName" type="text" class="form-control @error('wardName') is-invalid @enderror" name="wardName" value="{{$ward->ward_name}}" required autocomplete="wardName"  autofocus readonly="readonly">
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
    <div class="page-footer h5">
        <div class="container">
            <div class="row">
              <div class="col">
                    Submitted by:
                    <br>
                    <br>
                    <br>
                    <br>
                    ____________________________
                    <br>
                    Signature over printed name:
              </div>
              <div class="col">
                  Received by:
                  
                    <br>
                    <br>
                    <br>
                    <br>
                    ____________________________
                    <br>
                    Signature over printed name:
                </div>
              
            </div>
          </div>
    </div>
                
    <div class="container ">
        <div class="row justify-content-center">
          <div class="col-2  border border-dark" style="border-right: none !important;"><br>

            <img src="../img/bghmc.png" class="mx-auto d-block" width="120" height="120" alt="">
            <br>
          </div>
          <div class="col-9 border border-dark" >
            <div class="row border border-dark" style="border-right: none !important;border-left: none !important;border-top: none !important;">
                <div class="col-12" >
                    <div class="text-center"><small>Republic of the Philippines</small></div>
                    <div class="text-center"><small>Department of Health</small></div>
                    <div class="text-center text-uppercase font-weight-bold">baguio general hospital and medical
                        center</small> </div>
                    <div class="text-center"><small>Baguio City</small> </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">                                    
                    <div class="text-center mt-3">
                        <span class="font-weight-bold">LINEN ROOM UNIT</span>
                        <h5 class="font-weight-bold">INVENTORY OF LINENS</h5>
                    </div>
                </div>
                <div class="col-2"> 
                    <div class="row border border-dark" style="border-bottom: none !important;border-top: none !important;">
                         Form No.:
                    </div>
                    <div class="row border border-dark">
                         Rev.No:
                    </div>
                    <div class="row border border-dark" style="border-bottom: none !important;border-top: none !important;">
                         Effectivity Date:
                    </div>
                </div>
                <div class="col-2"> 
                    <div class="row justify-content-center ">
                        HS - GSS - 009
                    </div>
                    <div class="row justify-content-center border border-dark" style="border-left: none !important;border-right: none !important;">
                        2
                    </div>
                    <div class="row justify-content-center ">
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
                              <th  colspan="4"><small><b>UNIT/WARD: </b>
                                @if(Auth::user()->role_id  == 3)
                                    @if(Auth::user()->office_id != null)
                                    @foreach(\App\Http\Controllers\Department\DepartmentController::officeList() as $office)                                                                
                                        @if($office->id == Auth::user()->office_id) 
                                            <u>
                                              {{$office->office_name}}
                                            </u>
                                        @endif
                                    @endforeach
                                    @elseif(Auth::user()->ward_id != null)
                                        @foreach(\App\Http\Controllers\Department\DepartmentController::wardList() as $ward)                                                                
                                        @if($ward->id ==  Auth::user()->ward_id )
                                            
                                                <u>
                                                {{$ward->ward_name}}
                                                </u> 
                                            
                                        @endif
                                        @endforeach
                                    
                                    @endif
                                @else
                                    <span id="unit_ward">          
                                    </span>
                                   
                                    
                                @endif
                            </small></th>
                              <th  colspan="4"><small><b>DATE: {{\Carbon\Carbon::now()->format('F d,Y h:i A')}}</b></small></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td  rowspan="2"  style="vertical-align : middle;text-align:center;"  width='30%'>DESCRIPTION</td>
                              <td  colspan="7" style="vertical-align : middle;text-align:center;">QUANTITY</td>
                            </tr>
                            <tr>
                                <td width='10%'>Beg. Bal</td>
                                <td width='10%'>Issue</td>
                                <td width='10%'>Total</td>
                                <td width='10%'>Condemned</td>
                                <td width='10%'>Returned</td>
                                <td width='10%'>Ending Balance</td>
                                <td width='10%'>Losses</td>
                                
                            </tr>
                            @foreach($linenInventoryReport as $linen) 
                            <tr> 
                                <td width='30%'>{{$linen->product_name}}</td>
                                <td width='10%'>{{$linen->beg_bal}}</td>
                                <td width='10%'>{{$linen->issued}}</td>
                                <td width='10%'>{{$linen->total}}</td>
                                <td width='10%'>{{$linen->condemned}}</td>                                
                                <td width='10%'>{{$linen->returned}}</td>
                                <td width='10%'>{{$linen->ending_bal}}</td>
                                <td width='10%'>{{$linen->lossed}}</td>
                                
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
    // Set date
    const dt = new Date()
    if(dt.getDate() <= 5) {
        // Set date to last month
        $("#month").val(dt.getFullYear().toString() + "-" + dt.getMonth().toString().padStart(2, "0"))
    } else {
        // Set date to current month
        $("#month").val(dt.getFullYear().toString() + "-" + (dt.getMonth()+1).toString().padStart(2, "0"))
    }
    
    $(function () {
            $('.printMe').click(function () {
                window.print();
                // pop_searchPatient();
            });


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

           
        });  
   
        $("#ward").change(function(){
            var ward = $(this).children("option:selected").text().trim();
            $('#unit_ward').text(ward);
        });
        $("#office").change(function(){
            var office = $(this).children("option:selected").text().trim();
            $('#unit_ward').text(office);
    });




    $.each({!! json_encode($officeward, JSON_HEX_TAG) !!}, function(key, value) {
        $('#unit_ward').text(value);
    });
       
       console.log( {!! json_encode($officeward, JSON_HEX_TAG) !!});
})    




</script>    
<style>
    .page-header, .page-header-space {
  height: 100px;
}

.page-footer, .page-footer-space {
  height: 100px;

}

.page-footer {
  position: fixed;
  bottom: 50px;
  width: 100%;
  
  
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  border-bottom: 1px solid black; /* for demo */
 

.page {
  page-break-after: always;
}


            @media print {
                thead {display: table-header-group;} 
                tfoot {display: table-footer-group;}
                
                button {display: none;}
                
                body {margin: 0;}
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
    /* body {
    -moz-transform: scale(0.9, 0.9);
    zoom: 0.9; 
    zoom: 90%; 
}     */
 
.page-footer, .page-footer-space {
  height: 50px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  border-top: 1px solid black; /* for demo */
  background: yellow; /* for demo */
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  border-bottom: 1px solid black; /* for demo */
  background: yellow; /* for demo */
}

.page {
  page-break-after: always;
}

@page {
  margin: 20mm
}
</style> 
@endpush