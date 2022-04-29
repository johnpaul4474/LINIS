@extends('layouts.appHome')

@section('content')
<div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card bg-danger">
            <h5 class="card-header text-center">PENDING</h5>
            <div class="card-body">              
              <h1 class="text-center">0</h1>    
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card bg-primary">
            <h5 class="card-header text-center">PROCESSING</h5>
            <div class="card-body">
                <h1 class="text-center">0</h1>    
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card bg-success">
            <h5 class="card-header text-center">FINISHED</h5>
            <div class="card-body">
                <h1 class="text-center">0</h1>    
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


})
     
</script>    
<style>

    
    </style> 
@endpush