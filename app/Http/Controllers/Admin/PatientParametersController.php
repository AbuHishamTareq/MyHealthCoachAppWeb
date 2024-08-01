<?php

namespace App\Http\Controllers\Admin;

use App\Charts\BloodPressureChart;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BloodPressure;
use App\Models\Patient;
use App\Models\Rbs;
use App\Models\Step;
use App\Models\Weight;
use App\Notifications\NewTransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Auth;

class PatientParametersController extends Controller
{
    public function show($id)
    {
        $patient = Patient::where('id', $id)->first();
        
        $avgBp = BloodPressure::select(
            BloodPressure::raw('avg(systolic) as systolic'),
            BloodPressure::raw('avg(distolic) as distolic')
        )->where('patient_id', $id)->get();

        $avgBmi = Weight::select(
            Weight::raw('avg(bmi) as bmi')
        )->where('patient_id', $id)->get();

        return view('admin.operations.parameter.insert', compact('patient', 'avgBp', 'avgBmi'));
    }

    public function insert(Request $request, $id)
    {
        try {
            if (!empty($request->input('pWeight'))) {
                $checkWeight = Weight::where([
                    'patient_id' => $id,
                    'read_date' => \Carbon\Carbon::now()->toDateString()
                ])->first();

                if (empty($checkWeight)) {
                    $weight['patient_id'] = $id;
                    $weight['weight'] = $request->input('pWeight');
                    $weight['bmi'] = $request->input('bmi');
                    $weight['read_date'] = date('Y-m-d');
                    $weight['read_time'] = date('H:i:s');

                    Weight::create($weight);
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Weight Already Inserted !!');
                }
            }

            if (!empty($request->input('rbs'))) {
                $checkRbs = Rbs::where([
                    'patient_id' => $id,
                    'read_date' => \Carbon\Carbon::now()->toDateString()
                ])->first();

                if (empty($checkRbs)) {
                    $rbs['patient_id'] = $id;
                    $rbs['rbs'] = $request->input('rbs');
                    $rbs['read_date'] = date('Y-m-d');
                    $rbs['read_time'] = date('H:i:s');

                    Rbs::create($rbs);
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Rbs Already Inserted !!');
                }
            }

            if (!empty($request->input('bpSystolic')) && !empty($request->input('bpDistolic'))) {
                $checkBp = BloodPressure::where([
                    'patient_id' => $id,
                    'read_date' => \Carbon\Carbon::now()->toDateString()
                ])->first();

                if (empty($checkBp)) {
                    $bp['patient_id'] = $id;
                    $bp['systolic'] = $request->input('bpSystolic');
                    $bp['distolic'] = $request->input('bpDistolic');
                    $bp['read_date'] = date('Y-m-d');
                    $bp['read_time'] = date('H:i:s');

                    BloodPressure::create($bp);
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Blood Pressure Already Inserted !!');
                }
            } else {
                return redirect()->back()->withInput($request->input())->with('error', 'Systolic or Distolic is empty');
            }

            if (
                !empty($request->input('pWeight')) &&
                !empty($request->input('rbs')) &&
                !empty($request->input('bpSystolic')) &&
                !empty($request->input('bpDistolic'))
            ) {
                return redirect()->back()->with([
                    'success' => 'Health Parameters Saved Successfully !!'
                ]);
            } else if (!empty($request->input('pWeight')) && !empty($request->input('rbs'))) {
                return redirect()->back()->with([
                    'success' => 'Weight and Rbs Saved Successfully !!'
                ]);
            } else if (
                !empty($request->input('pWeight')) &&
                !empty($request->input('bpSystolic')) &&
                !empty($request->input('bpDistolic'))
            ) {
                return redirect()->back()->with([
                    'success' => 'Weight and Blood Pressure Saved Successfully !!'
                ]);
            } else if (
                !empty($request->input('rbs')) &&
                !empty($request->input('bpSystolic')) &&
                !empty($request->input('bpDistolic'))
            ) {
                return redirect()->back()->with([
                    'success' => 'Rbs and Blood Pressure Saved Successfully !!'
                ]);
            } else if (!empty($request->input('pWeight'))) {
                return redirect()->back()->with([
                    'success' => 'Weight Saved Successfully !!'
                ]);
            } else if (!empty($request->input('rbs'))) {
                return redirect()->back()->with([
                    'success' => 'Rbs Saved Successfully !!'
                ]);
            } else if (!empty($request->input('bpSystolic')) && !empty($request->input('bpDistolic'))) {
                return redirect()->back()->with([
                    'success' => 'Blood Pressure Saved Successfully !!'
                ]);
            }
        } catch (\Exception $ex) {
            return redirect()->back()->withInput($request->input())->with('error', $ex->getMessage());
        }
    }

    public function update($id)
    {
        $patient = Patient::where('id', $id)->first();

        $avgBp = BloodPressure::select(
            BloodPressure::raw('avg(systolic) as systolic'),
            BloodPressure::raw('avg(distolic) as distolic')
        )->where('patient_id', $id)->get();

        $avgBmi = Weight::select(
            Weight::raw('avg(bmi) as bmi')
        )->where('patient_id', $id)->get();

        $weights = Weight::where('patient_id', $id)->paginate(10); 
        $rbs = Rbs::where('patient_id', $id)->paginate(10);
        $bps = BloodPressure::where('patient_id', $id)->paginate(10);

        return view('admin.operations.parameter.update', compact('patient', 'avgBp', 'avgBmi', 'weights', 'rbs', 'bps'));
    }

    public function updateWeight(Request $request) {
        if($request->ajax()) {
            $data = $request->all();

            $bmi = $data['weight'] / (($data['height']/100) * ($data['height']/100));

            Weight::where('id', $data['row_id'])->update([
                'weight' => $data['weight'],
                'bmi' => $bmi
            ]);

            $avgBmi = Weight::select(
                Weight::raw('avg(bmi) as bmi')
            )->where('patient_id', $data['patient_id'])->get();

            return response()->json(([
                'weight' => number_format($data['weight'], 2),
                'bmi' => number_format($bmi, 2),
                'avg_bmi' => number_format($avgBmi[0]['bmi'], 2),
                'row_id' => $data['row_id']
            ]));
        }
    }

    public function updateRbs(Request $request) {
        if($request->ajax()) {
            $data = $request->all();

            Rbs::where('id', $data['row_id'])->update([
                'rbs' => $data['rbs']
            ]);

            return response()->json(([
                'rbs' => $data['rbs'],
                'row_id' => $data['row_id']
            ]));
        }
    }

    public function updateBp(Request $request) {
        if($request->ajax()) {
            $data = $request->all();

            BloodPressure::where('id', $data['row_id'])->update([
                'systolic' => $data['sys'],
                'distolic' => $data['dis']
            ]);

            $avgBp = BloodPressure::select(
                BloodPressure::raw('avg(systolic) as systolic'),
                BloodPressure::raw('avg(distolic) as distolic')
            )->where('patient_id', $data['patient_id'])->get();

            return response()->json(([
                'sys' => $data['sys'],
                'dis' => $data['dis'],
                'avg_sys' => $avgBp[0]['systolic'],
                'avg_dis' => $avgBp[0]['distolic'],
                'row_id' => $data['row_id']
            ]));
        }
    }

    public function view($id) {
        $patient = Patient::where('id', $id)->first();
        $bp = BloodPressure::select('systolic', 'distolic', 'read_date', 'read_time')->where('patient_id', $id)->paginate(10);
        $rbs = Rbs::select('rbs', 'read_date', 'read_time')->where('patient_id', $id)->paginate(10);
        $bmi = Weight::select('weight', 'bmi', 'read_date', 'read_time')->where('patient_id', $id)->paginate(10);
        $step = Step::select('steps', 'read_date', 'read_time')->where('patient_id', $id)->paginate(10);

        //BLOOD PRESSURE CHARTS
        $bpAvg = BloodPressure::select(
            'read_date',
            BloodPressure::raw('avg(systolic) as systolic'),
            BloodPressure::raw('avg(distolic) as distolic')
        )->where('patient_id', $id)->groupBy('read_date')->get();
        $systolic = $bpAvg->pluck('systolic', 'read_date');
        $distolic = $bpAvg->pluck('distolic', 'read_date');

        $cSystolic = new BloodPressureChart;
        $cSystolic->labels($systolic->keys());
        $cSystolic->dataset('Systolic', 'bar', $systolic->values())->backgroundColor('rgba(255, 0, 0, 0.5)');
        $cSystolic->dataset('Distolic', 'bar', $distolic->values())->backgroundColor('rgba(0, 255, 0, 0.5)');

        //RBS CHARTS
        $rbsAvg = Rbs::select(
            'read_date',
            Rbs::raw('avg(rbs) as rbs')
        )->where('patient_id', $id)->groupBy('read_date')->get();
        $rbsChart = $rbsAvg->pluck('rbs', 'read_date');

        $cRbs = new BloodPressureChart;
        $cRbs->labels($rbsChart->keys());
        $cRbs->dataset('Blood Suger Level', 'bar', $rbsChart->values())->backgroundColor('rgba(255, 190, 88, 0.7)');

        //WEIGHT AND BMI CHARTS
        $WeightAvg = Weight::select(
            'read_date',
            Weight::raw('avg(weight) as weight'),
            Weight::raw('avg(bmi) as bmi')
        )->where('patient_id', $id)->groupBy('read_date')->get();
        $weightChart = $WeightAvg->pluck('weight', 'read_date');
        $bmiChart = $WeightAvg->pluck('bmi', 'read_date');

        $cBmi = new BloodPressureChart;
        $cBmi->labels($weightChart->keys());
        $cBmi->dataset('Weight', 'bar', $weightChart->values())->backgroundColor('rgba(132, 140, 207, 0.8)');
        $cBmi->dataset('BMI', 'bar', $bmiChart->values())->backgroundColor('rgba(103, 65, 114, 0.8)');

        //STEPS CHARTS
        $stepChart=$step->pluck('steps', 'read_data');

        $cStep = new BloodPressureChart;
        $cStep->labels($stepChart->keys());
        $cStep->dataset('Steps', 'bar', $stepChart->values())->backgroundColor('rgba(39, 205, 245, 0.6)');

        $avgBp = BloodPressure::select(
            BloodPressure::raw('avg(systolic) as systolic'),
            BloodPressure::raw('avg(distolic) as distolic')
        )->where('patient_id', $id)->get();

        $avgBmi = Weight::select(
            Weight::raw('avg(bmi) as bmi')
        )->where('patient_id', $id)->get();

        return view('admin.operations.parameter.view', compact('patient', 'bp', 'rbs', 'bmi', 'step', 'cSystolic', 'cRbs', 'cBmi', 'avgBp', 'avgBmi', 'cStep'));
    }

    public function edit(Request $request, $id) {
        try {
            if (!empty($request->input('target'))) {
                Patient::where('id', $id)->update([
                    'step_target' => $request->input('target')
                ]);

                return redirect()->back()->with([
                    'success' => 'Steps Target Saved Successfully !!'
                ]);
            } else {
                return redirect()->back()->withInput($request->input())->with('error', 'Target cannot be empty !!');
            }

        } catch (\Exception $ex) {
            return redirect()->back()->withInput($request->input())->with('error', $ex->getMessage());
        }
    }

    public function showTransfer($id) {
        $patient = Patient::with('getCoach')->where('id', $id)->first();

        $coaches = Admin::
                   where('user_type', '>', 1)
                 ->where('id', '!=', auth()->guard('admin')->user()->id)
                 ->get()->toArray();
        
        $avgBp = BloodPressure::select(
            BloodPressure::raw('avg(systolic) as systolic'),
            BloodPressure::raw('avg(distolic) as distolic')
        )->where('patient_id', $id)->get();

        $avgBmi = Weight::select(
            Weight::raw('avg(bmi) as bmi')
        )->where('patient_id', $id)->get();

        return view('admin.operations.parameter.transfer', compact('patient', 'coaches', 'avgBp', 'avgBmi'));
    }

    public function getComplexName(Request $request) {
        if($request->ajax()) {
            $data = $request->all();

            $complex = Admin::with('getComplexName')->where('id', $data['coach_id'])->first();

            return response()->json(([
                'complex' => $complex['getComplexName']['name']
            ]));
        }
    }

    public function transfer(Request $request, $id) {
        try {
            if(!empty($request['coach_name'])) {
                $reciever_id = Admin::where('id', $request['coach_name'])->first();
                $sender = auth()->guard('admin')->user()->name;
                $sender_image = auth()->guard('admin')->user()->image_url;
                $patient = $request['name'];
                $uid = $request['uid'];
                $message = 'Request to Transfer Patient: ' . $request['name'] . ', ID No. ' . $request['uid'];


                Notification::send($reciever_id, new NewTransferRequest($sender, $message, $sender_image, $patient, $uid));

                return redirect()->back()->with([
                    'success' => 'Transfer Request Sent Successfully !!'
                ]);
            } else {
                return redirect()->back()->withInput($request->input())->with('error', 'Select Coach to Transfer !');
            }
        } catch (\Exception $ex) {
            return redirect()->back()->withInput($request->input())->with('error', $ex->getMessage());
        }
    }

    public function viewNotification() {
        return view('admin.operations.parameter.notification');
    }

    public function readNotification($id, $notifyId) {
        $coach = Admin::find($notifyId);
        $notification = $coach->unreadNotifications()->where('id', $id)->orderBy('created_at', 'DESC')->first();

        return view('admin.operations.parameter.readNotification', compact('notification'));
    }

    public function reject($id, $notifyId) {
        $coach = Admin::find($notifyId);
        $notification = $coach->unreadNotifications()->where('id', $id)->first();

        try {
            $notification->markAsRead();

            return redirect()->route('parameter.view.notification')->with([
                'success' => 'Request Rejected Successfully !!'
            ]);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function accept($id, $notifyId) {
        $coach = Admin::find($notifyId);
        $notification = $coach->unreadNotifications()->where('id', $id)->first();

        $complex = Admin::select('complex_id')->where('id', $notifyId)->first();

        try {
            Patient::where('uid', $notification['data']['uid'])->update([
                'coach_id' => $notifyId,
                'complex_id' => $complex['complex_id']
            ]);
            
            $notification->markAsRead();

            return redirect()->route('parameter.view.notification')->with([
                'success' => 'Request Accepted Successfully. Patient: ' . $notification['data']['patient'] . ' ID No. ' . $notification['data']['uid'] . ' transferred to your team !!'
            ]);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
