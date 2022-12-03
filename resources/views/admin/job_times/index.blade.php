@extends('admin.app')
@section('title' , __('messages.add'))
@push('styles')
    <style>
        .wizard > .content > .body .select2-search input {
            border: none
        }

        input[disabled] {
            background-color: #eeeeee !important;
        }

        input[name="final_price[]"],
        input[name="total_amount[]"],
        input[name="remaining_amount[]"],
        input[name="barcodes[]"],
        input[name="stored_numbers[]"],
        input[disabled] {
            font-size: 10px
        }

        #properties-items .col-sm-5 {
            margin-bottom: 20px
        }

        .time-range,
        .wizard > .content > .body input[type="checkbox"],
        .add-range {
            display: none
        }

        .time-range .col-lg-3 {
            margin-bottom: 20px
        }
    </style>
@endpush
@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div id="card_2" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>{{ __('messages.times_of_work') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form action="{{route('job_times.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <section>
                            {{-- sunday --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    {{ __('messages.sunday') }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label class="switch s-icons s-outline  s-outline-success  mr-2">
                                        <input data-day="sunday"
                                               @if($sunday_data) @if($sunday_data->holiday == 0 ) checked
                                               @endif @endif class="day_work" name="sunday_work" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- sunday work time --}}
                            <div class="row time-range sunday"
                                 @if($sunday_data) @if($sunday_data->holiday == 0 && $sunday_data) style="display: flex;" @endif @endif >
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_from">{{ __('messages.from') }}</label>
                                    <input type="time" name="sunday_from[]" class="form-control" id="sunday_from"
                                           @if($sunday_data) value="{{$sunday_data->from}}"@endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to">{{ __('messages.to') }}</label>
                                    <input type="time" name="sunday_to[]" class="form-control" id="sunday_to"
                                           @if($sunday_data) value="{{$sunday_data->to}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to"></label>
                                    <br>
                                    <br>
                                    <a href="{{route('job_times.show',0)}}"
                                       class="btn btn-success">{{ __('messages.day_details') }}</a>
                                </div>
                            </div>
                            {{-- monday --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    {{ __('messages.monday') }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input data-day="monday"
                                               @if($sunday_data) @if(isset($monday_data->holiday) && $monday_data->holiday == 0 && $monday_data) checked
                                               @endif @endif  class="day_work" name="monday_work" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- monday work time --}}
                            <div class="row time-range monday"
                                 @if($monday_data) @if($monday_data->holiday == 0) style="display: flex;" @endif @endif>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="monday_from">{{ __('messages.from') }}</label>
                                    <input type="time" name="monday_from[]" class="form-control"
                                           @if($monday_data) value="{{$monday_data->from}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="monday_to">{{ __('messages.to') }}</label>
                                    <input type="time" name="monday_to[]" class="form-control"
                                           @if($monday_data) value="{{$monday_data->to}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to"></label>
                                    <br>
                                    <br>
                                    <a href="{{route('job_times.show',1)}}"
                                       class="btn btn-success">{{ __('messages.day_details') }}</a>
                                </div>
                            </div>
                            {{-- tuesday --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    {{ __('messages.tuesday') }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input data-day="tuesday"
                                               @if($tuesday_data) @if($tuesday_data->holiday == 0) checked
                                               @endif @endif  class="day_work" name="tuesday_work" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- tuesday work time --}}
                            <div class="row time-range tuesday"
                                 @if($tuesday_data) @if($tuesday_data->holiday == 0) style="display: flex;" @endif @endif >
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="tuesday_from">{{ __('messages.from') }}</label>
                                    <input type="time" name="tuesday_from[]" class="form-control"
                                           @if($tuesday_data) value="{{$tuesday_data->from}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="tuesday_to">{{ __('messages.to') }}</label>
                                    <input type="time" name="tuesday_to[]" class="form-control"
                                           @if($tuesday_data) value="{{$tuesday_data->to}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to"></label>
                                    <br>
                                    <br>
                                    <a href="{{route('job_times.show',2)}}"
                                       class="btn btn-success">{{ __('messages.day_details') }}</a>
                                </div>
                            </div>
                            {{-- wednesday --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    {{ __('messages.wednesday') }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input data-day="wdnesday"
                                               @if($wednesday_data) @if($wednesday_data->holiday == 0) checked
                                               @endif @endif class="day_work" name="wednesday_work"
                                               type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- wednesday work time --}}
                            <div class="row time-range wdnesday"
                                 @if($wednesday_data) @if($wednesday_data->holiday == 0) style="display: flex;" @endif @endif>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="wednesday_from">{{ __('messages.from') }}</label>
                                    <input type="time" name="wednesday_from[]" class="form-control"
                                           @if($wednesday_data) value="{{$wednesday_data->from}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="wednesday_to">{{ __('messages.to') }}</label>
                                    <input type="time" name="wednesday_to[]" class="form-control"
                                           @if($wednesday_data) value="{{$wednesday_data->to}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to"></label>
                                    <br>
                                    <br>
                                    <a href="{{route('job_times.show',3)}}"
                                       class="btn btn-success">{{ __('messages.day_details') }}</a>
                                </div>
                            </div>
                            {{-- thursday --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    {{ __('messages.thursday') }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input data-day="thrusday"
                                               @if($thursday_data) @if($thursday_data->holiday == 0) checked
                                               @endif  @endif class="day_work" name="thursday_work"
                                               type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- thursday work time --}}
                            <div class="row time-range thrusday"
                                 @if($thursday_data) @if($thursday_data->holiday == 0) style="display: flex;" @endif @endif >
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="thursday_from">{{ __('messages.from') }}</label>
                                    <input type="time" name="thursday_from[]" class="form-control"
                                           @if($thursday_data) value="{{$thursday_data->from}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="thursday_to">{{ __('messages.to') }}</label>
                                    <input type="time" name="thursday_to[]" class="form-control"
                                           @if($thursday_data) value="{{$thursday_data->to}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to"></label>
                                    <br>
                                    <br>
                                    <a href="{{route('job_times.show',4)}}"
                                       class="btn btn-success">{{ __('messages.day_details') }}</a>
                                </div>
                            </div>
                            {{-- friday --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    {{ __('messages.friday') }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input data-day="friday"
                                               @if($friday_data) @if($friday_data->holiday == 0) checked
                                               @endif @endif  class="day_work" name="friday_work" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- friday work time --}}
                            <div class="row time-range friday"
                                 @if($friday_data) @if($friday_data->holiday == 0) style="display: flex;" @endif @endif>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="friday_from">{{ __('messages.from') }}</label>
                                    <input type="time" name="friday_from[]" class="form-control"
                                           @if($friday_data) value="{{$friday_data->from}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="friday_to">{{ __('messages.to') }}</label>
                                    <input type="time" name="friday_to[]" class="form-control"
                                           @if($friday_data) value="{{$friday_data->to}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to"></label>
                                    <br>
                                    <br>
                                    <a href="{{route('job_times.show',5)}}"
                                       class="btn btn-success">{{ __('messages.day_details') }}</a>
                                </div>
                            </div>
                            {{-- saturday --}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    {{ __('messages.saturday') }}
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                                        <input data-day="saturday"
                                               @if($saturday_data) @if($saturday_data->holiday == 0) checked
                                               @endif @endif  class="day_work" name="saturday_work"
                                               type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            {{-- saturday work time --}}
                            <div class="row time-range saturday"
                                 @if($saturday_data) @if($saturday_data->holiday == 0) style="display: flex;" @endif @endif >
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="saturday_from">{{ __('messages.from') }}</label>
                                    <input type="time" name="saturday_from[]" class="form-control"
                                           @if($saturday_data) value="{{$saturday_data->from}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="saturday_to">{{ __('messages.to') }}</label>
                                    <input type="time" name="saturday_to[]" class="form-control"
                                           @if($saturday_data) value="{{$saturday_data->to}}" @endif >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                    <label for="sunday_to"></label>
                                    <br>
                                    <br>
                                    <a href="{{route('job_times.show',6)}}"
                                       class="btn btn-success">{{ __('messages.day_details') }}</a>
                                </div>
                            </div>
                        </section>
                        <div class="code-section-container">
                            <input type="submit" value="{{ __('messages.save') }}" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var previous = "{{ __('messages.previous') }}",
            next = "{{ __('messages.next') }}",
            finish = "{{ __('messages.finish') }}"
        $(".day_work").change(function () {
            var day = $(this).data('day'),
                reservationType = $("#reservation_type").val()
            if ($(this).is(':checked')) {
                $("." + day).css({"display": "flex"})
                if (reservationType == "attendance") {
                    $(this).parents(".row").next().find('.count').show()
                } else {
                    $(this).parents(".row").next().find('.count').hide()
                }
            } else {
                $("." + day).css({"display": "none"})
            }
        })
        $(".time-range").on("click", ".deletetime", function () {
            $(this).parent(".time-range").remove()
        })
    </script>
@endpush
