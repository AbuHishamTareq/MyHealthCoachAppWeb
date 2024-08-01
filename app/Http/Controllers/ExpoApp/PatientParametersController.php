<?php

namespace App\Http\Controllers\ExpoApp;

use App\Http\Controllers\Controller;
use App\Models\BloodPressure;
use App\Models\Patient;
use App\Models\Rbs;
use App\Models\Step;
use App\Models\Weight;
use Illuminate\Http\Request;

class PatientParametersController extends Controller
{
    public function gethealthParameters(Request $request) {
        $patient = Patient::where('id', $request->patientId)->first();
        $age = \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y');
        
        $bp = BloodPressure::select('systolic', 'distolic')
            ->where('patient_id', $request->patientId)
            ->latest()->first();

        $systolic = $bp['systolic'] ?? 0;
        $distolic = $bp['distolic'] ?? 0;

        /*if(!$systolic && !$distolic) {
            $heartRate = null;
        } else {
            $heartRate = (($systolic['bp_systolic'] - $distolic['bp_distolic']) * 1.6) + 80;
        }*/

        $rbs = Rbs::select('rbs')
            ->where('patient_id', $request->patientId)
            ->latest()
            ->first();
        
        $rbsValue = $rbs['rbs'] ?? 0;
        
        $bmi = Weight::where('patient_id', $request->patientId)
        ->avg('bmi');

        $bmiValue = number_format($bmi, 2) ?? 0;

        $weight = Weight::select('weight')
            ->where('patient_id', $request->patientId)
            ->latest()
            ->first();

        $weightValue = number_format($weight['weight'], 2) ?? 0;
        
        $steps = Step::select('steps')->where([
            'patient_id' => $request->patientId,
            'read_date' => \Carbon\Carbon::now()->toDateString()
        ])
        ->latest()
        ->first();

        $steps = $steps['steps'] ?? 0;

        /*if($patient['gender'] == 'M') {
            $fat = number_format((1.20 * $bmi) + (0.23 * $age) - 16.2, 2);
        } elseif ($patient['gender'] == 'F') {
            $fat = number_format((1.20 * $bmi) + (0.23 * $age) - 5.4, 2);
        }*/

        /*$minWeight = 18.5 * (($patient['height'] / 100)^2);
        $maxWeight = 24.9 * (($patient['height'] / 100)^2);*/
        

        return response()->json([
            'age' => $age,
            'bp' => $systolic . '/' . $distolic,
            //'heartRate' => number_format($heartRate),
            'rbs' => $rbsValue,
            'bmi' => $bmiValue,
            //'fat' => $fat,
            //'rWeight' => number_format($minWeight, 2) . ' - ' . number_format($maxWeight, 2),
            'weight' => $weightValue,
            'steps' => $steps
        ]);
    }

    public function gethealthParametersWithDate(Request $request) {
        $patient = Patient::where('id', $request->patientId)->first();
        $age = \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y');

        $bp = BloodPressure::select('systolic', 'distolic')
            ->where('patient_id', $request->patientId)
            ->where('read_date', \Carbon\Carbon::now()->toDateString())
            ->latest()->first();

            $systolic = $bp['systolic'] ?? 0;
            $distolic = $bp['distolic'] ?? 0;

        $rbs = Rbs::select('rbs')
            ->where('patient_id', $request->patientId)
            ->where('read_date', \Carbon\Carbon::now()->toDateString())
            ->latest()->first();

        $rbsValue = $rbs['rbs'] ?? 0;

        $weight = Weight::select('weight')
            ->where('patient_id', $request->patientId)
            ->where('read_date', \Carbon\Carbon::now()->toDateString())
            ->latest()->first();
        
        $weightValue = $weight['weight'] ?? 0.00;
        
        return response()->json([
            'age' => $age,
            'bp_sys' => $systolic,
            'bp_dis' => $distolic,
            'rbs' => $rbsValue,
            'weight' => number_format($weightValue, 2),
        ]);
    }

    public function inserRbsResult(Request $request) {
        $parameter['patient_id'] = $request->id;
        $parameter['rbs'] = $request->patientRbs;
        $parameter['read_date'] = date('Y-m-d');
        $parameter['read_time'] = date('H:i:s');

        Rbs::create($parameter);
    
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getRbsData(Request $request) {
        $rbs = Rbs::select('rbs')
            ->where('patient_id', $request->patientId)
            ->latest()
            ->take(5)->get();
            
        return response()->json($rbs);
    }

    public function getRbsDetailsFromAPI(Request $request) {
        $rbs = Rbs::select('rbs', 'created_at')
            ->where('patient_id', $request->patientId)
            ->get();

        return response()->json($rbs);
    }

    public function insertWeightResult(Request $request) {
        $height = Patient::select('height')->where('id', $request->id)->first();

        $bmi = $request->pWeight / (($height['height']/100) * ($height['height']/100));

        $parameter['patient_id'] = $request->id;
        $parameter['weight'] = $request->pWeight;
        $parameter['bmi'] = $bmi;
        $parameter['read_date'] = date('Y-m-d');
        $parameter['read_time'] = date('H:i:s');

        Weight::create($parameter);
    
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getWeightData(Request $request) {
        $weight = Weight::select('weight')
            ->where('patient_id', $request->patientId)
            ->orderBy('created_at', 'DESC')
            ->limit(5)->get();

        return response()->json($weight);
    }

    public function getWeightDetailsFromAPI(Request $request) {
        $weight = Weight::select('weight', 'bmi', 'created_at')
            ->where('patient_id', $request->patientId)
            ->get();

        return response()->json($weight);
    }

    public function insertBpResult(Request $request) {
        $parameter['patient_id'] = $request->id;
        $parameter['systolic'] = $request->systolic;
        $parameter['distolic'] = $request->distolic;
        $parameter['read_date'] = date('Y-m-d');
        $parameter['read_time'] = date('H:i:s');

        BloodPressure::create($parameter);
    
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getBpData(Request $request) {
        $bp = BloodPressure::select('systolic', 'distolic')
            ->where('patient_id', $request->patientId)
            ->orderBy('created_at', 'DESC')
            ->limit(5)->get();

        return response()->json($bp);
    }

    public function getBpDetailsFromAPI(Request $request) {
        $bp = BloodPressure::select('systolic', 'distolic', 'created_at')
            ->where('patient_id', $request->patientId)
            ->get();

        return response()->json($bp);
    }

    public function insertSteps(Request $request) {
        $steps = Step::select('steps')->where([
            'patient_id' => $request->id,
            'read_date' => \Carbon\Carbon::now()->toDateString()
        ])->first();

        if(empty($steps) && $steps == null) {
            $parameter['patient_id'] = $request->id;
            $parameter['steps'] = $request->steps;
            $parameter['read_date'] = date('Y-m-d');
            $parameter['read_time'] = date('H:i:s');

            Step::create($parameter);
        } else {
            Step::where([
                'patient_id' => $request->id,
                'read_date' => \Carbon\Carbon::now()->toDateString()
                ])->update([
                    'steps' => $request->steps,
                ]);
        }
    
        return response()->json([
            'status' => 'success'
        ]);
    }
}
