@extends('layouts.index')
@section('title')
My Health Coach | Insert Patient
@endsection
@section('class')
class="nav-md footer_fixed"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left mb-2">
        <h3>Operations | Patient</h3>
    </div>
</div>
<div class="clearfix"></div>
@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">Failed to Save & Send:</h4>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <hr>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger" role="alert">
    <strong>Error: </strong>{{ Session::get('error') }}
    <hr>
</div>
@endif
<form action="{{ route('patient.insert') }}" method="POST">@csrf
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <input type="hidden" name="complex_id" id="complex_id" value="{{ $complex['id'] }}">
            <div class="x_panel">
                <div class="x_title">
                    <div class="form-group row pull-right">
                        <div>
                            <a href="{{ route('patient.index') }}" class="btn btn-primary">Cancel</a>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <div class="col-md-6 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="uid" id="uid" placeholder="ID / Iqama No." value="{{ old('uid') }}">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Patient Name" value="{{ old('name') }}">
                                </div>
                                <div class="col-md-6 col-sm-6 form-group">
                                    <input type="text" class="form-control" name="region" id="region" placeholder="Region" value="{{ old('region') }}">
                                </div>
                                <div class="col-md-6 col-sm-6 form-group">
                                    <input type="text" class="form-control" name="city" id="city" placeholder="City" value="{{ old('city') }}">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ old('address') }}">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <div class="item form-group text-center">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div id="gender" class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-secondary mr-2" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="gender" id="genderM" value="M" class="join-btn"> &nbsp; Male &nbsp;
                                            </label>
                                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="gender" id="genderF" value="F" class="join-btn"> Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="complex_name" id="complex_name" value="{{ $complex['name'] }}" disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 form-group">
                                    <select name="coach_name" id="coach_name" class="form-control">
                                        <option value="">Select Health Coach</option>
                                        @foreach ($coaches as $coach)
                                        <option
                                            @if (auth()->guard('admin')->user()->user_type == 2)
                                            value = "{{ auth()->guard('admin')->user()->id }}"
                                            {{ auth()->guard('admin')->user()->id == $coach['id'] ? "selected" : "" }}
                                            @else
                                            value="{{ $coach['id'] }}"
                                            {{ old("coach_name") == $coach['id'] ? "selected" : "" }}
                                            @endif
                                        >
                                            {{ $coach['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 col-sm-12 form-group">
                                    <select name="blood_group" id="blood_group" class="form-control">
                                        <option value="">Select Blood Group</option>
                                        <option value="A+" {{ old("blood_group") == 1 ? "selected" : "" }}>A+ (A Positive)</option>
                                        <option value="A-" {{ old("blood_group") == 2 ? "selected" : "" }}>A- (A Negative)</option>
                                        <option value="B+" {{ old("blood_group") == 3 ? "selected" : "" }}>B+ (B Positive)</option>
                                        <option value="B-" {{ old("blood_group") == 4 ? "selected" : "" }}>B- (B Negative)</option>
                                        <option value="AB+" {{ old("blood_group") == 5 ? "selected" : "" }}>AB+ (AB Positive)</option>
                                        <option value="AB-" {{ old("blood_group") == 6 ? "selected" : "" }}>AB- (AB Negative)</option>
                                        <option value="O+" {{ old("blood_group") == 7 ? "selected" : "" }}>O+ (O Positive)</option>
                                        <option value="O-" {{ old("blood_group") == 8 ? "selected" : "" }}>O- (O Negative)</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-sm-12 form-group">
                                    <input class="form-control date" type="date" name="dob" id="dob" value="{{ old('dob') }}">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="pHeight" id="pHeight" value="{{ old('pHeight') }}" placeholder="Height (cm)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection