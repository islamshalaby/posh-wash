@extends('admin.app')
@section('title' , __('messages.day_details'))
@section('scripts')
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js" type="text/javascript"></script>
@endsection
@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.day_details') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ __('messages.from') }}</th>
                            <th>{{ __('messages.to') }}</th>
                            <th class="text-center">{{ __('messages.time_status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $row)
                            <tr>
                                <td class="text-center">{{ $row->time_from }}</td>
                                <td class="text-center">{{ $row->time_to }}</td>
                                <td class="text-center blue-color">
                                    @if($row->work_time == 1)
                                        <a class="btn btn-success" href="{{ route('job_times.edit',$row->id) }}">
                                            {{ __('messages.actived') }}
                                        </a>
                                    @else
                                        <a class="btn btn-danger" href="{{ route('job_times.edit',$row->id) }}">
                                            {{ __('messages.not_actived') }}
                                        </a>
                                    @endif
                                </td>
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
