@extends('layouts.appHome')

@section('content')

<div class="container-fluid">
    
    <div class="row">
       
      <div class="col-sm">

        <form class = 'card p-3 bg-light' id='stockRoomForm' action = "stockroom/add" method = "post">
            @csrf
            <fieldset>
            <legend>ADD STOCK ROOM</legend>
            <div class="row">
                <div class="col">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">                      
                        <label for="stock_room" class="input-group-text">{{ __('Stock Room') }}</label>
                        </div>                    
                        <input id="stock_room"  style="text-transform:uppercase" onKeyup="this.value = this.value.toUpperCase()" type="text" class="form-control @error('stock_room') is-invalid @enderror" name="stock_room" value="{{ old('stock_room') }}" required autocomplete="stock_room" autofocus>
                        @error('stock_room')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror                    
                    </div>
                </div>
                
                <br>
                <button type="submit" class="btn btn-primary" href='material/add'>Add Stock Room</button>
            </div>    
            </fieldset>
        </form>
        <br>
        <br>
        <br>
        <div class="card">
            <div class="card-header text-white" style="background-color: #00AA9E;">{{ __('LINEN STOCK ROOMS') }}</div>
            <div class="card-body">
                <div class="table-responsive">  
                    <table id="stockRoomTable" class="table table-striped table-bordered table-success" style="width:100%">
                        <thead>
                        <tr>
                            <th>STOCK ROOM ID</th>
                            <th>STOCK ROOM</th>                              
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stockRooms as $stockRoom)                                                                
                        <tr id="{{$stockRoom->id}}">
                        <td id="{{$stockRoom->id}}">{{$stockRoom->id}}</td>
                            <td id="stock_room">{{$stockRoom->stock_room}}</td>                             
                            <td >                                          
                            
                            <button type="submit" class="editStockRoomButton btn btn-primary btn-sm"  >
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
                            </td>
                            <td>
                                <form action = "/stockroom/delete" method = "post">
                                @csrf
                                <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$stockRoom->id}}">

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
                            <input id="idStockRoom" type="hidden" class="form-control @error('idStockRoom') is-invalid @enderror" name="idStockRoom" value="{{$stockRoom->id}}">

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

      
        <div class="col-sm">
            <div class="card-header">{{ __('LINEN STOCK ROOMS AND STORAGES') }}</div>
            <div class="card-body">
                @foreach($stockRooms as $stockRoom)
                <div class="accordion" id="accordionExample">
                    <div class="card" style ="">
                        <div class="card-header " id="headingOne">
                            <h2 class="mb-0">                                
                                
                                <button class="btn btn-link btn-block text-left bg-primary text-white" type="button" data-toggle="collapse"
                                    data-target="#collapseOne{{$stockRoom->id}}" aria-expanded="true" aria-controls="collapseOne{{$stockRoom->id}}">
                                    <img src="../img/folder (1).png" height="25" width="25" alt="" class="mr-2"> {{$stockRoom->stock_room}}
                                
                                </button>  
                                                      
                            </h2>
                            
                        </div>
            
                        <div id="collapseOne{{$stockRoom->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <h6 class="collapse-header font-weight-bold">Storage List</h6>
                                @foreach ($storageList as $storage)
                                @if ($stockRoom->id == $storage->stock_room_id)
                                <a href="/stockroom?{{$stockRoom->id}}/storage?{{$storage->id}}"><button class="btn btn-success font-weight-bold">{{$storage->storage_name}}</button></a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>    
                
        </div>


        <div class="col-sm">
            <form class = 'card p-3 bg-light' action = "stockroom/storage/add" method = "post">
                @csrf
                <fieldset>
                <legend>ADD STORAGE ROOM</legend>
                
                <div class="col">
                    <div class="input-group input-group-sm mb-3">                            
                        <div class="input-group-prepend">
                            <label for="stockRoom" class="input-group-text">{{ __('Stock Room') }}</label>
                        </div>
                            <select class="form-control @error('stockRoom')  is-invalid @enderror" id="stockRoom" name="stockRoom" required autocomplete="stockRoom" autofocus >
                                <option value="" selected disabled hidden> Choose Stock Room</option>                                                                                   
                                @foreach($stockRooms as $room)                                                                
                                <option value="{{$room->id}}">
                                        {{$room->stock_room}}
                                    </option>
                                @endforeach
                                </select>
                            
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
                        <label for="storage" class="input-group-text">{{ __('Storage') }}</label>
                        </div>                    
                        <input id="storage" style="text-transform:uppercase" onKeyup="this.value = this.value.toUpperCase()" type="text" class="form-control @error('storage') is-invalid @enderror" name="storage" value="{{ old('storage') }}" required autocomplete="storage" autofocus>
                        @error('storage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror                    
                    </div>
                </div>
                </fieldset>
                <button type="submit" class="btn btn-primary" href='stockroom/storage/add'>Add Storage Room</button>    
            </form>
            <br>
            
            <div class="card">
                <div class="card-header text-white" style="background-color: #00AA9E;">{{ __('LINEN STORAGE ROOMS') }}</div>
                <div class="card-body">
                    <div class="table-responsive">  
                        <table id="storageTable" class="table table-striped table-bordered table-success" style="width:100%">
                            <thead>
                            <tr>
                                <th>STOCK ROOM ID</th>
                                <th>STORAGE ID</th>
                                <th>STOCK ROOM</th> 
                                <th>STORAGE</th>                             
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stockRoomStorage as $storage)                                                                
                            <tr id="{{$storage->storage_id}}">
                                <td id="{{$storage->stock_room_id}}">{{$storage->stock_room_id}}</td>
                                <td id="{{$storage->storage_id}}">{{$storage->storage_id}}</td>
                                <td id="stock_room">{{$storage->stock_room}}</td>       
                                <td id="stock_room">{{$storage->storage_name}}</td>                       
                                <td >                                          
                                
                                <button type="submit" class="editStorageButton btn btn-primary btn-sm"  >
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
                                </td>
                                <td>
                                    <form action = "/stockroom/storage/delete" method = "post">
                                    @csrf
                                    <input id="id" type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$storage->storage_id}}">
                                    
    
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
                                <input id="idStockRoom" type="hidden" class="form-control @error('idStockRoom') is-invalid @enderror" name="idStockRoom" value="{{$stockRoom->id}}">
    
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
    

    <div class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editStockRoomModal" >
        <div class="modal-dialog modal-">      
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Stock Room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" name="closeEditStockRoomModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class = 'card p-3 bg-light' action = "/stockroom/update" method = "post">
                        <div class="modal-body">
                        
                            @csrf
                            
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">                      
                                            <label for="edit_stock_room" class="input-group-text">{{ __('Stock Room') }}</label>
                                        </div>                    
                                        <input id="edit_stock_room"  style="text-transform:uppercase" onKeyup="this.value = this.value.toUpperCase()" type="text" class="form-control @error('edit_stock_room') is-invalid @enderror" name="edit_stock_room" value="{{ old('edit_stock_room') }}" required autocomplete="edit_stock_room" autofocus>
                                        @error('edit_stock_room')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                    
                                    </div>
                                </div>
                                <input id="idStockRoom" type="hidden" class="form-control @error('idStockRoom') is-invalid @enderror" name="idStockRoom" value="">
                            </div>    
                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" name="closeEditStockRoomModal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>    
                    </form>
                </div>    
            </div>
        </div>
    </div>
    
    {{-- Edit storage modal --}}
    <div class="modal fade bd-example1-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editStorageModal" >
        <div class="modal-dialog modal-">      
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Storage Room</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" name="closeEditStorageModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <form class = 'card p-3 bg-light' action = "/stockroom/storage/update" method = "post">
                    <div class="modal-body">                    
                        @csrf


                            <div class="input-group input-group-sm mb-3">                            
                                <div class="input-group-prepend">
                                    <label for="editStockRoomStorage" class="input-group-text">{{ __('Stock Room') }}</label>
                                </div>
                                    <select class="form-control @error('editStockRoomStorage') is-invalid @enderror" id="editStockRoomStorage" name="editStockRoomStorage" required autocomplete="editStockRoomStorage" autofocus >
                                        <option value="" selected disabled hidden> Choose Stock Room</option>                                                                                   
                                        @foreach($stockRooms as $room)                                                                
                                        <option value="{{$room->id}}">
                                                {{$room->stock_room}}
                                            </option>
                                        @endforeach
                                        </select>
                                    
                                    </select>
                                    @error('editStockRoomStorage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                                          
                            </div>
                        
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend">                      
                                            <label for="edit_storage" class="input-group-text">{{ __('Storage') }}</label>
                                        </div>                    
                                        <input id="edit_storage"  style="text-transform: uppercase" onKeyup="this.value = this.value.toUpperCase()" type="text" class="form-control @error('edit_storage') is-invalid @enderror" name="edit_storage" value="{{ old('edit_storage') }}" required autocomplete="edit_storage" autofocus>
                                        @error('edit_storage')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>            
                                </div>
                            </div>
                            
                        
                        
                            <input id="idStorage" type="hidden" class="form-control @error('idStorage') is-invalid @enderror" name="idStorage" value="">
                            
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" name="closeEditStorageModal">Close</button>
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
        console.log('add storage/stockroom');
    $('#stockRoomTable').DataTable(
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
                "searchable": false
            },          
        ]
       }         
      ); 


    $('#storageTable').DataTable(

        {
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        "search": true,     
        "ordering": false,
        // "order": [[ 0, "desc" ]],
        "paging": true,
        "pageLength": 5,
        "columnDefs": [
            {
                "targets": [ 0 , 1],
                "visible": false,
                "searchable": false
            },          
        ]
       }         
    );  
      
    $( "button[name='closeEditStockRoomModal']" ).click(function() {
        $('#editStockRoomModal').modal('hide')
    });

    $("#stockRoomTable").on('click','.editStockRoomButton',function(){
        $('#editStockRoomModal').modal('show');

        var currentRow=$(this).closest("tr"); 
         
      
        console.log(currentRow.attr('id'));
         $('#editStockRoomModal #idStockRoom').val(currentRow.attr('id'));
         $('#editStockRoomModal #edit_stock_room').val(currentRow.find("td:eq(0)").text());

    });

    
    $('.editStockRoomButton').click(function() {
        $('#editStockRoomModal').modal('show');
    });
          
    ///edit storage modal
    $( "button[name='closeEditStorageModal']" ).click(function() {
        $('#editStorageModal').modal('hide')
    });
    $("#storageTable").on('click','.editStorageButton',function(){
        $('#editStorageModal').modal('show');

        var currentRow=$(this).closest("tr");          
      
        var stock_room_id = $('#storageTable').DataTable().row(currentRow).data();

        console.log(currentRow.attr('id'));
        console.log(stock_room_id[0]);
         $('#editStorageModal #idStorage').val(currentRow.attr('id'));
         $('#editStorageModal #edit_storage').val(currentRow.find("td:eq(1)").text());
         $('#editStorageModal #editStockRoomStorage').val(stock_room_id[0])

    });



})
     
</script>    
<style>
    .input-group>.input-group-prepend {
        flex: 0 0 25%;
    }
    .input-group .input-group-text {
        width: 100%;
    }
    body {
    -moz-transform: scale(0.9, 0.9); /* Moz-browsers */
    zoom: 0.9; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
}    
    </style> 
@endpush