<?php

namespace App\Http\Controllers\ExpoApp;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientParameter;
use Illuminate\Http\Request;

class PatientParametersController extends Controller
{
    public function gethealthParameters(Request $request) {
        $patient = Patient::where('id', $request->patientId)->first();
        $age = \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y');
        
        $systolic = PatientParameter::select('bp_systolic')
            ->where('patient_id', $request->patientId)
            ->where('bp_systolic', '!=', '')
            ->latest()
            ->first();
        $distolic = PatientParameter::select('bp_distolic')
            ->where('patient_id', $request->patientId)
            ->where('bp_distolic', '!=', '')
            ->latest()
            ->first();

        /*if(!$systolic && !$distolic) {
            $heartRate = null;
        } else {
            $heartRate = (($systolic['bp_systolic'] - $distolic['bp_distolic']) * 1.6) + 80;
        }*/

        $rbs = PatientParameter::select('rbs')
            ->where('patient_id', $request->patientId)
            ->where('rbs', '!=', '')
            ->latest()
            ->first();
        
        $bmi = PatientParameter::where('patient_id', $request->patientId)
        ->where('weight', '!=', '')
        ->where('bmi', '!=', '')
        ->avg('bmi');

        $weight = PatientParameter::select('weight')
            ->where('patient_id', $request->patientId)
            ->where('weight', '!=', '')
            ->where('bmi', '!=', '')
            ->latest()
            ->first();
        
        $steps = PatientParameter::select('steps')->where([
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
            'bp' => $systolic['bp_systolic'] . '/' . $distolic['bp_distolic'],
            //'heartRate' => number_format($heartRate),
            'rbs' => number_format($rbs['rbs']),
            'bmi' => number_format($bmi, 2),
            //'fat' => $fat,
            //'rWeight' => number_format($minWeight, 2) . ' - ' . number_format($maxWeight, 2),
            'weight' => number_format($weight['weight'], 2),
            'steps' => $steps
        ]);
    }

    public function gethealthParametersWithDate(Request $request) {
        $patient = Patient::where('id', $request->patientId)->first();
        $age = \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y');
        
        $systolic = PatientParameter::select('bp_systolic')
            ->where('patient_id', $request->patientId)
            ->where('bp_systolic', '!=', '')
            ->where('read_date', \Carbon\Carbon::now()->toDateString())
            ->latest()
            ->first();
        $distolic = PatientParameter::select('bp_distolic')
            ->where('patient_id', $request->patientId)
            ->where('bp_distolic', '!=', '')
            ->where('read_date', \Carbon\Carbon::now()->toDateString())
            ->latest()
            ->first();

        $rbs = PatientParameter::select('rbs')
            ->where('patient_id', $request->patientId)
            ->where('rbs', '!=', '')
            ->where('read_date', \Carbon\Carbon::now()->toDateString())
            ->latest()
            ->first();

        $weight = PatientParameter::select('weight')
            ->where('patient_id', $request->patientId)
            ->where('weight', '!=', '')
            ->where('bmi', '!=', '')
            ->where('read_date', \Carbon\Carbon::now()->toDateString())
            ->latest()
            ->first();

        $systolicWithDate = $systolic['bp_systolic'] ?? '';
        $distolicWithDate = $distolic['bp_distolic'] ?? '';
        $rbsWithDate = $rbs['rbs'] ?? 0;
        $wightWithDate = $weight['weight'] ?? 0.00;
        
        return response()->json([
            'age' => $age,
            'bp_sys' => $systolicWithDate,
            'bp_dis' => $distolicWithDate,
            'rbs' => number_format($rbsWithDate),
            'weight' => number_format($wightWithDate, 2),
        ]);
    }

    public function inserRbsResult(Request $request) {
        $parameter['patient_id'] = $request->id;
        $parameter['rbs'] = $request->patientRbs;
        $parameter['read_date'] = date('Y-m-d');
        $parameter['read_time'] = date('H:i:s');

        PatientParameter::create($parameter);
    
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getRbsData(Request $request) {
        $rbs = PatientParameter::select('rbs')
            ->where('patient_id', $request->patientId)
            ->where('rbs', '!=', '')
            ->latest()
            ->take(5)->get();
            
        return response()->json($rbs);
    }

    public function getRbsDetailsFromAPI(Request $request) {
        $rbs = PatientParameter::select('rbs', 'created_at')
            ->where('patient_id', $request->patientId)
            ->where('rbs', '!=', '')->get();

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

        PatientParameter::create($parameter);
    
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getWeightData(Request $request) {
        $weight = PatientParameter::select('weight')
            ->where('patient_id', $request->patientId)
            ->where('weight', '!=', '')
            ->where('bmi', '!=', '')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        return response()->json($weight);
    }

    public function getWeightDetailsFromAPI(Request $request) {
        $weight = PatientParameter::select('weight', 'bmi', 'created_at')
            ->where('patient_id', $request->patientId)
            ->where('weight', '!=', '')
            ->where('bmi', '!=', '')->get();

        info($weight);

        return response()->json($weight);
    }

    public function insertBpResult(Request $request) {
        info($request->all());

        $parameter['patient_id'] = $request->id;
        $parameter['bp_systolic'] = $request->systolic;
        $parameter['bp_distolic'] = $request->distolic;
        $parameter['read_date'] = date('Y-m-d');
        $parameter['read_time'] = date('H:i:s');

        PatientParameter::create($parameter);
    
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getBpData(Request $request) {
        $bp = PatientParameter::select('bp_systolic', 'bp_distolic')
            ->where('patient_id', $request->patientId)
            ->where('bp_systolic', '!=', '')
            ->where('bp_distolic', '!=', '')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        return response()->json($bp);
    }

    public function getBpDetailsFromAPI(Request $request) {
        $bp = PatientParameter::select('bp_systolic', 'bp_distolic', 'created_at')
            ->where('patient_id', $request->patientId)
            ->where('bp_systolic', '!=', '')
            ->where('bp_distolic', '!=', '')
            ->get();

        info($bp);

        return response()->json($bp);
    }

    public function insertSteps(Request $request) {

        $steps = PatientParameter::select('steps')->where([
            'patient_id' => $request->id,
            'read_date' => \Carbon\Carbon::now()->toDateString()
        ])->get();

        $parameter['patient_id'] = $request->id;
        $parameter['steps'] = $request->steps;
        $parameter['read_date'] = date('Y-m-d');
        $parameter['read_time'] = date('H:i:s');
        
        if(empty($steps) && $steps == null) {
            PatientParameter::create($parameter);   
        } else {
            PatientParameter::where([
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
