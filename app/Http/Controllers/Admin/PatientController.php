<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Complex;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index() {
        $patients = Patient::get()->toArray();
        return view('admin.operations.patient.index', compact('patients'));
    }

    public function show() {
        $complex = Complex::where('id', auth()->guard('admin')->user()->complex_id)->first();
        $coaches = Admin::where([
            'complex_id' => $complex['id'],
            'status' => 1
        ])->where('user_type', '>', 1)->get()->toArray();

        return view('admin.operations.patient.insert', compact('complex', 'coaches'));
    }
}
