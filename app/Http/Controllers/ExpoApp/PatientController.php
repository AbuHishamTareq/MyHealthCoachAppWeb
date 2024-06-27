<?php

namespace App\Http\Controllers\ExpoApp;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    public function login(Request $request) {
        info($request->all());
        $request->validate([
            'userUid' => ['required', 'numeric', 'exists:patients'],
            'userPassword' => ['required'],
            'deviceName' => ['required']
        ]);

        $patient = Patient::where('uid', $request->userUid)->first();

        if(!$patient || !Hash::check($request->userPassword, $patient->password)) {
            throw ValidationException::withMessages([
                'uid' => ['The provided credentials are incorrect']
            ]);
        }

        return response()->json([
            'token' => $patient->createToken($request->deviceName)->plainTextToken
        ]);
    }
}
