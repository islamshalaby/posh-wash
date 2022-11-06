@extends('admin.app')

@section('title' , __('messages.add_new_contact_number'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.add_new_contact_number') }}</h4>
             </div>
				
				
    </div>
    
    @if (session('status'))
        <div class="alert alert-danger mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
            <strong>Error!</strong> {{ session('status') }} </button>
        </div> 
    @endif

    <form method="post" action="{{route('contact_numbers.store')}}" >
     @csrf
    <div class="form-group mb-4">
        <label for="phone">{{ __('messages.phone') }}</label>
        <input required type="phone" name="phone" class="form-control" id="phone" placeholder="{{ __('messages.phone') }}" value="" >
    </div>
  	
    <input type="submit" value="{{ __('messages.submit') }}" class="btn btn-primary">
</form>
</div>

@endsection