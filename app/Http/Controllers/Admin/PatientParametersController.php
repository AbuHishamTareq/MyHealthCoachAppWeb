<?php

namespace App\Http\Controllers\Admin;

use App\Charts\BloodPressureChart;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientParameter;
use Illuminate\Http\Request;

class PatientParametersController extends Controller
{
    public function show($id) {
        $patient = Patient::where('id', $id)->first();
        $bp = PatientParameter::select('bp_systolic', 'bp_distolic', 'read_date', 'read_time')->where('patient_id', $id)->paginate(10);
        $rbs = PatientParameter::select('rbs', 'read_date', 'read_time')->where('patient_id', $id)->paginate(10);
        $bmi = PatientParameter::select('weight', 'bmi', 'read_date', 'read_time')->where('patient_id', $id)->paginate(10);

        //BLOOD PRESSURE CHARTS
        $bpAvg = PatientParameter::select('read_date', 
                 PatientParameter::raw('avg(bp_systolic) as systolic'), 
                 PatientParameter::raw('avg(bp_distolic) as distolic'))->
                where('patient_id', $id)->groupBy('read_date')->get();
        $systolic = $bpAvg->pluck('systolic', 'read_date');
        $distolic = $bpAvg->pluck('distolic', 'read_date');

        $cSystolic = new BloodPressureChart;
        $cSystolic->labels($systolic->keys());
        $cSystolic->dataset('Systolic', 'bar', $systolic->values())->backgroundColor('rgba(255, 0, 0, 0.5)');
        $cSystolic->dataset('Distolic', 'bar', $distolic->values())->backgroundColor('rgba(0, 255, 0, 0.5)');
        
        //RBS CHARTS
        $rbsAvg = PatientParameter::select('read_date', 
                 PatientParameter::raw('avg(rbs) as rbs'))->
                where('patient_id', $id)->groupBy('read_date')->get() ;
        $rbsChart = $rbsAvg->pluck('rbs', 'read_date');
        
        $cRbs = new BloodPressureChart;
        $cRbs->labels($rbsChart->keys());
        $cRbs->dataset('Blood Suger Level', 'bar', $rbsChart->values())->backgroundColor('rgba(255, 190, 88, 0.7)');

        //BLOOD PRESSURE CHARTS
        $WeightAvg = PatientParameter::select('read_date', 
                 PatientParameter::raw('avg(weight) as weight'), 
                 PatientParameter::raw('avg(bmi) as bmi'))->
                where('patient_id', $id)->groupBy('read_date')->get();
        $weightChart = $WeightAvg->pluck('weight', 'read_date');
        $bmiChart = $WeightAvg->pluck('bmi', 'read_date');

        $cBmi = new BloodPressureChart;
        $cBmi->labels($weightChart->keys());
        $cBmi->dataset('Weight', 'bar', $weightChart->values())->backgroundColor('rgba(132, 140, 207, 0.8)');
        $cBmi->dataset('BMI', 'bar', $bmiChart->values())->backgroundColor('rgba(103, 65, 114, 0.8)');

        $avgBp = PatientParameter::select(
                    PatientParameter::raw('avg(bp_systolic) as systolic'), 
                    PatientParameter::raw('avg(bp_distolic) as distolic'))->
                where('patient_id', $id)->get();

        $avgBmi = PatientParameter::select( 
                    PatientParameter::raw('avg(bmi) as bmi'))->
                where('patient_id', $id)->get();

        return view('admin.operations.parameter.insert', compact('patient', 'bp', 'rbs', 'bmi', 'cSystolic', 'cRbs', 'cBmi', 'avgBp', 'avgBmi'));
    }

    public function insert(Request $request, $id) {
        try {
            $parameter['patient_id'] = $id;
            $parameter['bp_systolic'] = $request->input('bpSystolic');
            $parameter['bp_distolic'] = $request->input('bpDistolic');
            $parameter['rbs'] = $request->input('rbs');
            $parameter['weight'] = $request->input('pWeight');
            $parameter['bmi'] = $request->input('bmi');
            $parameter['read_date'] = date('Y-m-d');
            $parameter['read_time'] = date('H:i:s');

            PatientParameter::create($parameter);

            return redirect()->back()->with([
                'success' => 'Health Parameters Saved Successfully !!'
            ]);
        } catch(\Exception $ex) {
            return redirect()->back()->withInput($request->input())->with('error', $ex->getMessage());
        }
    }
}
