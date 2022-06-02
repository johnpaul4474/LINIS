@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        
                        <div class="row mb-3">
                            
                            <label for="ward" class="col-md-4 col-form-label text-md-end"> 
                                <input class="form-check-input" type="radio" name="ward_office" id="wardRadio" required >{{ __('     Ward') }}
                            </label>

                            <div class="col-md-6">
                                
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

                        <div class="row mb-3">
                            <label for="office" class="col-md-4 col-form-label text-md-end">
                                <input class="form-check-input" type="radio" name="ward_office" id="officeRadio" required>{{ __('     Office') }}
                            </label>

                            <div class="col-md-6">
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
                        
                        {{-- <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
   <script>
  
    $(document).ready(function () {
        //////////////////console.log( "ready!" );
        $("#wardRadio, #officeRadio").change(function(){
            
        $("#ward, #office").val("").attr("readonly",true);
        if($("#wardRadio").is(":checked")){
            $("#ward").removeAttr("readonly");
            $("#wardRadio").attr("required",true);
            $("#ward").attr("required",true);
            $("#ward").prop('disabled', false);
            $("#ward").focus();
        }
        else if($("#officeRadio").is(":checked")){
            $("#office").removeAttr("readonly");
            $("#officeRadio").attr("required",true);
            $("#office").attr("required",true);
            $("#office").prop('disabled', false);
            $("#office").focus();   
        }
    });
});
    


   </script>
@endpush