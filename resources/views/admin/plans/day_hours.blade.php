@extends('admin.app')

@section('title' , __('messages.plans'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.working_days') }} ( {{ app()->getLocale() == 'en' ? $plan->title_en : $plan->title_ar }} / {{ $day }} )</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th class="text-center blue-color">{{ __('messages.hour') }}</th>
                        <th class="text-center blue-color">{{ __('messages.number_of_times_order') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $hour)
                        <tr>
                            <td class="text-center blue-color">{{ $hour->time_from }}</td>
                            <td class="text-center blue-color">
                                
                                <a class="btn btn-warning mb-2 mr-2 btn-rounded" data-user="{{$hour->id}}" data-toggle="modal"
                                    data-target="#zoomup_group_Modal{{$hour->id}}">{{ $hour->usage_number }}
                                 </a>

                                 <div id="zoomup_group_Modal{{$hour->id}}" class="modal animated zoomInUp custo-zoomInUp" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('messages.update_number_of_times_order') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                            <form action="{{route('plans.update_usage_number')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="day_id" value="{{ $hour->id }}">
                                                <div class="modal-body">
                                                    <div class="form-group mb-4">
                                                        <label for="plan_price">{{ __('messages.number_of_times_order') }}</label>
                                                        <input required type="number" min="0" name="usage_number" value="{{ $hour->usage_number }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal">
                                                        <i class="flaticon-cancel-12"></i> {{ __('messages.cancel') }}
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">{{ __('messages.send') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <?php $i++; ?>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

