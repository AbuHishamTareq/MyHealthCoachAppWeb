<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTypeRequest;
use App\Models\UserType;
use Exception;

class UserTypeController extends Controller
{
    public function index() {
        $roles = UserType::with('getCreatedBy', 'getUpdatedBy')->get()->toArray();
        //dd($roles); die();
        return view('admin.settings.roles.index', compact('roles'));
    }

    public function role() {
        return view('admin.settings.roles.role');
    }

    public function insert(UserTypeRequest $request) {
        try {

            $insert_role['role'] = $request->input('user_role');
            $insert_role['created_by'] = auth()->guard('admin')->user()->id;

            UserType::create($insert_role);

            return redirect()->route('usertype.index')->with([
                'success' => 'Data saved successfully !'
            ]);
        } catch(Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
