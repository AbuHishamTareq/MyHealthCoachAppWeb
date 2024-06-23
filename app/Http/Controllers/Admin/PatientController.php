<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\PatientRequest;
use App\Imports\PatientImport;
use App\Jobs\ImportPatients;
use App\Models\Admin;
use App\Models\Complex;
use App\Models\Patient;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PatientController extends Controller
{
    public function index() {
        $coaches = Admin::where('user_type', '>', 1)->
            where('status', 1)->get()->toArray();

        $patients = Patient::with('getComplex', 'getCoach')->paginate(10);

        return view('admin.operations.patient.index', compact('patients', 'coaches'));
    }

    public function show() {
        $complex = Complex::where('id', auth()->guard('admin')->user()->complex_id)->first();
        $coaches = Admin::where([
            'complex_id' => $complex['id'],
            'status' => 1
        ])->where('user_type', '>', 1)->get()->toArray();

        return view('admin.operations.patient.insert', compact('complex', 'coaches'));
    }

    public function insert(PatientRequest $request) {
        try {
            $patient['uid'] = $request->input('uid');
            $patient['name'] = $request->input('name');
            $patient['gender'] = $request->input('gender');
            $patient['password'] = bcrypt('123456');
            $patient['mobile'] = $request->input('phone');
            $patient['region'] = $request->input('region');
            $patient['city'] = $request->input('city');
            $patient['address'] = $request->input('address');
            $patient['blood_group'] = $request->input('blood_group');
            $patient['coach_id'] = $request->input('coach_name');
            $patient['complex_id'] = $request->input('complex_id');
            $patient['birth_date'] = $request->input('dob');
            $patient['status'] = 0;
            $patient['created_by'] = auth()->guard('admin')->user()->id;

            Patient::create($patient);

            return redirect()->route('patient.index')->with([
                'success' => 'Data Saved Successfully !!'
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->withInput($request->input())->with('error', $ex->getMessage());
        }
    }

    public function updateStatus(Request $request) {
        if($request->ajax()) {
            $data = $request->all();

            if($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }

            Patient::where('id', $data['patient_id'])->update([
                'status' => $status
            ]);

            return response()->json(([
                'status' => $status,
                'patient_id' => $data['patient_id']
            ]));
        }
    }

    public function showImport() {
        return view('admin.operations.patient.import');
    }

    public function showProgress() {
        return view('admin.operations.patient.progress');
    }

    public function import(ImportRequest $request) {
        try{
            Excel::import(new PatientImport, request()->file('importFile'));

            return redirect()->route('patient.index')->with([
                'success' => 'Data Imported Successfully !!'
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function downloadTemplate() {
        $fileName = 'example.xlsx';
        $path = 'assets/admin/files/' . $fileName;

        if(file_exists($path)) {
            return response()->download($path, $fileName, [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'inline, filename="' . $fileName . '"'
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'File not found !!'
            ]);
        }
    }

    public function ajaxSearch(Request $request) {
        if($request->ajax()) {
            $searchPName = $request->searchPName;
            $searchUID = $request->searchUID;
            $searchPhone = $request->searchPhone;
            $searchGender = $request->searchGender;
            $searchCoach = $request->searchCoach;

            if($searchPName == "") {
                $field1 = 'id';
                $operator1 = '>';
                $value1 = 0;
            } else {
                $field1 = 'name';
                $operator1 = 'LIKE';
                $value1 = "%{$searchPName}%";
            }

            if($searchUID == "") {
                $field2 = 'id';
                $operator2 = '>';
                $value2 = 0;
            } else {
                $field2 = 'uid';
                $operator2 = 'LIKE';
                $value2 = "%{$searchUID}%";
            }

            if($searchPhone == "") {
                $field3 = 'id';
                $operator3 = '>';
                $value3 = 0;
            } else {
                $field3 = 'mobile';
                $operator3 = 'LIKE';
                $value3 = "%{$searchPhone}%";
            }

            if($searchGender == "All") {
                $field4 = 'id';
                $operator4 = '>';
                $value4 = 0;
            } else {
                $field4 = 'gender';
                $operator4 = '=';
                $value4 = $searchGender;
            }

            if($searchCoach == "All") {
                $field5 = 'id';
                $operator5 = '>';
                $value5 = 0;
            } else {
                $field5 = 'coach_id';
                $operator5 = '=';
                $value5 = $searchCoach;
            }

            $data = Patient::with('getComplex', 'getCoach')->
                where($field1, $operator1, $value1)->
                where($field2, $operator2, $value2)->
                where($field3, $operator3, $value3)->
                where($field4, $operator4, $value4)->
                where($field5, $operator5, $value5)->
                orderBy('created_at', 'ASC')->paginate(10);
            return view('admin.operations.patient.ajaxSearch', ['patients' => $data]);
        }
    }
}
