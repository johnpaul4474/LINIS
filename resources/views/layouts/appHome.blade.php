
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <meta name="description" content="Linen Inventory System">
    <meta name="author" content="John Paul arce">
    {{-- <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico"> --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->


    {{-- <title>{{ config('app.name', 'Linen Inventory System') }}</title> --}}

    <title>Linen Inventory System</title>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">  
   
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
 
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('style')

    @stack('scripts')
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script>
      $(document).ready(function() {
           // Enable pusher logging - don't include this in production
    //Pusher.logToConsole = true;

      var pusher = new Pusher('6ce559efc7cec2610788', {
        cluster: 'ap1'
      });

      var counter = 0;     
      if({{ Auth::user()->role_id }} == 1 || {{ Auth::user()->role_id }} == 2) {     
        var channel = pusher.subscribe('linis-notification');
        channel.bind('linis-event', function(data) {  
            counter = counter + 1;

            $('#btnNotification').removeAttr('hidden');
            $("#counterNotification").attr('data-count',counter );
            let messageNotification = 'Product name: ' + JSON.stringify(data.productName).replace(/\"/g, "") + '<br>' +
                                      'Product quantity: ' + JSON.stringify(data.productQuantity).replace(/\"/g, "") ; 
            if(data.wardName !== null) {
              console.log(data.wardName)
              messageNotification += '<br>' + 'Ward: ' + JSON.stringify(data.wardName).replace(/\"/g, "") ; 
            }  
            if(data.officeName !== null) {
              console.log(data.officeName)
              messageNotification += '<br>' + 'Office: ' + JSON.stringify(data.officeName).replace(/\"/g, "") ; 
            }          

            console.log(messageNotification);
            $('#dropdownNotification').append(`
                                  <a class="dropdown-item" href="/services">${messageNotification}</a>
                                  <div class="dropdown-divider"></div>
                                `);
          
        });
      }
      else{
        
        var channel = pusher.subscribe('linis-notification');
        channel.bind('linis-event', function(data) {     
          console.log('{{ Auth::user()->office_id }}',data.requestorDetails.office_id );
          console.log('{{ Auth::user()->ward_id }}',data.requestorDetails.ward_id);
          console.log(data)
            
          let requestDetails = {!! json_encode(Auth::user(), JSON_HEX_TAG) !!};
          
         
            if(requestDetails.office_id != null) {
              if(requestDetails.office_id == data.requestorDetails.office_id) {
                console.log('requestDetails.office_id', requestDetails.office_id,data.requestorDetails.office_id);
                counter = counter + 1;
                $('#btnNotification').removeAttr('hidden');
                $("#counterNotification").attr('data-count',counter );
                let messageNotification=""
                if(data.requestorDetails.status == 2) {
                   messageNotification = 'Product name: ' + JSON.stringify(data.productName).replace(/\"/g, "") + '<br>' +
                                          'Product quantity: ' + JSON.stringify(data.productQuantity).replace(/\"/g, "") + '<br>' +
                                          'IS NOW BEING PROCESSED BY' + '<br>' +
                                          'LINEN (' + data.username.name +')';
                } else if (data.requestorDetails.status == 3) {
                   messageNotification = 'Product name: ' + JSON.stringify(data.productName).replace(/\"/g, "") + '<br>' +
                                          'Product quantity: ' + JSON.stringify(data.productQuantity).replace(/\"/g, "") + '<br>' +
                                          'IS READY FOR PICK-UP' + '<br>' +
                                          'LINEN (' + data.username.name +')';
                } else if (data.requestorDetails.status == 4) {
                   messageNotification = 'Product name: ' + JSON.stringify(data.productName).replace(/\"/g, "") + '<br>' +
                                          'Product quantity: ' + JSON.stringify(data.productQuantity).replace(/\"/g, "") + '<br>' +
                                          'IS NOW ISSUED' + '<br>' +
                                          'LINEN (' + data.username.name +')';
                } else {
                  messageNotification="default";
                }
                


                                        
                $('#dropdownNotification').append(`
                                      <a class="dropdown-item" href="/services">${messageNotification}</a>
                                      <div class="dropdown-divider"></div>
                                    `);
                
              }
            }

            if(requestDetails.ward_id != null) {
              if(requestDetails.ward_id == data.requestorDetails.ward_id ) {
                console.log('requestDetails.ward_id',requestDetails.ward_id , data.requestorDetails.ward_id)
                counter = counter + 1;
                $('#btnNotification').removeAttr('hidden');
                $("#counterNotification").attr('data-count',counter );
                let messageNotification=""
                if(data.requestorDetails.status == 2) {
                   messageNotification = 'Product name: ' + JSON.stringify(data.productName).replace(/\"/g, "") + '<br>' +
                                          'Product quantity: ' + JSON.stringify(data.productQuantity).replace(/\"/g, "") + '<br>' +
                                          'IS NOW BEING PROCESSED BY' + '<br>' +
                                          'LINEN (' + data.username.name +')';
                } else if (data.requestorDetails.status == 3) {
                   messageNotification = 'Product name: ' + JSON.stringify(data.productName).replace(/\"/g, "") + '<br>' +
                                          'Product quantity: ' + JSON.stringify(data.productQuantity).replace(/\"/g, "") + '<br>' +
                                          'IS READY FOR PICK-UP' + '<br>' +
                                          'LINEN (' + data.username.name +')';
                } else if (data.requestorDetails.status == 4) {
                   messageNotification = 'Product name: ' + JSON.stringify(data.productName).replace(/\"/g, "") + '<br>' +
                                          'Product quantity: ' + JSON.stringify(data.productQuantity).replace(/\"/g, "") + '<br>' +
                                          'IS NOW ISSUED' + '<br>' +
                                          'LINEN (' + data.username.name +')';
                } else {
                  messageNotification="default";
                }
                
                
                $('#dropdownNotification').append(`
                                      <a class="dropdown-item" href="/services">${messageNotification}</a>
                                      <div class="dropdown-divider"></div>
                                    `);
                
              }
            }
            
          
        });
      }

      
      
      
      
    });
      </script>
      
  <style>
    .fa-stack[data-count]:after{
  position:absolute;
  right:0%;
  top:1%;
  content: attr(data-count);
  font-size:60%;
  padding:.6em;
  border-radius:999px;
  line-height:.75em;
  color: white;
  background:rgba(255,0,0,.85);
  text-align:center;
  min-width:2em;
  font-weight:bold;

 
}
  </style>    
  </head>

  <body>

    
    @if ($message = Session::get('success'))       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />     
    <script type = "text/javascript">        
         toastr.success("{{$message}}", 'Success');                 
    </script>
    @elseif($message = Session::get('info'))       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />     
        <script type = "text/javascript">  
            toastr.info("{{$message}}", 'Success');                 
        </script>        
    @elseif($message = Session::get('error'))       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />     
        <script type = "text/javascript">  
            toastr.error("{{$message}}", 'Success');                 
        </script>    
    @endif

    <div id="app" classs="container-fluid d-print-none">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid d-print-none">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{-- {{ config('app.name', 'Linen Inventory System') }} --}} Linen Inventory System
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                          <li class="nav-item dropdown">

                              
                            
                            <button role="button" type="button" class="btn" data-toggle="dropdown" id="btnNotification" hidden> 
                              <span class="fa-stack fa-1x" id="counterNotification" data-count="0">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bell fa-stack-1x fa-inverse" ></i>
                              </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <div id = "dropdownNotification">
                             
                            </div>
                          </div>
                              
                          </li>
                            <li class="nav-item dropdown">
                              
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/password">
                                       Change Password
                                    </a>
                                    <a class="dropdown-item" href="/area">
                                        Change Ward/Office
                                    </a>
                                    <a class="dropdown-item" href="/logout">
                                        Logout
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        

    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
            </li>
            {{-- @if(Auth::user()->role_id  == 1 || Auth::user()->role_id== 2) --}}
            @if(Auth::user()->role_id  == 1)
            <a class="nav-link" href="/departments" role="button">
                Wards & Offices
            </a>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Inventory Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/material">Raw Materials</a></li>
                <li><a class="dropdown-item" href="/products">Add Final Product </a></li>
                <li><a class="dropdown-item" href="/stockroom">Storage Management</a></li>
                            {{-- <li><hr class="dropdown-divider"></li> --}}
                
              </ul>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Issuance and Condemned
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/issuance">Issue Finished Products</a></li>
                <li><a class="dropdown-item" href="/returnedProducts">Condemned/Return Products</a></li>

                {{-- <li><hr class="dropdown-divider"></li> --}}
                
              </ul>
            </li>
            {{-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Storage Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/stockroom">Add Stock Room / Storage</a></li>
                <li><a class="dropdown-item" href="#">TO DO</a></li>
                {{-- <li><hr class="dropdown-divider"></li> --}}
                
              {{-- </ul> --}}
            {{-- </li> --}} 
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Request Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                
                <li><a class="dropdown-item" href="/request">Create Request</a></li>
                <li><a class="dropdown-item" href="/services">Services</a></li>
                <li><a class="dropdown-item" href="/reports">Reports</a></li>
                {{-- <li><hr class="dropdown-divider"></li> --}}
                
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Role Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                
                <li><a class="dropdown-item" href="/users/roleManagement">Assign Employee</a></li>
                <li><a class="dropdown-item" href="/users/listusers">List of users</a></li>                
                {{-- <li><hr class="dropdown-divider"></li> --}}
                
              </ul>
            </li>
            @else
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Return and Condemn
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                
                <li><a class="dropdown-item" href="/returnedProducts">Condemned/Return Products</a></li>

                {{-- <li><hr class="dropdown-divider"></li> --}}
                
              </ul>
            </li>
            
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Request Management
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                
                <li><a class="dropdown-item" href="/request">Create Request</a></li>
                <li><a class="dropdown-item" href="/services">Services</a></li>
                <li><a class="dropdown-item" href="/reports">Reports</a></li>
                {{-- <li><hr class="dropdown-divider"></li> --}}
                
              </ul>
            </li>
            @endif

            
            
          </ul>
          
        </div>
      </div>
    </nav>
    <br>

        <main role="main" class="container-fluid">          
            @yield('content')
   
        </main>

    
  </body>
</html>
