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
        $request->validate([
            'userUid' => ['required', 'numeric'],
            'userPassword' => ['required'],
            'deviceName' => ['required']
        ]);

        if(Patient::where('uid', $request->userUid)->exists()) {
            $patient = Patient::where('uid', $request->userUid)->first();

            if(!Hash::check($request->userPassword, $patient->password)) {
                throw ValidationException::withMessages([
                    'uid' => ['Password incorrect']
                ]);
            }

            return response()->json([
                'token' => $patient->createToken($request->deviceName)->plainTextToken
            ]);

        } else {
            throw ValidationException::withMessages([
                'uid' => ['ID / Iqama No. not Found']
            ]);
        }
    }

    public function getPatient(Request $request) {
        return $request->user();
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }

    public function forgetPassword(){
        //
    }
}
