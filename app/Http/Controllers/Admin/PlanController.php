<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Models\Service_details;
use Illuminate\Http\Request;
use App\Plan_details;
use App\Plan;

class PlanController extends AdminController
{
    // show
    public function index()
    {
        $data['plans'] = Plan::where('deleted', '0')->OrderBy('id', 'asc')->get();
        return view('admin.plans.index', ["data" => $data]);
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'title_ar' => 'required',
                'title_en' => 'required',
                'cat_id' => 'required',
                'work_hours' => 'required|numeric',
                'price' => 'required|numeric'
            ]);
        $plan = Plan::create($data);
        foreach ($request->rows as $row) {
            if ($row['title_ar'] != null && $row['title_en'] != null) {
                $row['plan_id'] = $plan->id;
                Plan_details::create($row);
            }
        }
        session()->flash('success', trans('messages.added_s'));
        return redirect(route('plans.show', $request->cat_id));
    }

    public function edit($id)
    {

        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    public function update_plan_status(Request $request)
    {
        $data['status'] = $request->status;
        Plan::where('id', $request->id)->update($data);
        return 1;
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate(\request(),
            [
                'title_ar' => 'required',
                'title_en' => 'required',
                'price' => 'required|numeric'
            ]);
        Plan::where('id', $id)->update($data);
        session()->flash('success', trans('messages.updated_s'));
        return redirect(route('plans.index'));
    }

    public function show($id)
    {
        $data = Plan::where('cat_id', $id)->where('deleted', '0')->OrderBy('id', 'asc')->get();
        $category = Category::find($id);
        return view('admin.plans.create', compact('category', 'data'));
    }

    public function destroy($id)
    {
        $data['deleted'] = '1';
        Plan::where('id', $id)->update($data);
        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }

    // plan details actions
    public function plans_details($plan_id)
    {
        $plan_details = Plan_details::where('plan_id', $plan_id)->get();
        return view('admin.plans.plan_details.index', compact('plan_details', 'plan_id'));
    }

    public function create_details($plan_id)
    {
        return view('admin.plans.plan_details.create', compact('plan_id'));
    }

    public function update_status(Request $request)
    {
        $data['status'] = $request->status;
        Plan_details::where('id', $request->id)->update($data);
        return 1;
    }

    public function store_details(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'plan_id' => 'required|exists:plans,id',
                'title_ar' => 'required',
                'title_en' => 'required'
            ]);
        Plan_details::create($data);
        session()->flash('success', trans('messages.added_s'));
        return redirect(route('plans.details', $request->plan_id));
    }

    public function edit_details($detail_id)
    {
        $detail = Plan_details::findOrFail($detail_id);
        return view('admin.plans.plan_details.edit', compact('detail'));
    }

    public function update_details(Request $request, $detail_id)
    {
        $detail = Plan_details::findOrFail($detail_id);
        $data = $this->validate(\request(),
            [
                'title_ar' => 'required',
                'title_en' => 'required'
            ]);
        Plan_details::where('id', $detail_id)->update($data);
        session()->flash('success', trans('messages.updated_s'));
        return redirect(route('plans.details', $detail->plan_id));
    }

    public function delete_details($detail_id)
    {
        Plan_details::where('id', $detail_id)->delete();
        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }

    public function show_div($type)
    {
        return 1;
    }
}
