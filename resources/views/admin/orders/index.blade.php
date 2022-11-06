@extends('admin.app')

@section('title' , __('messages.orders'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <h4>{{ __('messages.orders') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div clSass="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">{{ __('messages.user_name') }}</th>
                            <th class="text-center">{{ __('messages.total') }}</th>
                            <th class="text-center">{{ __('messages.date') }}</th>
                            <th class="text-center">{{ __('messages.details') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $row)
                            <tr>
                                <td class="text-center blue-color">{{  $row->User->name }}</td>
                                <td class="text-center blue-color">{{  $row->total }}</td>
                                <td class="text-center blue-color">{{  $row->created_at->format('Y-m-d') }}</td>
                                <td class="text-center blue-color">
                                    <a
                                        href="{{ route('orders.show', $row->id) }}"><i
                                            class="far fa-eye"></i></a>
                                </td>
                                <td class="text-center blue-color">
                                    @if($row->status == 'pindding')
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm">{{ __('messages.pinding') }}</button>
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference5" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference5">
                                                <a class="dropdown-item"
                                                   href="{{route('main_order.change_status',['id'=>$row->id,'status'=>'accepted'])}}"
                                                   style="color: green; text-align: center;">{{ __('messages.done') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('main_order.change_status',['id'=>$row->id,'status'=>'rejected'])}}"
                                                   style="color: red; text-align: center;">{{ __('messages.reject') }}</a>
                                            </div>
                                        </div>
                                    @elseif($row->status == 'accepted')
                                        <h5 style="color: green;">{{ __('messages.done') }}</h5>
                                    @else
                                        <h5 style="color: red;">{{ __('messages.reject') }}</h5>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
