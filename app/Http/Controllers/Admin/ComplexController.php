<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComplexRequest;
use Illuminate\Http\Request;
use App\Models\Complex;
use Exception;
use Auth;

class ComplexController extends Controller
{
    public function index() {
        $complexes = Complex::get()->toArray();
        return view('admin.operations.complex.index', compact('complexes'));
    }

    public function complex() {
        return view('admin.operations.complex.show');
    }

    public function insert(ComplexRequest $request) {
        try {

            $complex['name'] = $request->input('name');
            $complex['address'] = $request->input('address');
            $complex['region'] = $request->input('region');
            $complex['city'] = $request->input('city');
            $complex['phone_number'] = $request->input('phone');
            $complex['status'] = 0;
            $complex['created_by'] = auth()->guard('admin')->user()->id;
            Complex::create($complex);

            return redirect()->route('complex.index')->with([
                'success' => 'Complex added successfully !!'
            ]);

        } catch(\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
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

            Complex::where('id', $data['complex_id'])->update([
                'status' => $status
            ]);

            return response()->json(([
                'status' => $status,
                'complex_id' => $data['complex_id']
            ]));
        }
    }

    public function showUpdate($id) {
        $complex = Complex::find($id);
        return view('admin.operations.complex.update', compact('complex'));
    }

    public function update(ComplexRequest $request, $id) {
        try {
            Complex::where('id', $id)->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'region' => $request->input('region'),
                'city' => $request->input('city'),
                'phone_number' => $request->input('phone'),
                'updated_by' => auth()->guard('admin')->user()->id
            ]);

            return redirect()->route('complex.index')->with([
                'success' => 'Complex Updated successfully !!'
            ]);
        } catch(\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage()); 
        }
    }
}
