@extends('layouts.index')
@section('title')
My Health Coach | Update Health Coach
@endsection
@section('class')
class="nav-md footer_fixed"
@endsection
@section('content')
<div class="page-title">
    <div class="title_left mb-2">
        <h3>Operations | Health Coach</h3>
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
<form action="{{ route('coach.update', $coach['id']) }}" method="POST" enctype="multipart/form-data">@csrf
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <div class="form-group row pull-right">
                        <div>
                            <a href="{{ route('coach.index') }}" class="btn btn-primary">Cancel</a>
                            <button type="submit" class="btn btn-success">Update</button>
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
                                    <input type="text" class="form-control" name="uid" id="uid" placeholder="UID" value="{{ $coach['uid'] }}" readonly>
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Coach Name" value="{{ $coach['name'] }}">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="specialist" id="specialist" placeholder="Specialist" value="{{ $coach['specialist'] }}">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email Address" value="{{ $coach['email'] }}" readonly>
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Email Address" value="{{ $coach['password'] }}" readonly>
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $coach['address'] }}">
                                </div>
                                <div class="col-md-12 col-sm-12  form-group">
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="{{ $coach['mobile'] }}">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <select name="complex_name" id="complex_name" class="form-control">
                                            <option value="">Select Complex</option>
                                            @foreach ($complexes as $complex)
                                            <option value="{{ $complex['id'] }}" {{ $coach["complex_id"] == $complex['id'] ? "selected" : "" }}>{{ $complex['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <select name="user_role" id="user_role" class="form-control">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role['id'] }}" {{ $coach["user_type"] == $role['id'] ? "selected" : "" }}>{{ $role['role'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6">
                                        @if (empty($coach['image_url']) || $coach['image_url'] == null)
                                        <img src="{{ asset('assets/admin/images/user.png') }}" name="coach_image" id="coach_image" alt="..." class="img-circle" style="width: 150px">
                                        @else
                                        <img src="{{ asset('assets/admin/upload/' . $coach['image_url']) }}" name="coach_image" id="coach_image" alt="..." class="img-circle" style="width: 150px"> 
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <button type="button" class="btn btn-success" id="change-image">Change Coach Image</button>
                                        <button type="button" class="btn btn-danger" style="display: none" image-url="{{ $coach['image_url'] }}" id="cancel-change">Cancel changes</button>
                                    </div>
                                    <div id="old-image"></div>
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