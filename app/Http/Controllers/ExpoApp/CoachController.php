<?php

namespace App\Http\Controllers\ExpoApp;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function getHealthCoaches() {
        $coaches = Admin::where([
            'status' => 1,
        ])->where('user_type', '>', 0)->inRandomOrder()->limit(5)->get();
        return response()->json($coaches);
    }
}
