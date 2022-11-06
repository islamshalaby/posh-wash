<?php

namespace App\Http\Controllers\Admin;

use App\DayTime;
use App\TimesOfWork;
use Illuminate\Http\Request;
use App\City;
use App\Area;
use App\Category;
use App\Plan;

class JobTimesController extends AdminController
{
    public function index()
    {
        $sunday_data = TimesOfWork::where('day', 0)->first();
        $monday_data = TimesOfWork::where('day', 1)->first();
        $tuesday_data = TimesOfWork::where('day', 2)->first();
        $wednesday_data = TimesOfWork::where('day', 3)->first();
        $thursday_data = TimesOfWork::where('day', 4)->first();
        $friday_data = TimesOfWork::where('day', 5)->first();
        $saturday_data = TimesOfWork::where('day', 6)->first();
        return view('admin.job_times.index', compact('sunday_data', 'monday_data', 'tuesday_data', 'wednesday_data'
            , 'thursday_data', 'friday_data', 'saturday_data'));
    }

    public function show($id)
    {
        $data = DayTime::where('day',$id)->get();
        return view('admin.job_times.day_details', compact('data'));
    }

    public function edit($id)
    {
        $data = DayTime::findOrFail($id);
        if($data->work_time == 1){
            $data->work_time = 0;
        }else{
            $data->work_time = 1;
        }
        $data->save();
        return back();
    }

    public function create()
    {
        $categories = Category::where('deleted', '0')->get();
        $sunday_data = TimesOfWork::where('day', 0)->first();
        $monday_data = TimesOfWork::where('day', 1)->first();
        $tuesday_data = TimesOfWork::where('day', 2)->first();
        $wednesday_data = TimesOfWork::where('day', 3)->first();
        $thursday_data = TimesOfWork::where('day', 4)->first();
        $friday_data = TimesOfWork::where('day', 5)->first();
        $saturday_data = TimesOfWork::where('day', 6)->first();
        return view('admin.job_times.create', compact('sunday_data', 'monday_data', 'tuesday_data', 'wednesday_data'
            , 'thursday_data', 'friday_data', 'saturday_data', 'categories'));
    }

    // get plans by category
    public function get_plans_by_category(Request $request)
    {
        $data = Plan::where('cat_id', $request->cat_id)->where('deleted', '0')->get();
        // return ajax response
        return response()->json($data);
    }


    public function store(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'category_id' => 'required',
                'plan_id' => 'required',
            ]);
        TimesOfWork::truncate();
        DayTime::where('plan_id', $request->plan_id)->delete();

        if ($request->sunday_work) {
            if (count($request->sunday_from) > 0) {
                for ($i = 0; $i < count($request->sunday_from); $i++) {
                    $workTime = [];
                    var_dump($request->sunday_from[$i]);
                    var_dump($request->sunday_to[$i]);
                    $sunday['day'] = 0;
                    $sunday['holiday'] = 0;
                    $sunday['from'] = $request->sunday_from[$i];
                    $sunday['to'] = $request->sunday_to[$i];
                    TimesOfWork::create($sunday);

                    //make day times
                    $date1 = new \DateTime($request->sunday_from[$i]);
                    $date2 = new \DateTime($request->sunday_to[$i]);
                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    $time = $request->sunday_from[$i];
                    for ($i = 0; $i <= $hours; $i++) {
                        $day_data['day'] = 0;
                        $day_data['time_from'] = $time;
                        $time_to = date('H:i:s', strtotime($time . '+1 hour'));
                        $day_data['time_to'] = $time_to;
                        $day_data['plan_id'] = $request->plan_id;
                        DayTime::create($day_data);
                        $time = date('H:i:s', strtotime($time . '+1 hour'));
                    }
                }
            }
        } else {
            $workTime = [];
            $workTime['day'] = 0;
            $workTime['holiday'] = 1;
            TimesOfWork::create($workTime);
        }
        if ($request->monday_work) {
            if (count($request->monday_from) > 0) {
                for ($i = 0; $i < count($request->monday_from); $i++) {
                    $workTime = [];
                    $workTime['day'] = 1;
                    $workTime['holiday'] = 0;
                    $workTime['from'] = $request->monday_from[$i];
                    $workTime['to'] = $request->monday_to[$i];
                    TimesOfWork::create($workTime);

                    //make day times
                    $date1 = new \DateTime($request->monday_from[$i]);
                    $date2 = new \DateTime($request->monday_to[$i]);
                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    $time = $request->monday_from[$i];
                    for ($i = 0; $i <= $hours; $i++) {
                        $day_data['day'] = 1;
                        $day_data['time_from'] = $time;
                        $time_to = date('H:i:s', strtotime($time . '+1 hour'));
                        $day_data['time_to'] = $time_to;
                        $day_data['plan_id'] = $request->plan_id;
                        DayTime::create($day_data);
                        $time = date('H:i:s', strtotime($time . '+1 hour'));
                    }
                }
            }
        } else {
            $workTime = [];
            $workTime['day'] = 1;
            $workTime['holiday'] = 1;
            TimesOfWork::create($workTime);
        }
        if ($request->tuesday_work) {
            if (count($request->tuesday_from) > 0) {
                for ($i = 0; $i < count($request->tuesday_from); $i++) {
                    $workTime = [];
                    $workTime['day'] = 2;
                    $workTime['holiday'] = 0;
                    $workTime['from'] = $request->tuesday_from[$i];
                    $workTime['to'] = $request->tuesday_to[$i];
                    TimesOfWork::create($workTime);

                    //make day times
                    $date1 = new \DateTime($request->tuesday_from[$i]);
                    $date2 = new \DateTime($request->tuesday_to[$i]);
                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    $time = $request->tuesday_from[$i];
                    for ($i = 0; $i <= $hours; $i++) {
                        $day_data['day'] = 2;
                        $day_data['time_from'] = $time;
                        $time_to = date('H:i:s', strtotime($time . '+1 hour'));
                        $day_data['time_to'] = $time_to;
                        $day_data['plan_id'] = $request->plan_id;
                        DayTime::create($day_data);
                        $time = date('H:i:s', strtotime($time . '+1 hour'));
                    }
                }
            }
        } else {
            $workTime = [];
            $workTime['day'] = 2;
            $workTime['holiday'] = 1;
            TimesOfWork::create($workTime);
        }
        if ($request->wednesday_work) {
            if (count($request->wednesday_from) > 0) {
                for ($i = 0; $i < count($request->wednesday_from); $i++) {
                    $workTime = [];
                    $workTime['day'] = 3;
                    $workTime['holiday'] = 0;
                    $workTime['from'] = $request->wednesday_from[$i];
                    $workTime['to'] = $request->wednesday_to[$i];
                    TimesOfWork::create($workTime);

                    //make day times
                    $date1 = new \DateTime($request->wednesday_from[$i]);
                    $date2 = new \DateTime($request->wednesday_to[$i]);
                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    $time = $request->wednesday_from[$i];
                    for ($i = 0; $i <= $hours; $i++) {
                        $day_data['day'] = 3;
                        $day_data['time_from'] = $time;
                        $time_to = date('H:i:s', strtotime($time . '+1 hour'));
                        $day_data['time_to'] = $time_to;
                        $day_data['plan_id'] = $request->plan_id;
                        DayTime::create($day_data);
                        $time = date('H:i:s', strtotime($time . '+1 hour'));
                    }
                }
            }
        } else {
            $workTime = [];
            $workTime['day'] = 3;
            $workTime['holiday'] = 1;
            TimesOfWork::create($workTime);
        }
        if ($request->thursday_work) {
            if (count($request->thursday_from) > 0) {
                for ($i = 0; $i < count($request->thursday_from); $i++) {
                    $workTime = [];
                    $workTime['day'] = 4;
                    $workTime['holiday'] = 0;
                    $workTime['from'] = $request->thursday_from[$i];
                    $workTime['to'] = $request->thursday_to[$i];
                    TimesOfWork::create($workTime);

                    //make day times
                    $date1 = new \DateTime($request->thursday_from[$i]);
                    $date2 = new \DateTime($request->thursday_to[$i]);
                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    $time = $request->thursday_from[$i];
                    for ($i = 0; $i <= $hours; $i++) {
                        $day_data['day'] = 4;
                        $day_data['time_from'] = $time;
                        $time_to = date('H:i:s', strtotime($time . '+1 hour'));
                        $day_data['time_to'] = $time_to;
                        $day_data['plan_id'] = $request->plan_id;
                        DayTime::create($day_data);
                        $time = date('H:i:s', strtotime($time . '+1 hour'));
                    }
                }
            }
        } else {
            $workTime = [];
            $workTime['day'] = 4;
            $workTime['holiday'] = 1;
            TimesOfWork::create($workTime);
        }
        if ($request->friday_work) {
            if (count($request->friday_from) > 0) {
                for ($i = 0; $i < count($request->friday_from); $i++) {
                    $workTime = [];
                    $workTime['day'] = 5;
                    $workTime['holiday'] = 0;
                    $workTime['from'] = $request->friday_from[$i];
                    $workTime['to'] = $request->friday_to[$i];
                    TimesOfWork::create($workTime);

                    //make day times
                    $date1 = new \DateTime($request->friday_from[$i]);
                    $date2 = new \DateTime($request->friday_to[$i]);
                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    $time = $request->friday_from[$i];
                    for ($i = 0; $i <= $hours; $i++) {
                        $day_data['day'] = 5;
                        $day_data['time_from'] = $time;
                        $time_to = date('H:i:s', strtotime($time . '+1 hour'));
                        $day_data['time_to'] = $time_to;
                        $day_data['plan_id'] = $request->plan_id;
                        DayTime::create($day_data);
                        $time = date('H:i:s', strtotime($time . '+1 hour'));
                    }
                }
            }
        } else {
            $workTime = [];
            $workTime['day'] = 5;
            $workTime['holiday'] = 1;
            TimesOfWork::create($workTime);
        }
        if ($request->saturday_work) {
            if (count($request->saturday_from) > 0) {
                for ($i = 0; $i < count($request->saturday_from); $i++) {
                    $workTime = [];
                    $workTime['day'] = 6;
                    $workTime['holiday'] = 0;
                    $workTime['from'] = $request->saturday_from[$i];
                    $workTime['to'] = $request->saturday_to[$i];
                    TimesOfWork::create($workTime);

                    //make day times
                    $date1 = new \DateTime($request->saturday_from[$i]);
                    $date2 = new \DateTime($request->saturday_to[$i]);
                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    $time = $request->saturday_from[$i];
                    for ($i = 0; $i <= $hours; $i++) {
                        $day_data['day'] = 6;
                        $day_data['time_from'] = $time;
                        $time_to = date('H:i:s', strtotime($time . '+1 hour'));
                        $day_data['time_to'] = $time_to;
                        $day_data['plan_id'] = $request->plan_id;
                        DayTime::create($day_data);
                        $time = date('H:i:s', strtotime($time . '+1 hour'));
                    }
                }
            }
        } else {
            $workTime = [];
            $workTime['day'] = 6;
            $workTime['holiday'] = 1;
            TimesOfWork::create($workTime);
        }
        session()->flash('success', trans('messages.save_s'));
        return redirect()->back();
    }
}
