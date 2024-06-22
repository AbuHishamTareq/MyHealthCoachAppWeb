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
<form action="{{ route('coach.insert') }}" method="POST" enctype="multipart/form-data">@csrf
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <div class="form-group row pull-right">
                        <div>
                            <a href="{{ route('coach.index') }}" class="btn btn-primary">Cancel</a>
                            <button type="submit" class="btn btn-success">Save & Send</button>
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
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="complex_name" id="complex_name" value="{{ $complex['name'] }}" disabled>
                                </div>
                                @if (auth()->guard('admin')->user()->user_type == 2)
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="coach_name" id="coach_name" value="{{ auth()->guard()->user()->name }}" disabled>
                                </div>
                                @else
                                <div class="col-md-12 col-sm-12 form-group">
                                    <select name="coach_name" id="coach_name" class="form-control">
                                        <option value="">Select Health Coach</option>
                                        @foreach ($coaches as $coach)
                                        <option value="{{ $coach['id'] }}" {{ old("coach_name") == $coach['id'] ? "selected" : "" }}>{{ $coach['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-12 col-sm-12 form-group">
                                    <select name="blood_group" id="blood_group" class="form-control">
                                        <option value="">Select Blood Group</option>
                                        <option value="1" {{ old("blood_group") == 1 ? "selected" : "" }}>A+ (A Positive)</option>
                                        <option value="2" {{ old("blood_group") == 2 ? "selected" : "" }}>A- (A Negative)</option>
                                        <option value="3" {{ old("blood_group") == 3 ? "selected" : "" }}>B+ (B Positive)</option>
                                        <option value="4" {{ old("blood_group") == 4 ? "selected" : "" }}>B- (B Negative)</option>
                                        <option value="5" {{ old("blood_group") == 5 ? "selected" : "" }}>AB+ (AB Positive)</option>
                                        <option value="6" {{ old("blood_group") == 6 ? "selected" : "" }}>AB- (AB Negative)</option>
                                        <option value="7" {{ old("blood_group") == 7 ? "selected" : "" }}>O+ (O Positive)</option>
                                        <option value="8" {{ old("blood_group") == 8 ? "selected" : "" }}>O- (O Negative)</option>
                                    </select>
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