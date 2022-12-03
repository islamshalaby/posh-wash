@extends('admin.app')

@section('title' , __('messages.orders'))

@push('scripts')

    <script>
        var language = "{{ Config::get('app.locale') }}"
        $("#orderStatus, #toDate").on("change", function() {
            $("#filter-form").submit()
        })
        var sumPrice = "{{ $sum_total }}",
            totalString = "{{ __('messages.total') }}",
            dinar = "{{ __('messages.dinar') }}"

            
        var dTbls = $('#order-tbl').DataTable( {
            dom: 'Blfrtip',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    }},
                    { extend: 'csv', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    } },
                    { extend: 'excel', className: 'btn', footer: true, exportOptions: {
                        columns: ':visible',
                        rows: ':visible'
                    } },
                    { extend: 'print', className: 'btn', footer: true, 
                        exportOptions: {
                            columns: ':visible',
                            rows: ':visible'
                        },customize: function(win) {
                            $(win.document.body).prepend(`<br /><h4 style="border-bottom: 1px solid; padding : 10px">${totalString} : ${sumPrice} ${dinar}</h4>`); //before the table
                          }
                    }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [50, 100, 1000, 10000, 100000, 1000000, 2000000, 3000000, 4000000, 5000000],
            "pageLength": 50  
        } );
        console.log(dTbls)
    </script>
    <script>
        var total = dTbls.column(2).data(),
            dinar = "{{ __('messages.dinar') }}"
            console.log("total", total)
        var allTotal = parseFloat(total.reduce(function (a, b) { return parseFloat(a) + parseFloat(b); }, 0)).toFixed(3)

        $("#order-tbl tfoot").find('th').eq(2).text(`${allTotal} ${dinar}`);
    </script>
    
@endpush

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <form id="filter-form">
                    <div class="row">
                        {{--  <div class="form-group col-md-3">
                            <label for="area">{{ __('messages.area') }}</label>
                            <select required id="area_select" name="area_id" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                @foreach ( $data['areas'] as $area )
                                <option {{ isset($data['area']) && $data['area']['id'] == $area->id ? 'selected' : '' }} value="{{ $area->id }}">{{ App::isLocale('en') ? $area->title_en : $area->title_ar }}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="from">{{ __('messages.from') }}</label>
                                        <input required type="date" name="from" class="form-control" id="from" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="toDate">{{ __('messages.to') }}</label>
                                        <input required type="date" name="to" class="form-control" id="toDate" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="payment_select">{{ __('messages.payment_method') }}</label>
                            <select required id="payment_select" name="method" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                
                                <option {{ isset($data['method']) && $data['method'] == 1 ? 'selected' : '' }} value="1">{{ __('messages.key_net') }}</option>
                                <option {{ isset($data['method']) && $data['method'] == 2 ? 'selected' : '' }} value="2">{{ __('messages.cash') }}</option>
                                <option {{ isset($data['method']) && $data['method'] == 3 ? 'selected' : '' }} value="3">{{ __('messages.wallet') }}</option>
                                
                            </select>
                        </div>  --}}

                        <div class="form-group col-md-6">
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="from">{{ __('messages.from') }}</label>
                                        <input required type="date" name="from" class="form-control" id="from" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="toDate">{{ __('messages.to') }}</label>
                                        <input required type="date" name="to" class="form-control" id="toDate" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="orderStatus">{{ __('messages.status') }}</label>
                            <select required id="orderStatus" name="order_status" class="form-control">
                                <option disabled selected>{{ __('messages.select') }}</option>
                                
                                <option {{ app('request')->input('order_status') && app('request')->input('order_status') == 'pindding' ? 'selected' : '' }} value="pindding">{{ __('messages.pinding') }}</option>
                                <option {{ app('request')->input('order_status') && app('request')->input('order_status') == 'accepted' ? 'selected' : '' }} value="accepted">{{ __('messages.done') }}</option>
                                <option {{ app('request')->input('order_status') && app('request')->input('order_status') == 'rejected' ? 'selected' : '' }} value="rejected">{{ __('messages.reject') }}</option>
                            </select>
                        </div>
                    </div>
                </form>
                
        
            </div>
            <div class="widget-header">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <h4>{{ __('messages.orders') }}</h4>
                    </div>
                </div>
            </div>

            <div class="widget-content widget-content-area">
                <div class="table-responsive"> 
                    <table id="order-tbl" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="text-center">{{ __('messages.user_name') }}</th>
                                <th class="text-center">{{ __('messages.total') }}</th>
                                <th class="text-center">{{ __('messages.date') }}</th>
                                <th class="text-center">{{ __('messages.details') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php $i = 1; ?>
                        @foreach ($data as $row)
                            <tr>
                                <td><?=$i;?></td>
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
                            <?php $i++; ?>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              <th>{{ __('messages.total') }}:</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                        </tfoot>
                    </table>


                    
                </div>
            </div>
        </div>
    </div>
@endsection
