@extends('layouts.appHome')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col">
            <form class = 'card p-3 bg-light' action = "/material/add" method = "post">
                @csrf
                <fieldset>
                <legend>ADD RAW MATERIALS</legend>
                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">                      
                            <label for="stock_number" class="input-group-text">{{ __('Stock Number') }}</label>
                            </div>                    
                            <input id="stock_number" type="text" class="form-control @error('stock_number') is-invalid @enderror" name="stock_number" value="{{ old('stock_number') }}" required autocomplete="stock_number" readonly='readonly'autofocus>
                            @error('stock_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-sm mb-3">                            
                            <div class="input-group-prepend">
                                <label for="type" class="input-group-text">{{ __('Type') }}</label>
                            </div>
                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required autocomplete="type" value="{{ old('type') }}" required autocomplete="stock_number" autofocus >
                                    <option value="" selected disabled hidden> Choose Type</option>                                                                                   
                                    <option value="RAW">RAW</option>
                                    <option value="READY-MADE">READY-MADE</option>
                                    
                                 
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-sm mb-3">                            
                            <div class="input-group-prepend">
                                <label for="received_at" class="input-group-text">{{ __('Received Date') }}</label>
                            </div>
                                <input id="received_at" type="date" class="form-control @error('received_at') is-invalid @enderror" name="received_at" value="{{ old('received_at') }}" required autocomplete="received_at" autofocus>

                                @error('received_at')
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
                                <label for="unit" class="input-group-text">{{ __('Unit') }}</label>
                            </div>
                                <select class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" required autocomplete="unit" autofocus >
                                    <option value="" selected disabled hidden> Choose Unit</option>                                                                                   
                                    <option value="PIECE">PIECE</option>
                                    <option value="SPOOL">SPOOL</option>
                                    <option value="YARD">YARD</option>
                                    <option value="ROLL">ROLL</option>
                                    <option value="SACK/BAG">SACK/BAG</option>
                                 
                                </select>
                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                        </div>
                    </div>
                    <div class="col">
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
                    </div>
                    <div class="col">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">                      
                              <label for="unit_cost" class="input-group-text">{{ __('Unit Cost') }}</label>
                            </div>                    
                                <input id="unit_cost" type="number" step="0.01" class="form-control @error('unit_cost') is-invalid @enderror" name="unit_cost" value="{{ old('unit_cost') }}" required autocomplete="unit_cost" autofocus>
                                @error('unit_cost')
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
                                <label for="stockRoom" class="input-group-text">{{ __('Stock Room') }}</label>
                            </div>
                                <select class="form-control @error('stockRoom') is-invalid @enderror" id="stockRoom" name="stockRoom" required autocomplete="stockRoom" autofocus >
                                    <option value="" selected disabled hidden> Choose Stock Room</option>                                                                                   
                                    @foreach($stockRooms as $stockRoom)                                                                
                                    <option value="{{$stockRoom->id}}">
                                            {{$stockRoom->stock_room}}
                                        </option>
                                    @endforeach
                                 
                                </select>
                                @error('stockRoom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                    
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="storageRoom" class="input-group-text">{{ __('Storage Room') }}</label>
                            </div>
                                <select class="form-control @error('storageRoom') is-invalid @enderror" id="storageRoom" name="storageRoom" required autocomplete="storageRoom" autofocus  disabled>
                                    <option value="" selected disabled hidden> Choose Storage Room</option>   
                                 
                                </select>
                                @error('storageRoom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                 
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">        

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="true" id="isArchived" class="form-control @error('isArchived') is-invalid @enderror" name="isArchived">
                                    <label class="form-check-label" for="isArchived">
                                      Archived
                                    </label>
                                  </div> 
                                  @error('isArchived')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror   
                                        
                              
                            </div>    
                            <div class="input-group-prepend">         
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="true" id="isAvailable" class="form-control @error('isAvailable') is-invalid @enderror" name="isAvailable" checked>
                                    <label class="form-check-label" for="defaultCheck1">
                                      Available
                                    </label>
                                  </div> 
                                  @error('isAvailable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror 
                                        
                              
                            </div>                 
                                                 
                        </div>
                    </div>
                </div>
                  <div class="w-100"></div>
                  
                    <div class="form-group">                                                
                            <label for="description" class="input-group-text">{{ __('Description') }}</label>                           
                        
                        <textarea id="description" rows="3" type="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror     
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" href='material/add'>Add Record</button>
                </fieldset>

            </form>
        </div>
        
    </div>
    <br>
    <div class = "row">
        
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #00AA9E;">{{ __('Linen Raw Materials') }}</div>
            
                            <div class="card-body">
                              <div class="table-responsive">                    
                                <table id="rawMaterialTable" class="table table-striped table-bordered table-success" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th>id</th>
                                      <th>STOCK-NUMBER</th>
                                      <th>QUANTITY</th>                          
                                      <th>UNIT</th>
                                      <th>TYPE</th>
                                      <th>DESCRIPTION</th>
                                      <th>UNIT COST</th>
                                      <th>STOCK ROOM</th>
                                      <th>STORAGE</th>                                     
                                      <th>ARCHIVED</th>  
                                      <th>AVAILABILITY</th>                                  
                                      <th>RECEIVED DATE</th>
                                      <th>EDIT</th>
                                      <th>DELETE</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($rawMaterials as $raw)                                                                
                                    <tr id="{{$raw->id}}">
                                     <td>{{$raw->id}}</td>
                                      <td id="stock_number">{{$raw->stock_number}}</td>
                                      <td id="quantity">{{$raw->quantity}}</td>
                                      <td id="unit">{{$raw->unit}}</td>
                                      <td id="type">{{$raw->type}}</td>
                                      <td id="description">{{$raw->description}}</td>
                                      <td id="unit_cost">{{$raw->unit_cost}}</td>
                                      @foreach ($stockRooms as $stockRoom)
                                        @if ($stockRoom->id == $raw->stock_room)
                                            <td id="stock_room">{{$stockRoom->stock_room}}</td>
                                        @endif
                                      @endforeach
                                      @foreach ($storageList as $storage)
                                        @if ($storage->id == $raw->storage_room)
                                             <td id="storage_room">{{$storage->storage_name}}</td>
                                        @endif
                                      @endforeach      
                                        @if ($raw->is_archived == 1)                    
                                            <td id="availability">YES</td>
                                        @else     
                                            <td id="availability">NO</td>
                                        @endif
                                        @if ($raw->is_available == 1)             
                                             <td id="archived">YES</td>
                                        @else     
                                             <td id="archived">NO</td>     
                                        @endif
                                      <td id="received_at_edit">{{$raw->received_at}}</td>
                                      <td>                                          
                                        
                                        <button type="submit" class="editRawMaterialButton btn btn-primary btn-sm"  >
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
                                      </td><td>
                                          <form action = "/material/delete" method = "post">
                                            @csrf
                                            <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$raw->id}}">

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
                                    
                                    </td>
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

      
      <!-- Modal -->

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editRawMaterialModal" >
            <div class="modal-dialog modal-lg">      
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Raw Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" name="closeEditMaterialModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form class = 'card p-3 bg-light' action = "/material/update" method = "post">
                        <div class="modal-body">
                        
                            @csrf
                            
                            <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">                      
                                            <label for="stock_number" class="input-group-text">{{ __('Stock Number') }}</label>
                                            </div>                    
                                            <input id="stock_number" type="text" class="form-control @error('stock_number') is-invalid @enderror" name="stock_number" value="{{ old('stock_number') }}" required autocomplete="stock_number" autofocus>
                                            @error('stock_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                    
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">                            
                                            <div class="input-group-prepend">
                                                <label for="type" class="input-group-text">{{ __('Type') }}</label>
                                            </div>
                                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required autocomplete="type" autofocus >
                                                    <option value="" selected disabled hidden> Choose Type</option>                                                                                   
                                                    <option value="RAW">RAW</option>
                                                    <option value="READY-MADE">READY-MADE</option>
                                                    
                                                
                                                </select>
                                                @error('unit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror                    
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">                            
                                            <div class="input-group-prepend">
                                                <label for="received_at_edit" class="input-group-text">{{ __('Received Date') }}</label>
                                            </div>
                                                <input id="received_at_edit" type="date"   class="form-control @error('received_at_edit') is-invalid @enderror" name="received_at_edit" value="{{ old('received_at_edit') }}" required autocomplete="received_at_edit" autofocus>
                
                                                @error('received_at_edit')
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
                                                <label for="unit" class="input-group-text">{{ __('Unit') }}</label>
                                            </div>
                                                <select class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" required autocomplete="unit" autofocus >
                                                    <option value="" selected disabled hidden> Choose Unit</option>                                                                                   
                                                    <option value="PIECE">PIECE</option>
                                                    <option value="SPOOL">SPOOL</option>
                                                    <option value="YARD">YARD</option>
                                                    <option value="ROLL">ROLL</option>
                                                    <option value="SACK/BAG">SACK/BAG</option>
                                                
                                                </select>
                                                @error('unit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror                    
                                        </div>
                                    </div>
                                    <div class="col">
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
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend">                      
                                            <label for="unit_cost" class="input-group-text">{{ __('Unit Cost') }}</label>
                                            </div>                    
                                                <input id="unit_cost" type="number" step="0.01" class="form-control @error('unit_cost') is-invalid @enderror" name="unit_cost" value="{{ old('unit_cost') }}" required autocomplete="unit_cost" autofocus>
                                                @error('unit_cost')
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
                                        <label for="stockRoom" class="input-group-text">{{ __('Stock Room') }}</label>
                                    </div>
                                        <select class="form-control @error('stockRoom') is-invalid @enderror" id="stockRoom" name="stockRoom" required autocomplete="stockRoom" autofocus >
                                            <option value="" selected disabled hidden> Choose Stock Room</option>                                                                                   
                                            @foreach($stockRooms as $stockRoom)                                                                
                                            <option value="{{$stockRoom->id}}">
                                                    {{$stockRoom->stock_room}}
                                                </option>
                                            @endforeach
                                        
                                        </select>
                                        @error('stockRoom')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <label for="storageRoom" class="input-group-text">{{ __('Storage Room') }}</label>
                                    </div>
                                        <select class="form-control @error('storageRoom') is-invalid @enderror" id="storageRoom" name="storageRoom" required autocomplete="storageRoom" autofocus  >
                                            <option value="" selected disabled hidden> Choose Storage Room</option>   
                                        
                                        </select>
                                        @error('storageRoom')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                 
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">        

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="true" id="isArchivedEdit" class="form-control @error('isArchivedEdit') is-invalid @enderror" name="isArchivedEdit">
                                            <label class="form-check-label" for="isArchivedEdit">
                                            Archived
                                            </label>
                                        </div> 
                                        @error('isArchivedEdit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror   
                                                
                                    
                                    </div>    
                                    <div class="input-group-prepend">         
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="true" id="isAvailableEdit" class="form-control @error('isAvailableEdit') is-invalid @enderror" name="isAvailableEdit">
                                            <label class="form-check-label" for="defaultCheck1">
                                            Available
                                            </label>
                                        </div> 
                                        @error('isAvailableEdit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror 
                                                
                                    
                                    </div>                 
                                                        
                                </div>
                            </div>
                                    
                            
                            
                            <div class="w-100"></div>
                            
                                <div class="form-group">                                                
                                        <label for="description" class="input-group-text">{{ __('Description') }}</label>                           
                                    
                                    <textarea id="description" rows="3" type="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror     
                                </div>
                            
                            
                                <input id="idRawMaterial" type="hidden" class="form-control @error('idRawMaterial') is-invalid @enderror" name="idRawMaterial" value="">
                            </div>   
                        
                        </div>
                        {{-- @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <script>
                            console.log('{{$error}}');
                            if({{$error}} != 'The selected stock number is invalid.'){
                                $('#editRawMaterialModal').modal('show')
                            }
                            
                            </script>
                        @endforeach
                        @endif --}}
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" name="closeEditMaterialModal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</div>

@endsection



@push('scripts')


<script>  
$(document).ready(function () {
        console.log('add materials');
    $('#rawMaterialTable').DataTable(
        {
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        "search": true,     
        "ordering": false,
        // "order": [[ 0, "desc" ]],
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
      
    $( "button[name='closeEditMaterialModal']" ).click(function() {
        $('#editRawMaterialModal').modal('hide')
    });

    $('#stock_number').val("{!!$lastRecord!!}");

    
    $("#rawMaterialTable").on('click','.editRawMaterialButton',function(){
        $('#editRawMaterialModal').modal('show')

        var currentRow=$(this).closest("tr"); 
        // console.log(currentRow.attr('id'));

         $('#editRawMaterialModal #idRawMaterial').val(currentRow.attr('id'));
         $('#editRawMaterialModal #stock_number').val(currentRow.find("td:eq(0)").text());
         $('#editRawMaterialModal #type').val(currentRow.find("td:eq(3)").text());
         $('#editRawMaterialModal #received_at_edit').val(currentRow.find("td:eq(10)").text());
         $('#editRawMaterialModal #unit').val(currentRow.find("td:eq(2)").text());
         $('#editRawMaterialModal #quantity').val(currentRow.find("td:eq(1)").text());
         $('#editRawMaterialModal #unit_cost').val(currentRow.find("td:eq(5)").text());
         $('#editRawMaterialModal #description').val(currentRow.find("td:eq(4)").text()); 
         
        

         $.each({!!$stockRooms!!}, function(key, value) {       
             
                if(value.stock_room == currentRow.find("td:eq(6)").text()){
                    console.log(value.id);
                    $('#editRawMaterialModal #stockRoom').val(value.id).change();
                }
        });

        $.each({!!$storageList!!}, function(key, value) {    
            
                if($('#editRawMaterialModal #stockRoom').val() == value.stock_room_id){
                    $("#editRawMaterialModal #storageRoom").append('<option value="'+value.id+'">'+value.storage_name+'</option>');
                   if(value.storage_name == currentRow.find("td:eq(7)").text()){
                        $("#editRawMaterialModal #storageRoom").val(value.id).change();
                   }
                       
                    
                }
                
        });

        if(currentRow.find("td:eq(8)").text() == "YES"){                   
            $('#isArchivedEdit').prop( "checked", true );
            console.log($('#isArchivedEdit').is(':checked'));     
        }else{             
             console.log($('#isArchivedEdit').is(':checked'));      
            $('#isArchivedEdit').prop( "checked", false );
        }

        if(currentRow.find("td:eq(9)").text() == "YES"){                   
            $('#isAvailableEdit').prop( "checked", true );
            console.log($('#isAvailableEdit').is(':checked'));     
        }else{             
             console.log($('#isAvailableEdit').is(':checked'));      
            $('#isAvailableEdit').prop( "checked", false );
        }

        $("#editRawMaterialModal #stockRoom").change(function () {
       
            $('#editRawMaterialModal #storageRoom').removeAttr('disabled');
            $("#editRawMaterialModal #storageRoom").find('option').remove();
            $("#editRawMaterialModal #storageRoom").append('<option value="" selected disabled hidden> Choose Storage Room</option>');   

            $.each({!!$storageList!!}, function(key, value) {            
                if($('#editRawMaterialModal #stockRoom').val() == value.stock_room_id){
                    $("#editRawMaterialModal #storageRoom").append('<option value="'+value.id+'">'+value.storage_name+'</option>');
                }
            });
      
         });
    });

    
    $("#stockRoom").change(function () {       
       
        $('#storageRoom').removeAttr('disabled');
        $("#storageRoom").find('option').remove();
        $("#storageRoom").append('<option value="" selected disabled hidden> Choose Storage Room</option>');   

        $.each({!!$storageList!!}, function(key, value) {            
            if($('#stockRoom').val() == value.stock_room_id){
                $("#storageRoom").append('<option value="'+value.id+'">'+value.storage_name+'</option>');
            }
        });
       
    });
      
      

  

   
   
});
</script>
<style>
.input-group>.input-group-prepend {
    flex: 0 0 40%;
}
.input-group .input-group-text {
    width: 100%;
}
table.dataTable td {
  font-size: small;
}

    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        /* width: 800px; */
        /* margin: 0 auto; */
    }
    /* body {
    -moz-transform: scale(0.9, 0.9); 
    zoom: 0.9; 
    zoom: 90%; 
} */
</style>    
@endpush