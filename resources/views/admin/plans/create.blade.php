@extends('admin.app')

@section('title' , __('messages.packages'))

@section('content')
    <h3>
        {{ __('messages.packages_category') }}
        @if(app()->getLocale() == 'ar')
            ( {{ $category->title_ar }} )
        @else
        ( {{  $category->title_ar }} )
        @endif
    </h3>
    <div class="col-lg-12 col-12 layout-spacing">
        <div id="toggleAccordion">
            <div class="card">
                <div class="card-header" id="...">
                    <section class="mb-0 mt-0">
                        <div role="menu" class="collapsed" data-toggle="collapse"
                             data-target="#defaultAccordionOne" aria-expanded="true"
                             aria-controls="defaultAccordionOne">
                            {{ __('messages.add_plan') }}
                            <div class="icons">
                                <svg> ...</svg>
                            </div>
                        </div>
                    </section>
                </div>
                <div id="defaultAccordionOne" class="collapse" aria-labelledby="..."
                     data-parent="#toggleAccordion">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>{{ __('messages.package_data') }}</h4>
                                </div>
                            </div>
                        </div>
                        <form action="{{route('plans.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cat_id" value="{{$category->id}}">
                            <div class="form-group mb-4">
                                <label for="plan_price">{{ __('messages.plan_name_ar') }}</label>
                                <input type="text" name="title_ar" class="form-control">
                            </div>
                            <div class="form-group mb-4">
                                <label for="plan_price">{{ __('messages.plan_name_en') }}</label>
                                <input required type="text" name="title_en" class="form-control">
                            </div>
                            <div class="form-group mb-4">
                                <label for="plan_price">{{ __('messages.work_hours') }}</label>
                                <input required type="number" name="work_hours" value="1"  class="form-control" id="work_hours" min="1">
                            </div>
                            <div class="form-group mb-4">
                                <label for="plan_price">{{ __('messages.plan_price') }}</label>
                                <input required type="number" name="price" class="form-control" id="plan_price"
                                       step="any" min="0">
                            </div>
                            <div class="form-group row">
                                <label for="plan_price">{{ __('messages.package_details') }}</label>
                                <div class="card-body parent" style='text-align:right' id="parent">
                                    <button type='button' value='Add Button' id='addButton' class="btn btn-primary">
                                        <i class="fa fa-plus"></i></button>
                                    <div class="panel" style='text-align:right'></div>
                                </div>
                            </div>
                            <input type="submit" value="{{ __('messages.add') }}" class="btn btn-success">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th class="text-center blue-color">Id</th>
                        <th class="text-center blue-color">{{ __('messages.plane_name') }}</th>
                        <th class="text-center blue-color">{{ __('messages.plan_price') }}</th>
                        <th class="text-center blue-color">{{ __('messages.view') }}</th>
                        <th class="text-center blue-color">{{ __('messages.working_days') }}</th>
                        <th class="text-center blue-color">{{ __('messages.details') }}</th>
                        @if(Auth::user()->update_data)
                            <th class="text-center">{{ __('messages.edit') }}</th>
                        @endif
                        @if(Auth::user()->delete_data)
                            <th class="text-center">{{ __('messages.delete') }}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $plan)
                        <tr>
                            <td class="text-center blue-color"><?=$i;?></td>
                            <td class="text-center blue-color">{{ app()->getLocale() == 'en' ? $plan->title_en : $plan->title_ar }}</td>
                            <td class="text-center blue-color">{{ $plan->price }} {{ __('messages.dinar') }}</td>
                            <td class="text-center">
                                <div class="switch">
                                    <label>
                                        <input onchange="update_status(this)" value="{{ $plan->id }}"
                                               type="checkbox" <?php if ($plan->status == 'show') echo "checked";?> >
                                        <span class="lever switch-col-indigo"></span>
                                    </label>
                                </div>
                            </td>
                            <td class="text-center blue-color">
                                <a href="{{ route('plans.working_days', $plan->id) }}" class="btn btn-primary"><i
                                    class="far fa-eye"></i></a>
                            </td>
                            <td class="text-center blue-color"><a href="{{ route('plans.details', $plan->id) }}"><i
                                        class="far fa-eye"></i></a></td>
                            @if(Auth::user()->update_data)
                                <td class="text-center blue-color"><a href="{{ route('plans.edit', $plan->id) }}"><i
                                            class="far fa-edit"></i></a></td>
                            @endif
                            @if(Auth::user()->delete_data)
                                <td class="text-center blue-color"><a
                                        onclick="return confirm('{{ __('messages.are_you_sure') }}');"
                                        href="{{ route('delete.plan', $plan->id) }}"><i
                                            class="far fa-trash-alt"></i></a></td>
                            @endif
                            <?php $i++; ?>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/admin/assets/js/plans.js"></script>
    <script>
        $(document).ready(function () {
            var i = 0;
            $("#addButton").click(function () {
                var options = '';
                var html = '';
                html += ' <div id="" class="form-group row">';
                html += "<div class='col-sm-6'>" +
                    "<input  name='rows[" + i + "][title_ar]' class='form-control' type='text' step ='0.01'  placeholder='ادخل اسم التفاصيل بالعربية'>" +
                    "</div>" +
                    "<div class='col-sm-6'>" +
                    "<input   name='rows[" + i + "][title_en]' class='form-control' type='text' step ='0.01'  placeholder='ادخل اسم التفاصيل بالانجليزية'>" +
                    "</div>" +
                    "</hr>" +
                    "</div>";
                $('#parent').append(html);
                i++;
            });
        });
    </script>
@endsection
