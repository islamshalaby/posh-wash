@extends('admin.app')

@section('title' , __('messages.details'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <h4>{{ __('messages.details') }}</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div clSass="table-responsive">
                    <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">{{ __('messages.category') }}</th>
                            <th class="text-center">{{ __('messages.order_date') }}</th>
                            <th class="text-center">{{ __('messages.plan') }}</th>
                            <th class="text-center">{{ __('messages.timing') }}</th>
                            <th class="text-center">{{ __('messages.address_details') }}</th>
                            <th class="text-center">{{ __('messages.status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $row)
                            <tr>
                                <td class="text-center blue-color">{{  $row->Category->title  }}
                                    @if($row->SubCategory)
                                        ( {{$row->SubCategory->title}} )
                                    @endif
                                </td>
                                <td class="text-center blue-color">{{  $row->order_date }}</td>
                                <td class="text-center blue-color">{{  $row->Plan->title  }}
                                    ( {{$row->Plan->price}} )
                                </td>
                                <td class="text-center blue-color">
                {{--  TODO : Eslam i want here to diplay first and last time (optional) and contact Eng/nouh for details  --}}
                                   @foreach($row->Times as $time)
                                       {{$time->Time_details->time_from}} -   {{$time->Time_details->time_to}}
                                       <br>
                                    @endforeach
                                </td>
                                <td class="text-center blue-color"><a
                                        href="{{ route('orders.edit', $row->address_id) }}"><i
                                            class="far fa-eye"></i></a>
                                </td>
                                <td class="text-center blue-color">
                                    @if($row->status == 'pinding')
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
                                                   href="{{route('orders.change_status',['id'=>$row->id,'status'=>'done'])}}"
                                                   style="color: green; text-align: center;">{{ __('messages.done') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="{{route('orders.change_status',['id'=>$row->id,'status'=>'rejected'])}}"
                                                   style="color: red; text-align: center;">{{ __('messages.reject') }}</a>
                                            </div>
                                        </div>
                                    @elseif($row->status == 'done')
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
