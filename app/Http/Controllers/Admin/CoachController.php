<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\CoachRequest;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Complex;
use App\Models\UserType;
use Illuminate\Support\Facades\Mail;

class CoachController extends Controller
{
    public function index() {
        $coaches = Admin::with('getComplexName', 'getRole')->where('user_type', '!=', '0')->get()->toArray();
        return view('admin.operations.coach.index', compact('coaches'));
    }

    public function show() {
        $complexes = Complex::get()->toArray();
        $roles = UserType::get()->toArray();
        return view('admin.operations.coach.insert', compact('complexes', 'roles'));
    }

    public function insert(CoachRequest $request) {
        try {
            $coach['uid'] = $request->input('uid');
            $coach['email'] = $request->input('email');
            $coach['password'] = bcrypt($request->input('password'));
            $coach['name'] = $request->input('name');
            $coach['address'] = $request->input('address');
            $coach['mobile'] = $request->input('phone');
            $coach['user_type'] = $request->input('user_role');
            $coach['complex_id'] = $request->input('complex_name');
            $coach['created_by'] = auth()->guard('admin')->user()->id;

            if($request->has('photo')) {
                $request->validate([
                    'photo' => 'mimes:png,jpg,jpeg|max:1000'
                ]);

                $file_path = uploadImage('assets/admin/upload', $request->photo);

                $coach['image_url'] = $file_path;
            }

            Admin::create($coach);

            $mailData = [
                'title' => 'Welcome to My Health Coach App',
                'username' => $request->input('email'),
                'password' => $request->input('password'),
                'message' => 'Please don\'t share your account details',
                'footer' => 'My Health Coach Team'
            ];

            Mail::to($request->input('email'))->send(new SendEmail($mailData));

            return redirect()->route('coach.index')->with([
                'success' => 'Data Saved and Email Sent to ' . $request->input('email') . ' Successfully !!'
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

            Admin::where('id', $data['coach_id'])->update([
                'status' => $status
            ]);

            return response()->json(([
                'status' => $status,
                'coach_id' => $data['coach_id']
            ]));
        }
    }

    public function showUpdate($id) {
        $coach = Admin::find($id);
        $complexes = Complex::get()->toArray();
        $roles = UserType::get()->toArray();
        return view('admin.operations.coach.update', compact('coach', 'complexes', 'roles'));
    }

    public function update(AdminRequest $request, $id) {
        try {
            $coach = Admin::find($id);

            $old_photo = $coach->image_url;

            if($request->has('photo')) {
                $request->validate([
                    'photo' => 'mimes:png,jpg,jpeg|max:1000'
                ]);

                $file_path = uploadImage('assets/admin/upload', $request->photo);

                if(file_exists('assets/admin/upload/' . $old_photo)) {
                    unlink('assets/admin/upload/' . $old_photo);
                }
            } else {
                $file_path = $coach->image_url;
            }
            
            Admin::where('id', $id)->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'mobile' => $request->input('phone'),
                'user_type' => $request->input('user_role'),
                'complex_id' => $request->input('complex_name'),
                'updated_by' => auth()->guard('admin')->user()->id,
                'image_url' => $file_path,
            ]);

            return redirect()->route('coach.index')->with([
                'success' => 'Data Updated Successfully !!'
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
