@extends('admin.app')

@section('title' , __('messages.address_details'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>{{ __('messages.address_details') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-bordered mb-4">
                        <tbody>
                        <tr>
                            <td class="label-table"> {{ __('messages.city') }}</td>
                            <td>

                                {{ $data->area->City->title }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.address_title') }}</td>
                            <td>
                                {{ $data->title }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.area') }}</td>
                            <td>
                                {{ $data->area->title }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.piece') }} </td>
                            <td>
                                {{ $data->piece }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.street') }} </td>
                            <td>
                                {{ $data->street }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.gaddah') }} </td>
                            <td>
                                {{ $data->gaddah}}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.building') }} </td>
                            <td>
                                {{ $data->building }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.floor') }} </td>
                            <td>
                                {{ $data->floor }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label-table"> {{ __('messages.apartment_number') }} </td>
                            <td>
                                {{ $data->apartment_number }}
                            </td>
                        </tr>

                        <tr>
                            <td class="label-table"> {{ __('messages.extra_details') }} </td>
                            <td>
                                {{ $data->extra_details }}
                            </td>
                        <tr>
                            <td class="label-table"> {{ __('messages.phone') }} </td>
                            <td>
                                {{ $data->phone }}
                            </td>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection
