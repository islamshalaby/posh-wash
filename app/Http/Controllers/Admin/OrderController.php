<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderDetail;
use App\UserAddress;
use Illuminate\Http\Request;
use App\City;
use App\Area;

class OrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::OrderBy('id','desc')->get();
        return view('admin.orders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create');
    }


    public function store(Request $request)
    {
        $data = $this->validate(\request(),
        [
            'title_ar' => 'required',
            'title_en' => 'required'
        ]);
        City::create($data);
        session()->flash('success', trans('messages.added_s'));
        return redirect( route('cities.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $order = Order::find($id);
        $data = OrderDetail::where('order_id',$id)->OrderBy('id','desc')->get();
        return view('admin.orders.details', compact('data','order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $data = UserAddress::findOrFail($id);
        return view('admin.orders.address_details', compact('data'));
    }
    public function update(Request $request, $id) {
        $data = $this->validate(\request(),
            [
                'title_ar' => 'required',
                'title_en' => 'required'
            ]);
        City::findOrFail($id)->update($data);
        session()->flash('success', trans('messages.updated_s'));
        return redirect( route('cities.index'));
    }

    public function change_status($id,$status)
    {
        OrderDetail::findOrFail($id)->update(['status'=>$status]);
        session()->flash('success', trans('messages.status_changed'));
        return back();
    }

    public function main_order_change_status($id,$status)
    {
        Order::findOrFail($id)->update(['status'=>$status]);
        session()->flash('success', trans('messages.status_changed'));
        return back();
    }


}
