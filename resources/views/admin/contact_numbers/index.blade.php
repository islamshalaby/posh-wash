@extends('admin.app')

@section('title' , __('messages.show_contact_numbers'))

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div class="row">
				
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ __('messages.show_contact_numbers') }}</h4>
					
                </div>
                @if(Auth::user()->add_data)
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <a class="btn btn-primary" href="{{route('contact_numbers.create')}}">{{ __('messages.add') }}</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>    
                            <th>{{ __('messages.phone') }}</th>                           
                            @if(Auth::user()->delete_data) 
                                <th class="text-center" >{{ __('messages.delete') }}</th>                            
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $number)
                            <tr >
                                <td><?=$i;?></td>
                                <td>{{ $number->phone }}</td>
                                @if(Auth::user()->delete_data) 
                                    <td class="text-center blue-color" >
                                        <form action="{{ route('contact_numbers.destroy', $number->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.are_you_sure') }}');"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                        
                                    </td>                                
                                @endif
                                <?php $i++; ?>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="paginating-container pagination-solid">
            <ul class="pagination">
                <li class="prev"><a href="{{$data['contact_us']->previousPageUrl()}}">Prev</a></li>
                @for($i = 1 ; $i <= $data['contact_us']->lastPage(); $i++ )
                    <li class="{{ $data['contact_us']->currentPage() == $i ? "active" : '' }}"><a href="/admin-panel/contact_us/?page={{$i}}">{{$i}}</a></li>               
                @endfor
                <li class="next"><a href="{{$data['contact_us']->nextPageUrl()}}">Next</a></li>
            </ul>
        </div>   --}}
        
    </div>  

@endsection