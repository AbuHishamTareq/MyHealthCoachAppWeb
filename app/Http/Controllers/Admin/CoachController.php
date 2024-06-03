<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class CoachController extends Controller
{
    public function index() {
        $coaches = Admin::where('user_type', '!=', '0')->get()->toArray();
        return view('admin.operations.coach.index', compact('coaches'));
    }

    public function show() {
        return view('admin.operations.coach.insert');
    }
}
