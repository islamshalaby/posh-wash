@extends('admin.app')

@section('title' , __('messages.plans'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.working_days') }} ( {{ app()->getLocale() == 'en' ? $plan->title_en : $plan->title_ar }} )</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <a class="btn btn-primary" href="{{route('job_times.create')}}">{{ __('messages.change_working_times') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th class="text-center blue-color">{{ __('messages.days_of_week') }}</th>
                        <th class="text-center blue-color">{{ __('messages.work_start_time') }}</th>
                        <th class="text-center blue-color">{{ __('messages.work_end_time') }}</th>
                        <th class="text-center blue-color">{{ __('messages.working_hours') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $day)
                        <tr>
                            <td class="text-center blue-color">{{ $day->day }}</td>
                            <td class="text-center blue-color">
                                {{ $day->start }}
                            </td>
                            <td class="text-center blue-color">{{ $day->end }}</td>
                            <td class="text-center blue-color">
                                <a href="{{ route('plans.day_hours', [$plan->id, $day->day_number]) }}"><i
                                class="far fa-edit"></i></a>
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

