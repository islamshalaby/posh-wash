@extends('admin.app')

@section('title' , __('messages.plan_edit'))

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.plan_edit') }}</h4>
                    </div>
                </div>
            </div>
            <form action="{{route('plans.update.new',$plan->id)}}" method="post">
                @csrf
                <div class="form-group mb-4">
                    <label for="plan_price">{{ __('messages.plan_name_ar') }}</label>
                    <input type="text" name="title_ar" value="{{$plan->title_ar}}" class="form-control">
                </div>
                <div class="form-group mb-4">
                    <label for="plan_price">{{ __('messages.plan_name_en') }}</label>
                    <input required type="text" name="title_en" value="{{$plan->title_en}}" class="form-control">
                </div>
                <div class="form-group mb-4">
                    <label for="plan_price">{{ __('messages.work_hours') }}</label>
                    <input required type="number" name="work_hours" value="{{$plan->work_hours}}"  class="form-control" id="work_hours" min="1">
                </div>
                <div class="form-group mb-4">
                    <label for="plan_price">{{ __('messages.plan_price') }}</label>
                    <input required type="number" name="price" class="form-control" value="{{$plan->price}}"
                           id="plan_price" step="any" min="0">
                </div>
                <input type="submit" value="{{ __('messages.edit') }}" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/admin/assets/js/plans.js"></script>
@endsection
